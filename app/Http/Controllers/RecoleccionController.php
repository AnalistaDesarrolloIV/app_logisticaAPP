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
            $pedido = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->get('https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA?$apply=groupby((DocEntry,CardCode,CardName,DocDate,BaseRef,DocNum,Departamento,Municipio_Ciudad,U_IV_ESTA,U_IV_Prioridad,U_IV_OPERARIO))')->json();
            $pedido = $pedido['value'];

            $pedido_bio = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->get('https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA2?$apply=groupby((DocEntry,CardCode,CardName,DocDate,BaseRef,DocNum,Departamento,Municipio_Ciudad,U_IV_ESTA,U_IV_Prioridad,U_IV_OPERARIO))')->json();
            $pedido_bio = $pedido_bio['value'];
            
            $datExtra = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->get('https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA1')->json();
            $datExtra = $datExtra['value'];
            
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

            $ped = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->get('https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA?$filter=BaseRef eq '."('".$id."')")->json();
            $ped = $ped['value'];
            
            $invoices = DB::connection('sqlsrv2')->table('Historico')->where('Pedido', $id)
            ->select('ID historico','Articulo Efectuado','Descripcion Articulo', 'Lote', 'Cantidad', 'Bahia', 'Compartimento')->get();

            $invoices = $invoices->all();
            
            $datExtra = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->get("https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA1?".'$filter=BaseRef eq '."'".$id."'")->json();
            $datExtra = $datExtra['value'];

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
            $response = Http::retry(20 ,300)->post('https://10.170.20.95:50000/b1s/v1/Login',[
                'CompanyDB' => 'INVERSIONES',
                'UserName' => 'Desarrollos',
                'Password' => 'Asdf1234$',
            ])->json();
    
            $_SESSION['B1SESSION'] = $response['SessionId'];
            
            $state = "Recogido";
    
            $ped = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->get("https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA?".'$filter '."=BaseRef eq ('".$id."')")->json();
            $ped = $ped['value'];
            // dd($ped);
            $H_F_REC = new DateTime("now", new DateTimeZone('America/Bogota'));
    
            foreach ( $ped  as $key => $value ) {
                $identi = $value['DocEntry']; 
                $linenum = $value['LineNum'];
                $itemCode = $value['ItemCode'];
    
                // if ($value['Biologico'] != "BIOLOGICOS") {
                    $gard = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->patch("https://10.170.20.95:50000/b1s/v1/DeliveryNotes(".$identi.")", [
                            "U_IV_FECHREC"=>$H_F_REC->format('Y-m-d'),
                            "U_IV_INIREC"=> $_SESSION['H_I_REC'],
                            "U_IN_FINREC"=> $H_F_REC->format('H:i:s'),
                            "DocumentLines"=> [
                                [
                                    "LineNum"=> $linenum,
                                    "ItemCode"=> $itemCode,
                                    "U_IV_ESTA"=> "Recogido"                        
                                ]
                            ]
                    ])->json();
                // }
            }
            Alert::success('¡Guardado!', "Recolección finalizada exitosamente.");
            return redirect()->route('loginPick');
      
       
        
    }


// ----------------------------------------ADMIN-------------------------------------

    public function listPick()
    {
        session_start();
        try {

            $_SESSION['H_I_REC'] = '';
            $pedido = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->get('https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA?$apply=groupby((DocEntry,CardCode,CardName,DocDate,BaseRef,DocNum,Departamento,Municipio_Ciudad,U_IV_ESTA,U_IV_Prioridad,U_IV_OPERARIO))')->json();
            $pedido = $pedido['value'];

            $pedido_bio = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->get('https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA2?$apply=groupby((DocEntry,CardCode,CardName,DocDate,BaseRef,DocNum,Departamento,Municipio_Ciudad,U_IV_ESTA,U_IV_Prioridad,U_IV_OPERARIO))')->json();
            $pedido_bio = $pedido_bio['value'];
            
            $user = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->post('https://10.170.20.95:50000/b1s/v1/SQLQueries(%27IV_FACTURADOR%27)/List')->json();
            $user = $user['value'];
            
            $datExtra = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->get('https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA1')->json();
            $datExtra = $datExtra['value'];
            
            return view('Admin.pick.ListPick', compact('pedido', 'datExtra', 'pedido_bio', 'user'));
        } catch (\Throwable $th) {
            session_destroy();
            setcookie('USER', '', time()-43200);
            setcookie('USER_ROL', '', time()-43200);
            Alert::warning('¡La sección expiro!', 'Por favor vuleve a acceder');
            return redirect('/');
        }
    }
    
    public function asignar($id, $DL)
    {
        session_start();
        try {

            $ped = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->get('https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA?$filter=BaseRef eq '."('".$id."')")->json();
            $ped = $ped['value'];
            // dd($ped);
            
            $invoices = DB::connection('sqlsrv2')->table('Historico')->where('Pedido', $id)
            ->select('ID historico','Articulo Efectuado','Descripcion Articulo', 'Lote', 'Cantidad', 'Bahia', 'Compartimento')->get();

            $invoices = $invoices->all();
            
            $datExtra = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->get("https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA1?".'$filter=BaseRef eq '."'".$id."'")->json();
            $datExtra = $datExtra['value'];

            $user = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->post('https://10.170.20.95:50000/b1s/v1/SQLQueries(%27IV_FACTURADOR%27)/List')->json();
            $user = $user['value'];

            

            return view('Admin.pick.FormAsignPick', compact('ped', 'id','DL', 'invoices', 'datExtra', 'user'));
        } catch (\Throwable $th) {
            session_destroy();
            setcookie('USER', '', time()-43200);
            setcookie('USER_ROL', '', time()-43200);
            Alert::warning('¡La sección expiro!', 'Por favor vuleve a acceder');
            return redirect('/');
        }
    }

    public function storeAsign(Request $request)
    {
        session_start();
        
        try {

            $input = $request->all();
            
            $id = $input['id'];
            $dl = $input['DL'];
            
            $response = Http::retry(20 ,300)->post('https://10.170.20.95:50000/b1s/v1/Login',[
                'CompanyDB' => 'INVERSIONES',
                'UserName' => 'Desarrollos',
                'Password' => 'Asdf1234$',
            ])->json();

            $_SESSION['B1SESSION'] = $response['SessionId'];

            // $ped = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->get("https://10.170.20.95:50000/b1s/v1/DeliveryNotes(".$dl.")")->json();
            // dd($ped);

            $gard = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->patch("https://10.170.20.95:50000/b1s/v1/DeliveryNotes(".$dl.")", [
                "U_IV_OPERARIO"=> $input['operatore'],
                "U_IV_Prioridad"=> $input['prioridad'],
            ])->json();

            Alert::success('¡Guardado!', "Asignado correctamente.");
            return redirect()->route('listPick');
            
        } catch (\Throwable $th) {
            session_destroy();
            setcookie('USER', '', time()-43200);
            setcookie('USER_ROL', '', time()-43200);
            Alert::warning('¡La sección expiro!', 'Por favor vuleve a acceder');
            return redirect('/');
        }
    }

// -------------------------------------------ADMIN--------------------------------
}
