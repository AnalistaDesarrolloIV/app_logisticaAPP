<?php

use App\Http\Controllers\EmpaqueController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RecoleccionController;
use App\Models\Empleados;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    try {
        session_start();
        $response = Http::retry(20 ,300)->post('https://10.170.20.95:50000/b1s/v1/Login',[
            'CompanyDB' => 'INVERSIONES',
            'UserName' => 'Desarrollos',
            'Password' => 'Asdf1234$',
        ])->json();


        $_SESSION['B1SESSION'] = $response['SessionId'];
            
            // $datos = Http::get('https://mandaryservir.co/mys/users/remesasivanagro/2022-08-30')->json();
            // $datos = $datos['Guia'];
            // dd($datos); 

            $users = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->post('https://10.170.20.95:50000/b1s/v1/SQLQueries(%27IV_FACTURADOR%27)/List')->json();
            $users = $users['value'];
            // dd($users);

        return view('Login', compact('users'));

    } catch (\Throwable $th) {
        Alert::error($th->getMessage());
        return redirect('/');
    }
});
Route::get('/offline', function () {    
    return view('vendor/laravelpwa/offline');
})->name('log');

Route::post('/login',[LoginController::class,'login'])->name('login');
Route::get('/opciones',[LoginController::class,'option'])->name('opciones');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/loginPick',[RecoleccionController::class,'loginPick'])->name('loginPick');
Route::get('/indexPick/{id}/{DL}',[RecoleccionController::class,'indexPick'])->name('indexPick');
Route::get('/savePick/{id}/{DL}',[RecoleccionController::class,'savePick'])->name('savePick');


Route::get('/loginPack',[EmpaqueController::class,'loginPack'])->name('loginPack');
Route::get('/indexPack/{id}',[EmpaqueController::class,'indexPack'])->name('indexPack');
Route::post('/savePack/{id}',[EmpaqueController::class,'savePack'])->name('savePack');


// -----------------admin---------------

Route::get('/opcionesAdmin',[LoginController::class,'optionAdmin'])->name('opcionesAdmin');

Route::get('/listPick',[RecoleccionController::class,'listPick'])->name('listPick');
Route::get('/formAsi/{id}/{DL}',[RecoleccionController::class,'asignar'])->name('formAsi');
Route::post('/storeAsign',[RecoleccionController::class,'storeAsign'])->name('storeAsign');



Route::get('/listPack',[EmpaqueController::class,'listPack'])->name('listPack');


// Route::get('/logPick',[RecoleccionController::class,'logPick'])->name('logPick');


// Route::get('/logPack',[EmpaqueController::class,'logPack'])->name('logPack');