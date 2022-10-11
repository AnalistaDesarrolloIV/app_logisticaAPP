<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    
    public function listPick()
    {
        session_start();
        try {

            $pedido = Http::withToken($_SESSION['B1SESSION'])->retry(30, 5, throw: false)->get('https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA?$apply=groupby((DocEntry,CardCode,CardName,DocDate,BaseRef,DocNum,Departamento,Municipio_Ciudad,U_IV_ESTA,U_IV_Prioridad,U_IV_OPERARIO))')['value'];

            $pedido_bio = Http::withToken($_SESSION['B1SESSION'])->retry(30, 5, throw: false)->get('https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA2?$apply=groupby((DocEntry,CardCode,CardName,DocDate,BaseRef,DocNum,Departamento,Municipio_Ciudad,U_IV_ESTA,U_IV_Prioridad,U_IV_OPERARIO))')['value'];
            
            $user = Http::withToken($_SESSION['B1SESSION'])->retry(30, 5, throw: false)->post('https://10.170.20.95:50000/b1s/v1/SQLQueries(%27IV_FACTURADOR%27)/List')['value'];
            $orden = sort($user);

            
            $datExtra = Http::withToken($_SESSION['B1SESSION'])->retry(30, 5, throw: false)->get('https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA1')['value'];
            
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

            $ped = Http::retry(30, 5, throw: false)->withToken($_SESSION['B1SESSION'])->get('https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA?$filter=BaseRef eq '."('".$id."')")['value'];

            $invoices = DB::connection('sqlsrv2')->table('Historico')->where('Pedido', $id)
            ->select('ID historico','Articulo Efectuado','Descripcion Articulo', 'Lote', 'Cantidad', 'Bahia', 'Compartimento')->get();

            $invoices = $invoices->all();
            
            $datExtra = Http::retry(30, 5, throw: false)->withToken($_SESSION['B1SESSION'])->get("https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA1?".'$filter=BaseRef eq '."'".$id."'")['value'];

            $user = Http::retry(30, 5, throw: false)->withToken($_SESSION['B1SESSION'])->post('https://10.170.20.95:50000/b1s/v1/SQLQueries(%27IV_FACTURADOR%27)/List')['value'];
            $orden = sort($user);

            

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
            
            $session = Http::retry(30, 5, throw: false)->post('https://10.170.20.95:50000/b1s/v1/Login',[
                'CompanyDB' => 'INVERSIONES',
                'UserName' => 'Desarrollos',
                'Password' => 'Asdf1234$',
            ])['SessionId'];


            $gard = Http::retry(30, 5, throw: false)->withToken($session)->patch("https://10.170.20.95:50000/b1s/v1/DeliveryNotes(".$dl.")", [
                "U_IV_OPERARIO"=> $input['operatore'],
                "U_IV_Prioridad"=> $input['prioridad'],
            ]);

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

}
