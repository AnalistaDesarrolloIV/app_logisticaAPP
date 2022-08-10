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

    session_start();
    $_SESSION['B1SESSION'] = $response['SessionId'];
    return view('Opciones');
});

Route::post('/consulta',[EmpaqueController::class,'consulta'])->name('consulta');

Route::get('/logPick',[RecoleccionController::class,'logPick'])->name('logPick');
Route::post('/loginPick',[RecoleccionController::class,'loginPick'])->name('loginPick');
Route::get('/indexPick/{id}',[RecoleccionController::class,'indexPick'])->name('indexPick');


Route::get('/logPack',[EmpaqueController::class,'logPack'])->name('logPack');
Route::post('/loginPack',[EmpaqueController::class,'loginPack'])->name('loginPack');
Route::get('/indexPack/{id}',[EmpaqueController::class,'indexPack'])->name('indexPack');