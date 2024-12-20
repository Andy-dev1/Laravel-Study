<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarroController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\LocacaoController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::resource('cliente',ClienteController::class);
Route::prefix('v1')->middleware('jwt.auth')->group(function(){
    Route::post('logout',[AuthController::class,'logout']);
    
    Route::post('me',[AuthController::class,'me']);
    
    Route::apiResource('cliente',ClienteController::class);
    Route::apiResource('carro',CarroController::class);
    Route::apiResource('locacao',LocacaoController::class);
    Route::apiResource('marca',MarcaController::class);
    Route::apiResource('modelo',ModeloController::class);
    
});



Route::post('login',[AuthController::class,'login']);
Route::post('refresh',[AuthController::class,'refresh']);


