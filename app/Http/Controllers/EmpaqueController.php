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
    public function logPack()
    {
        return view('packing.loginPacking');
    }
    public function loginPack(login $request)
    {
        try {
            session_start();
            $response = Http::retry(20 ,300)->post('https://10.170.20.95:50000/b1s/v1/Login',[
                'CompanyDB' => 'INVERSIONES',
                'UserName' => 'Desarrollos',
                'Password' => 'Asdf1234$',
            ])->json();

            $_SESSION['B1SESSION'] = $response['SessionId'];
                $input = $request->all();
                $identificador = $input['documento'];
                
                $emp = Empleados::all();
                foreach ($emp as $key => $value) {
                    if ($value['OPE_OPERATORE'] == $identificador) {
                        $_SESSION['EMPLEADO_E'] = $value;
        
                        $entregas = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->get('https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA?$apply=groupby((CardCode,CardName,DocDate,BaseRef,DocNum,Departamento,Municipio_Ciudad,U_IV_ESTA))');
                        $estado = $entregas->status();
                        if ($estado == 200) {
                            $entregas->json();
                            $entregas = $entregas['value'];

                            Alert::success('Bienvenid@', $_SESSION['EMPLEADO_E']['OPE_OPERATORE']);
                            return view('packing.ListEntregas', compact('entregas'));
                        }else{
                            Alert::error('¡Error!', 'Error interno.');
                            return redirect('/');
                        }
                    }
                }
                Alert::error('¡Error!', 'Usuario no existe');
                return Redirect()->route('logPack');
            
        } catch (\Throwable $th) {
            Alert::warning('¡La sección expiro!', 'Por favor vuleve a acceder');
            return redirect()->route('logPack');
        }
       
    }


    public function indexPack($id)
    {
        session_start();
        try {
            $fecha_hora = new DateTime("now", new DateTimeZone('America/Bogota'));
            
            $_SESSION['H_I_EMP'] = $fecha_hora->format('H:i:s');


            $entrega = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->get("https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA?".'$filter '."=BaseRef eq ('".$id."')")->json();
            $entrega = $entrega['value'];

            $justy = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->get("https://10.170.20.95:50000/b1s/v1/SQLQueries('codigofalt')/List")->json();
            $justy = $justy['value'];
            return view('packing.DetalleEntrega', compact('entrega', 'id', 'justy'));


        } catch (\Throwable $th) {
            Alert::warning('¡La sección expiro!', 'Por favor vuleve a acceder');
            return redirect()->route('logPack');
        }
        
    }
    public function savePack(Request $request, $id)
    {
        
        $input = $request->all();
        // dd($input);
        $idFor = $input['id'];
        session_start();
        $response = Http::retry(20 ,300)->post('https://10.170.20.95:50000/b1s/v1/Login',[
            'CompanyDB' => 'INVERSIONES',
            'UserName' => 'Desarrollos',
            'Password' => 'Asdf1234$',
        ])->json();

        $_SESSION['B1SESSION'] = $response['SessionId'];
        
        $state = "Empacado";

        $H_F_EMP =  new DateTime("now", new DateTimeZone('America/Bogota'));

        $ped = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->get("https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA?".'$filter '."=BaseRef eq ('".$id."')")->json();
        $ped = $ped['value'];

        
        foreach ( $ped  as $key => $value ) {
            $identi = $value['DocEntry']; 
            $linenum = $value['LineNum'];
            $itemCode = $value['ItemCode'];


            $gard = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->patch("https://10.170.20.95:50000/b1s/v1/DeliveryNotes(".$identi.")", [
                "U_IV_FECHEMP"=>$H_F_EMP->format('Y-m-d'),
                "U_IV_INIEMP"=> $_SESSION['H_I_EMP'],
                "U_IV_FINEMP"=> $H_F_EMP->format('H:i:s'),
                "DocumentLines"=> [
                    [
                        "LineNum"=> $linenum,
                        "ItemCode"=> $itemCode,
                        "U_IV_ESTA"=> $state,
                        "U_IV_EMPAC"=>$input['cantidadE'][$key]
                    ]
                ]
            ])->json();

            foreach ($idFor as $key => $val) {
                $gard2 = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->patch('https://10.170.20.95:50000/b1s/v1/DeliveryNotes('.$identi.')?$select=DocumentPackages', [
                    "Number"=> $input['caja'][$key],
                    "Type"=> "CAJA GENERICA",
                    "DocumentPackageItems"=> [
                        [
                            "PackageNumber"=> $input['caja'][$key],
                            "ItemCode"=> $input['Producto'][$key],
                            "UoMEntry"=> $input['UoMEntry'][$key],
                            "Quantity"=> $input['unidad'][$key]
                        ]
                    ]
                ])->json();
            }
        }
        
        session_destroy();
        Alert::success('¡Guardado!', "Empaque finalizado exitosamente.");
        return redirect('/');

    }
}
