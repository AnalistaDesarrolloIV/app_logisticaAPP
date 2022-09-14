<?php

namespace App\Http\Controllers;

use App\Http\Requests\login;
use App\Models\Empleados;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class RecoleccionController extends Controller
{
    public function logPick()
    {
        return view('picking.loginPicking');
    }
    public function loginPick(login $request)
    {
        try {
            session_start();
            $response = Http::retry(20 ,300)->post('https://10.170.20.95:50000/b1s/v1/Login',[
                'CompanyDB' => 'INVERSIONES',
                'UserName' => 'Desarrollos',
                'Password' => 'Asdf1234$',
            ])->json();

            $_SESSION['B1SESSION'] = $response['SessionId'];
                // dd($_SESSION['B1SESSION']);

                $input = $request->all();
                $identificador = $input['documento'];
                $emp = Empleados::all();
                foreach ($emp as $key => $value) {
                    if ($value['OPE_OPERATORE'] == $identificador) {
                        $_SESSION['EMPLEADO_R'] = $value;
                        $_SESSION['H_I_REC'] = '';
                        $pedido = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->get('https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA?$apply=groupby((CardCode,CardName,DocDate,BaseRef,DocNum,Departamento,Municipio_Ciudad,U_IV_ESTA))')->json();
                        $pedido = $pedido['value'];
                        // dd($pedido);
                        Alert::success('Bienvenid@', $_SESSION['EMPLEADO_R']['OPE_OPERATORE']);
                        return view('picking.ListPedidos', compact('pedido'));
                    }
                }
                Alert::error('¡Error!', 'Usuario no existe');
                return Redirect()->route('logPick');
        } catch (\Throwable $th) {
           Alert::warning('¡La sección expiro!', 'Por favor vuleve a acceder');
           return redirect()->route('logPick');
        }
    }

    public function indexPick($id)
    {
        
        session_start();
        try {
            if ($_SESSION['H_I_REC'] == '') {
                $fecha_hora = new DateTime("now", new DateTimeZone('America/Bogota'));
    
                $_SESSION['H_I_REC'] = $fecha_hora->format('H:i:s');    
            }

                $ped = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->get('https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA?$filter=BaseRef eq '."('".$id."')")->json();
                $ped = $ped['value'];
                
                $invoices = DB::connection('sqlsrv2')->table('Historico')->where('Pedido', $id)
                ->select('ID historico','Articulo Efectuado','Descripcion Articulo', 'Lote', 'Cantidad', 'Bahia', 'Compartimento')->get();
                $invoices = $invoices->all();


                return view('picking.DetallePedido', compact('ped', 'id', 'invoices'));
        } catch (\Throwable $th) {
            Alert::warning('¡La secciÃ³n expiro!', 'Por favor vuleve a acceder');
            return redirect()->route('logPick');
        }
    }

    public function savePick($id)
    { 
        try { 
            session_start();
            $response = Http::retry(20 ,300)->post('https://10.170.20.95:50000/b1s/v1/Login',[
                'CompanyDB' => 'INVERSIONES',
                'UserName' => 'Desarrollos',
                'Password' => 'Asdf1234$',
            ])->json();
    
            $_SESSION['B1SESSION'] = $response['SessionId'];
            
            $state = "Recogido";
    
            $ped = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->get("https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA?".'$filter '."=BaseRef eq ('".$id."')")->json();
            $ped = $ped['value'];
            
            $H_F_REC = new DateTime("now", new DateTimeZone('America/Bogota'));
    
            $lapsoR = "inicio de recolecciÃ³n ".$_SESSION['H_I_REC']." ---- Hora fin recolecciÃ³n ".$H_F_REC->format('H:i:s');
             
    
            foreach ( $ped  as $key => $value ) {
                $identi = $value['DocEntry']; 
                $linenum = $value['LineNum'];
                $itemCode = $value['ItemCode'];
    
    
                $gard = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->patch("https://10.170.20.95:50000/b1s/v1/DeliveryNotes(".$identi.")", [
                    "U_IV_FECHREC"=>$H_F_REC->format('Y-m-d'),
                    "U_IV_INIREC"=> $_SESSION['H_I_REC'],
                    "U_IN_FINREC"=> $H_F_REC->format('H:i:s'),
                    "DocumentLines"=> [
                        [
                            "LineNum"=> $linenum,
                            "ItemCode"=> $itemCode,
                            "U_IV_ESTA"=> "Recogido"                        ]
                    ]
                ])->json();
            }
            session_destroy();
            Alert::success('¡Guardado!', "Recolección finalizada exitosamente.");
            return redirect('/');
        } catch (\Throwable $th) {
           session_destroy();
           Alert::warning('¡La sección expiro!', 'Por favor vuleve a acceder');
           return redirect()->route('logPick');
        }
       
        
    }
}
