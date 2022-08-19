<?php

use App\Http\Controllers\EmpaqueController;
use App\Http\Controllers\RecoleccionController;
use App\Models\Empleados;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

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
    $response = Http::retry(20 ,300)->post('https://10.170.20.95:50000/b1s/v1/Login',[
        'CompanyDB' => 'INVERSIONES0804',
        'UserName' => 'Prueba',
        'Password' => '1234',
    ])->json();

    // dd($response);
    session_start();
    $_SESSION['B1SESSION'] = $response['SessionId'];
    
    // $date = date('Y-m-d');
    // $datos = Http::get('https://mandaryservir.co/mys/users/remesasivanagro/2022-08-19')->json();
    // $datos = $datos['Guia'];
    // dd($datos);
    // foreach ($datos as $key => $value) {;
    //     $numeroD = $value['Venta']['documento1'];
    //     $envio_sap = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->get('https://10.170.20.95:50000/b1s/v1/Invoices?$select = DocEntry,DocNum &$filter=DocNum eq 1596146')->json();
    //     $envio_sap = $envio_sap['value'];
    //     // dd($envio_sap);
    //     if ($envio_sap !== '') {
    //         // dd("si");
    //         $id_doc = $envio_sap[0]['DocEntry'];
    //         dd($id_doc);
    //         $save_sap = Http::retry(20, 300)->withToken($_SESSION['B1SESSION'])->patch("https://10.170.20.95:50000/b1s/v1/Invoices(".$id_doc.")", [
    //             "U_R_GUIA"=>$value['Venta']['remesa'],
    //             "U_F_GUIA"=>$value['Venta']['fecha'],
    //             "U_H_GUIA"=>$value['Venta']['hora'],
    //             "U_E_Guia"=>"02"
    //         ])->status();
    //     }
    // }
    return view('Opciones');
});

Route::post('/consulta',[EmpaqueController::class,'consulta'])->name('consulta');

Route::get('/logPick',[RecoleccionController::class,'logPick'])->name('logPick');
Route::post('/loginPick',[RecoleccionController::class,'loginPick'])->name('loginPick');
Route::get('/indexPick/{id}',[RecoleccionController::class,'indexPick'])->name('indexPick');


Route::get('/logPack',[EmpaqueController::class,'logPack'])->name('logPack');
Route::post('/loginPack',[EmpaqueController::class,'loginPack'])->name('loginPack');
Route::get('/indexPack/{id}',[EmpaqueController::class,'indexPack'])->name('indexPack');
Route::post('/savePack/{id}',[EmpaqueController::class,'savePack'])->name('savePack');