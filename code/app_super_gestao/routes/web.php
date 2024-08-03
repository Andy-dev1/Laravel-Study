<?php

use App\Http\Controllers\ContatoController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\SobreNosController;
use App\Http\Controllers\TesteController;
use App\Http\Middleware\LogAcessoMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [PrincipalController::class, 'principal'])
    ->name('site.index')
    ->middleware('log.acesso');

Route::get('/sobre-nos', [SobreNosController::class, 'sobreNos'])->name('site.sobrenos');
// Route::middleware(LogAcessoMiddleware::class)->get('/contato', [ContatoController::class, 'contato'])->name('site.contato');
Route::get('/contato', [ContatoController::class, 'contato'])->name('site.contato');
Route::post('/contato', [ContatoController::class, 'salvar'])->name('site.contato');
Route::get('/login', function () {
    return 'Login';
})->name('site.login');


//Agrupando rotas para /aapp
Route::prefix('/app')->group(function () {
    Route::middleware('autenticacao')
        ->get('/clientes', function () {
            return 'clientes';
        })->name('app.clientes');
    Route::middleware('autenticacao')
        ->get('/fornecedores', [FornecedorController::class, 'index'])
        ->name('app.fornecedores');
    Route::middleware('autenticacao')
        ->get('/produtos', function () {
            return 'produtos';
        })->name('app.produtos');
});
//Redirecionamento de rota
// Route::get('/rota1', function () {
//     echo 'Rota 1';
// })->name('site.rota1');


// Route::get('/rota2', function () {
//     return redirect()->route('site.rota1');
// })->name('site.rota2');

//Route::redirect('/rota2','/rota1');

//Encaminhando parametros da rota para o controlador
Route::get('/teste/{p1}/{p2}', [TesteController::class, 'teste'])->name('teste');
//Rota de fallback ou rota de contingência

Route::fallback(function () {
    echo "A rota acessada não existe. <a href=" . route('site.index') . ">Clique aqui</a> para ir para página inicial";
});


//Opcionais da direita para esquerda
// Route::get('/contato/{nome}/{categoria}/{assunto}/{mensagem?}', function (string $nome, string $categoria, string $assunto, string $mensagem = 'mensagem não informada') {
//     echo "Estamos aqui:" . $nome . "-" . $categoria . "-" . $assunto . "-" . $mensagem;
// });

// Route::get(
//     '/contato/{nome}/{categoria_id?}',
//     function (
//         string $nome,
//         int $categoria_id = 1 //1 - "Informação",

//     ) {
//         echo "Estamos aqui:" . $nome . "-" . $categoria_id;
//     }
// )->where('categoria_id', '[0-9]+')->where('nome', '[A-Za-z]+');

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
