<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

// use app\Http\Controllers\Controller;

class LoginController extends Controller
{
    
    public function login(Request $request) 
    {
        session_start();
        try {
            $input = $request->all();
            
            $response = Http::retry(30, 5, throw: false)->post('https://10.170.20.95:50000/b1s/v1/Login',[
                'CompanyDB' => 'INVERSIONES',
                'UserName' => 'Desarrollos',
                'Password' => 'Asdf1234$',
            ])['SessionId'];

            $_SESSION['B1SESSION'] = $response;
            
            $name = $input['usuario'];
            $pass = $input['password'];

            $user = Http::withToken($_SESSION['B1SESSION'])->retry(30, 5, throw: false)->post('https://10.170.20.95:50000/b1s/v1/SQLQueries(%27IV_FACTURADOR%27)/List')['value'];
            
            $user_db = [];

            foreach ($user as $key => $user_log) {
                if ($user_log['Code'] == $name && $user_log['U_Contra'] == $pass) {
                    $user_db =  $user_log;
                }
            }
            
            if (!empty($user_db)) {
                setcookie('USER', $user_db['Code'], time()+43200);
                setcookie('USER_ROL', $user_db['U_Tipo_Opr'], time()+43200);
                if ($user_db['U_Tipo_Opr'] == 'ADMINISTRADOR') {

                    return redirect()->route('opcionesAdmin');

                }elseif ($user_db['U_Tipo_Opr'] == 'OPERARIO' || $user_db['U_Tipo_Opr'] == 'OPERARIO BIOLOGICOS') {

                    return redirect()->route('opciones');

                }else {
                    Alert::error('¡Error!', 'Usuario no autorizado');
                    return redirect('/');
                }
                Alert::success('Bienvenid@', 'Ingreso exitoso');
                return redirect()->route('opciones');

            }else{
                Alert::error('¡Error!', 'Credenciales de usuario no corresponden con nuestros registros.');
                return redirect('/');
            }
            
        } catch (\Throwable $th) {
            session_destroy();
            setcookie('USER', '', time()-43200);
            setcookie('USER_ROL', '', time()-43200);
            Alert::error('¡Error!', 'Algo salio mal');
            return redirect('/');
        }

    }

    public function option()
    {
        session_start();

        if (isset($_COOKIE["USER"]) && isset($_COOKIE["USER_ROL"])) {
            return view('Opciones');
        }else {
            session_destroy();
            setcookie('USER', '', time()-43200);
            setcookie('USER_ROL', '', time()-43200);
            Alert::warning('¡La sección expiro!', 'Por favor vuleve a acceder');
            return redirect('/');
        }
    }

    public function optionAdmin()
    {
        session_start();
        if (isset($_COOKIE["USER"]) && isset($_COOKIE["USER_ROL"])) {
            return view('Admin.OpcionesAdmin');
        }else {
            session_destroy();
            setcookie('USER', '', time()-43200);
            setcookie('USER_ROL', '', time()-43200);
            Alert::warning('¡La sección expiro!', 'Por favor vuleve a acceder');
            return redirect('/');
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        setcookie('USER', '', time()-43200);
        setcookie('USER_ROL', '', time()-43200);
        return redirect('/');
    }

}
