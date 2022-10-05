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

            $entregas = Http::retry(30, 5, throw: false)->withToken($_SESSION['B1SESSION'])->get('https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA?$apply=groupby((DocEntry,CardCode,CardName,DocDate,BaseRef,DocNum,Departamento,Municipio_Ciudad,U_IV_ESTA,U_IV_Prioridad,U_IV_OPERARIO))')['value'];
            
            $datExtra = Http::retry(30, 5, throw: false)->withToken($_SESSION['B1SESSION'])->get('https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA1')['value'];
            
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

            $_SESSION['H_I_EMP'] = $fecha_hora->format('H:i:s');

            $entrega = Http::retry(30, 5, throw: false)->withToken($_SESSION['B1SESSION'])->get("https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA?" . '$filter ' . "=BaseRef eq ('" . $id . "')")['value'];
            
            $justy = Http::retry(30, 5, throw: false)->withToken($_SESSION['B1SESSION'])->get("https://10.170.20.95:50000/b1s/v1/SQLQueries('codigofalt')/List")['value'];
            
            $datExtra = Http::retry(30, 5, throw: false)->withToken($_SESSION['B1SESSION'])->get("https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA1?".'$filter=BaseRef eq '."'".$id."'")['value'];
           
            return view('packing.DetalleEntrega', compact('entrega', 'id', 'justy', 'datExtra'));
            
        } catch (\Throwable $th) {
            session_destroy();
            setcookie('USER', '', time()-43200);
            setcookie('USER_ROL', '', time()-43200);
            Alert::warning('¡La sección expiro!', 'Por favor vuleve a acceder');
            return redirect('/');
        }
    }

    public function savePack(Request $request, $id)
    {
        session_start();
        try {
            $input = $request->all();
            
            $Token = Http::retry(30, 5, throw: false)->post('https://10.170.20.95:50000/b1s/v1/Login', [
                'CompanyDB' => 'INVERSIONES',
                'UserName' => 'Desarrollos',
                'Password' => 'Asdf1234$',
            ])['SessionId'];

            $state = "Empacado";

            $H_F_EMP =  new DateTime("now", new DateTimeZone('America/Bogota'));

            $ped = Http::retry(30, 5, throw: false)->withToken($Token)->get("https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA?" . '$filter ' . "=BaseRef eq ('".$id."')")['value'];
            
            $Nped = $ped[0]['DocEntry'];
            
            $pedC = Http::retry(20,300)->withToken($Token)->get("https://10.170.20.95:50000/b1s/v1/DeliveryNotes(".$Nped.")".'?$select='."U_IV_INIEMP,U_IV_FINEMP")->json();
            
            $horaI = $pedC['U_IV_INIEMP'];
            $horaF = $pedC['U_IV_FINEMP'];

            // dd("HI: ".$horaI." HF: ".$horaF);
            
            if ($horaI == '' && $horaF == '') {
                $gard = Http::retry(30, 5, throw: false)->withToken($Token)->patch("https://10.170.20.95:50000/b1s/v1/DeliveryNotes(" . $Nped . ")", [
                    "U_IV_FECHEMP" => $H_F_EMP->format('Y-m-d'),
                    "U_IV_INIEMP" => $_SESSION['H_I_EMP'],
                    "U_IV_FINEMP" => $H_F_EMP->format('H:i:s'),
                    "U_IV_FACTURADOR"=> $_COOKIE['USER']
                ])->throw();
            }
            // dd($gard);

            foreach ($ped  as $key => $value) {
                $itemCode = $value['ItemCode'];
                $LNum = $value['LineNum'];
                
                if ($input['justify'][$key] == null) {
                    $justificacion = '';
                }else {
                    $justificacion = $input['justify'][$key];
                }

                $gard2 = Http::retry(30, 5, throw: false)->withToken($Token)->patch("https://10.170.20.95:50000/b1s/v1/DeliveryNotes(".$Nped.")", [
                    "DocumentLines" => [
                        [
                            "LineNum" => $LNum,
                            "ItemCode" => $itemCode,
                            "U_IV_ESTA" => $state,
                            "U_IV_EMPAC" => $input['cantidadE'][$key],
                            "U_IV_MTOFAL" => $justificacion
                        ]
                    ]
                ]);
            // dd($gard2);

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
