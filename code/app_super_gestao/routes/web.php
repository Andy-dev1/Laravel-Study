<?php

use App\Http\Controllers\ContatoController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\SobreNosController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PrincipalController::class, 'principal']);
Route::get('/sobre-nos', [SobreNosController::class, 'sobreNos']);
Route::get('/contato', [ContatoController::class, 'contato']);
//Opcionais da direita para esquerda
// Route::get('/contato/{nome}/{categoria}/{assunto}/{mensagem?}', function (string $nome, string $categoria, string $assunto, string $mensagem = 'mensagem não informada') {
//     echo "Estamos aqui:" . $nome . "-" . $categoria . "-" . $assunto . "-" . $mensagem;
// });

Route::get(
    '/contato/{nome}/{categoria_id?}',
    function (
        string $nome,
        int $categoria_id = 1 //1 - "Informação",

    ) {
        echo "Estamos aqui:" . $nome . "-" . $categoria_id;
    }
)->where('categoria_id', '[0-9]+')->where('nome', '[A-Za-z]+');

// Route::get('/', function () {
//     return 'Hello World';
// });
// Route::get('/sobre-nos', function () {
//     return 'Sobre nós';
// });
// Route::get('/contato', function () {
//     return 'Contato';
// });



/* Verbos
get
post
put
patch
delete
options
 */
