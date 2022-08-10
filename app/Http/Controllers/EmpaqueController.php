<?php

namespace App\Http\Controllers;

use App\Http\Requests\login;
use App\Models\Empleados;
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
        session_start();
        if (isset($_SESSION['B1SESSION'])) { 
            $input = $request->all();
            // dd($input);
            $identificador = $input['documento'];
            
            $emp = Empleados::all();
            foreach ($emp as $key => $value) {
                if ($value['OPE_OPERATORE'] == $identificador) {
                    $_SESSION['EMPLEADO'] = $value;
    
                    $entregas = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->get("https://10.170.20.95:50000/b1s/v1/DeliveryNotes?".'$select'." = DocDate,DocNum,CardCode,CardName,&".'$filter'." =DocumentStatus eq 'bost_Open'")->json();
                    $entregas = $entregas['value'];
                    // dd($entregas);
                    return view('packing.ListEntregas', compact('entregas'));
                }
            }
            Alert::error('¡Error!', 'Usuario no existe');
            return Redirect()->route('logPack');
        }else {
            Alert::warnig('Reinicio', 'Reinicio forsado');
            return redirect('/');
        }
       
    }
    public function consulta(Request $request)
    {
        $input = $request->all();
        dd($input);
    }

    public function indexPack($id)
    {
        // dd($id);

        
        session_start();
        if (isset($_SESSION['B1SESSION'])) {
            $entrega = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->get("https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGAS?".'$filter =DocNum eq ('.$id.")")->json();
            $entrega = $entrega['value'];
            // dd($entrega);
            return view('packing.DetalleEntrega', compact('entrega', 'id'));
        }else {
            Alert::warnig('Reinicio', 'Reinicio forsado');
            return redirect('/');
        }
        
    }
}
