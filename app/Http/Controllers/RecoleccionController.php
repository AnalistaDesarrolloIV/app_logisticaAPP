<?php

namespace App\Http\Controllers;

use App\Http\Requests\login;
use App\Models\Empleados;
use Illuminate\Http\Request;
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
        session_start();
        if (isset($_SESSION['B1SESSION'])) {
        
            $input = $request->all();
            // dd($input);
            $identificador = $input['documento'];
            // dd($identificador);
    
            $emp = Empleados::all();
            foreach ($emp as $key => $value) {
                if ($value['OPE_OPERATORE'] == $identificador) {
                    $_SESSION['EMPLEADO'] = $value;
                    // dd($_SESSION['EMPLEADO']);
    
                    $pedido = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->get("https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA?".'$apply'."=groupby((CardCode,CardName,DocDate,BaseRef))")->json();
                    $pedido = $pedido['value'];
                    // dd($pedido);
                    return view('picking.ListPedidos', compact('pedido'));
                }
            }
            
            Alert::error('¡Error!', 'Usuario no existe');
            return Redirect()->route('logPick');

        } else {
            Alert::warnig('Reinicio', 'Reinicio forsado');
            return redirect('/');
        }
    }

    public function indexPick($id)
    {
        // dd($id);
        session_start();
        if (isset($_SESSION['B1SESSION'])) {
            $ped = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->get("https://10.170.20.95:50000/b1s/v1/sml.svc/ENTREGA?".'$filter '."=BaseRef eq ('".$id."')")->json();
            $ped = $ped['value'];
            // dd($ped);
            return view('picking.DetallePedido', compact('ped', 'id'));
        }else {
            Alert::warnig('Reinicio', 'Reinicio forsado');
            return redirect('/');
        }
    }
}
