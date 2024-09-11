<?php

use App\Mail\MensagemTesteMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return view('bem-vindo');
});

Auth::routes(['verify' => true]);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
// ->name('home')
// ->middleware('verified');
Route::get("tarefa/exportacao/{extensao}",[App\Http\Controllers\TarefaController::class,'exportacao'])
    ->name('tarefa.exportacao');
Route::resource('tarefa', App\Http\Controllers\TarefaController::class)
->middleware('verified');
Route::get('/mensagem-teste', function () {
    return new MensagemTesteMail();
    //Mail::to('#')->send(new MensagemTesteMail());
    //return "Email enviado com sucesso!";
});
