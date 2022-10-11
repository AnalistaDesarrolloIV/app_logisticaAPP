<?php

namespace App\Http\Controllers;

use App\Http\Requests\login;
use App\Models\Empleados;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class EmpaqueController extends Controller
{
    public function loginPack()
    {
        session_start();
        try {

            $entregas = Http::retry(30, 5, throw: false)->withToken($_SESSION['B1SESSION'])
            ->get('https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA?$apply=groupby((DocEntry,CardCode,CardName,DocDate,BaseRef,DocNum,Departamento,Municipio_Ciudad,U_IV_ESTA,U_IV_Prioridad,U_IV_OPERARIO))')['value'];
            
            $datExtra = Http::retry(30, 5, throw: false)->withToken($_SESSION['B1SESSION'])
            ->get('https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA1')['value'];
            
            return view('packing.ListEntregas', compact('entregas', 'datExtra'));

        } catch (\Throwable $th) {
            session_destroy();
            setcookie('USER', '', time()-43200);
            setcookie('USER_ROL', '', time()-43200);
            Alert::warning('¡La sección expiro!', 'Por favor vuleve a acceder');
            return redirect('/');
        }
    }

    public function indexPack($id)
    {
        session_start();
        try {
            $fecha_hora = new DateTime("now", new DateTimeZone('America/Bogota'));

            $hi = $fecha_hora->format('H:i:s');

            $entrega = Http::retry(30, 5, throw: false)->withToken($_SESSION['B1SESSION'])->get("https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA?" . '$filter ' . "=BaseRef eq ('" . $id . "')")['value'];
            $Nped = $entrega[0]['DocEntry'];
            
            $horaI = Http::retry(30, 5)->withToken($_SESSION['B1SESSION'])->get("https://10.170.20.95:50000/b1s/v1/DeliveryNotes(".$Nped.")")['U_IV_INIEMP'];
            
            if ($horaI == '') {
                $gard = Http::retry(30, 5, throw: false)->withToken($_SESSION['B1SESSION'])->patch("https://10.170.20.95:50000/b1s/v1/DeliveryNotes(" . $Nped . ")", [
                    "U_IV_FECHEMP" => $fecha_hora->format('Y-m-d'),
                    "U_IV_INIEMP" => $hi
                ])->throw();
                $horaI = $hi;
            }

            $justy = Http::retry(30, 5, throw: false)->withToken($_SESSION['B1SESSION'])->get("https://10.170.20.95:50000/b1s/v1/SQLQueries('codigofalt')/List")['value'];
            
            $datExtra = Http::retry(30, 5, throw: false)->withToken($_SESSION['B1SESSION'])->get("https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA1?".'$filter=BaseRef eq '."'".$id."'")['value'];
           
            return view('packing.DetalleEntrega', compact('entrega', 'id','horaI', 'justy', 'datExtra'));
            
        } catch (\Throwable $th) {
            session_destroy();
            setcookie('USER', '', time()-43200);
            setcookie('USER_ROL', '', time()-43200);
            Alert::warning('¡La sección expiro!', 'Por favor vuleve a acceder');
            return redirect('/');
        }
    }

    public function savePack($id)
    {
        session_start();
        try{
            $session = Http::retry(30, 5, throw: false)->post('https://10.170.20.95:50000/b1s/v1/Login',[
                'CompanyDB' => 'INVERSIONES',
                'UserName' => 'Desarrollos',
                'Password' => 'Asdf1234$',
            ])['SessionId'];

            $state = "Empacado";

            $ped = Http::retry(30, 5, throw: false)->withToken($session)->get("https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA?".'$filter '."=BaseRef eq ('".$id."')")['value'];
            
            $Nped = $ped[0]['DocEntry'];
            $H_F_EMP = new DateTime("now", new DateTimeZone('America/Bogota'));

            $horaF = Http::retry(30, 5, throw: false)->withToken($session)->get("https://10.170.20.95:50000/b1s/v1/DeliveryNotes(".$Nped.")")['U_IV_FINEMP'];
            
            if ($horaF == '') {
                $gard = Http::retry(30, 5, throw: false)->withToken($session)->patch("https://10.170.20.95:50000/b1s/v1/DeliveryNotes(".$Nped.")", [
                    "U_IV_FINEMP"=> $H_F_EMP->format('H:i:s'),
                    "U_IV_FACTURADOR"=> $_COOKIE['USER']
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
            Alert::success('¡Guardado!', "Empaque finalizado exitosamente.");
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
