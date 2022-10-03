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

            $entregas = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->get('https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA?$apply=groupby((DocEntry,CardCode,CardName,DocDate,BaseRef,DocNum,Departamento,Municipio_Ciudad,U_IV_ESTA,U_IV_Prioridad,U_IV_OPERARIO))');
            $entregas->json();
            $entregas = $entregas['value'];

            $datExtra = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->get('https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA1')->json();
            $datExtra = $datExtra['value'];

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


            $entrega = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->get("https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA?" . '$filter ' . "=BaseRef eq ('" . $id . "')")->json();
            $entrega = $entrega['value'];

            $justy = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->get("https://10.170.20.95:50000/b1s/v1/SQLQueries('codigofalt')/List")->json();

            $justy = $justy['value'];
            
            $datExtra = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->get("https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA1?".'$filter=BaseRef eq '."'".$id."'")->json();
            $datExtra = $datExtra['value'];

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
        // try {
            $input = $request->all();
            
            session_start();
            $response = Http::retry(20, 300)->post('https://10.170.20.95:50000/b1s/v1/Login', [
                'CompanyDB' => 'INVERSIONES',
                'UserName' => 'Desarrollos',
                'Password' => 'Asdf1234$',
            ])->json();

            $Token = $response['SessionId'];

            $state = "Empacado";

            $H_F_EMP =  new DateTime("now", new DateTimeZone('America/Bogota'));

            $ped = Http::retry(20, 300)->withToken($Token)->get("https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA?" . '$filter ' . "=BaseRef eq ('" . $id . "')")->json();
            $ped = $ped['value'];

            foreach ($ped  as $key => $value) {
                $identi = $value['DocEntry'];
                $linenum = $value['LineNum'];
                $itemCode = $value['ItemCode'];


                if ($input['justify'][$key] !== null) {
                    $gard = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->patch("https://10.170.20.95:50000/b1s/v1/DeliveryNotes(" . $identi . ")", [
                        "U_IV_FECHEMP" => $H_F_EMP->format('Y-m-d'),
                        "U_IV_INIEMP" => $_SESSION['H_I_EMP'],
                        "U_IV_FINEMP" => $H_F_EMP->format('H:i:s'),
                        "U_IV_FACTURADOR"=> $_COOKIE['USER'],
                        "DocumentLines" => [
                            [
                                "LineNum" => $linenum,
                                "ItemCode" => $itemCode,
                                "U_IV_ESTA" => $state,
                                "U_IV_EMPAC" => $input['cantidadE'][$key],
                                "U_IV_MTOFAL" => $input['justify'][$key]
                            ]
                        ]
                    ])->status();
                } else {
                    $gard = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->patch("https://10.170.20.95:50000/b1s/v1/DeliveryNotes(" . $identi . ")", [
                        "U_IV_FECHEMP" => $H_F_EMP->format('Y-m-d'),
                        "U_IV_INIEMP" => $_SESSION['H_I_EMP'],
                        "U_IV_FINEMP" => $H_F_EMP->format('H:i:s'),
                        "U_IV_FACTURADOR"=> $_COOKIE['USER'],
                        "DocumentLines" => [
                            [
                                "LineNum" => $linenum,
                                "ItemCode" => $itemCode,
                                "U_IV_ESTA" => $state,
                                "U_IV_EMPAC" => $input['cantidadE'][$key]
                            ]
                        ]
                    ])->json();
                }
            }
            Alert::success('¡Guardado!', "Empaque finalizado exitosamente.");
            return redirect()->route('opciones');
        // } catch (\Throwable $th) {
        //     session_destroy();
        //     setcookie('USER', '', time()-43200);
        //     setcookie('USER_ROL', '', time()-43200);
        //     Alert::warning('¡La sección expiro!', 'Por favor vuleve a acceder');
        //     return redirect('/');
        // }
    }


    // ---------------------------------ADMIN------------------------------

    
    public function listPack()
    {
        try {
            session_start();

            $entregas = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->get('https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA?$apply=groupby((DocEntry,CardCode,CardName,DocDate,BaseRef,DocNum,Departamento,Municipio_Ciudad,U_IV_ESTA))');
            $estado = $entregas->status();
            $entregas->json();
            $entregas = $entregas['value'];

            $datExtra = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->get('https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA1')->json();
            $datExtra = $datExtra['value'];

            return view('packing.ListEntregas', compact('entregas', 'datExtra'));

        } catch (\Throwable $th) {
            Alert::warning('¡La sección expiró!', 'Por favor vuleve a acceder');
            return redirect()->route('log');
        }
    }
}
