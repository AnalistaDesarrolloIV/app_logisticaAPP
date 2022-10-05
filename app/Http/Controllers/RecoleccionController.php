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
    public function loginPick()
    {
        session_start();
        try {

            $_SESSION['H_I_REC'] = '';
            $pedido = Http::retry(30, 5, throw: false)->withToken($_SESSION['B1SESSION'])->get('https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA?$apply=groupby((DocEntry,CardCode,CardName,DocDate,BaseRef,DocNum,Departamento,Municipio_Ciudad,U_IV_ESTA,U_IV_Prioridad,U_IV_OPERARIO))')['value'];
            
            $pedido_bio = Http::retry(30, 5, throw: false)->withToken($_SESSION['B1SESSION'])->get('https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA2?$apply=groupby((DocEntry,CardCode,CardName,DocDate,BaseRef,DocNum,Departamento,Municipio_Ciudad,U_IV_ESTA,U_IV_Prioridad,U_IV_OPERARIO))')['value'];
            
            $datExtra = Http::retry(30, 5, throw: false)->withToken($_SESSION['B1SESSION'])->get('https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA1')['value'];
            
            return view('picking.ListPedidos', compact('pedido', 'datExtra', 'pedido_bio'));
        
        } catch (\Throwable $th) {
            session_destroy();
            setcookie('USER', '', time()-43200);
            setcookie('USER_ROL', '', time()-43200);
            Alert::warning('¡La sección expiro!', 'Por favor vuleve a acceder');
            return redirect('/');
        }
    }

    public function indexPick($id, $DL)
    {
        
        session_start();
        try {
            if ($_SESSION['H_I_REC'] == '') {
                $fecha_hora = new DateTime("now", new DateTimeZone('America/Bogota'));
    
                $_SESSION['H_I_REC'] = $fecha_hora->format('H:i:s');    
            }

            $ped = Http::retry(30, 5, throw: false)->withToken($_SESSION['B1SESSION'])->get('https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA?$filter=BaseRef eq '."('".$id."')")['value'];
            
            $invoices = DB::connection('sqlsrv2')->table('Historico')->where('Pedido', $id)
            ->select('ID historico','Articulo Efectuado','Descripcion Articulo', 'Lote', 'Cantidad', 'Bahia', 'Compartimento')->get();

            $invoices = $invoices->all();
            
            $datExtra = Http::retry(30, 5, throw: false)->withToken($_SESSION['B1SESSION'])->get("https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA1?".'$filter=BaseRef eq '."'".$id."'")['value'];
            
            return view('picking.DetallePedido', compact('ped', 'id', 'DL', 'invoices', 'datExtra'));
       
        } catch (\Throwable $th) {
            session_destroy();
            setcookie('USER', '', time()-43200);
            setcookie('USER_ROL', '', time()-43200);
            Alert::warning('¡La sección expiro!', 'Por favor vuleve a acceder');
            return redirect('/');
        }
    }

    public function savePick($id, $DL)
    { 
        session_start();
        try {
            $session = Http::retry(30, 5, throw: false)->post('https://10.170.20.95:50000/b1s/v1/Login',[
                'CompanyDB' => 'INVERSIONES',
                'UserName' => 'Desarrollos',
                'Password' => 'Asdf1234$',
            ])['SessionId'];

            $state = "Recogido";
    
            $ped = Http::retry(30, 5, throw: false)->withToken($session)->get("https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA?".'$filter '."=BaseRef eq ('".$id."')")['value'];
            
            $Nped = $ped[0]['DocEntry'];
            $H_F_REC = new DateTime("now", new DateTimeZone('America/Bogota'));

            $pedC = Http::retry(30, 5, throw: false)->withToken($session)->get("https://10.170.20.95:50000/b1s/v1/DeliveryNotes(".$Nped.")".'?$select='."U_IV_INIREC,U_IN_FINREC")->json();
            
            $horaI = $pedC['U_IV_INIREC'];
            $horaF = $pedC['U_IN_FINREC'];

            if ($horaI == '' && $horaF == '') {
                $gard = Http::retry(30, 5, throw: false)->withToken($session)->patch("https://10.170.20.95:50000/b1s/v1/DeliveryNotes(".$Nped.")", [
                    "U_IV_FECHREC"=>$H_F_REC->format('Y-m-d'),
                    "U_IV_INIREC"=> $_SESSION['H_I_REC'],
                    "U_IN_FINREC"=> $H_F_REC->format('H:i:s'),
                    "U_IV_PATINADOR"=> $_COOKIE['USER']
                ]);
            }
            
            foreach ( $ped  as $key => $value ) {
                $itemCode = $value['ItemCode'];
                $LNum = $value['LineNum'];
    
                    $gard2 = Http::retry(30, 5, throw: false)->withToken($session)->patch("https://10.170.20.95:50000/b1s/v1/DeliveryNotes(".$Nped.")", [
                        "DocumentLines"=> [
                            [
                                "LineNum"=> $LNum,
                                "ItemCode"=> $itemCode,
                                "U_IV_ESTA"=> $state                        
                            ]
                        ]
                    ]);
            }
            Alert::success('¡Guardado!', "Recolección finalizada exitosamente.");
            return redirect()->route('opciones');
            
        } catch (\Throwable $th) {
            session_destroy();
            setcookie('USER', '', time()-43200);
            setcookie('USER_ROL', '', time()-43200);
            Alert::warning('¡La sección expiro!', 'Por favor vuleve a acceder');
            return redirect('/');
        }
    }


}
