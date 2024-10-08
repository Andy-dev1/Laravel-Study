<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PedidoProdutoController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ProdutoDetalheController;
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
Route::get('/login/{erro?}', [LoginController::class,'index'])->name('site.login');
Route::post('/login', [LoginController::class,'autenticar'])->name('site.login');


//Agrupando rotas para /aapp
Route::middleware('autenticacao:padrao,visitante')->prefix('/app')->group(function () {
    Route::get('/home',[HomeController::class,'index'])->name('app.home');
    Route::get('/sair', [LoginController::class,'sair'])->name('app.sair');
    //Route::get('/cliente', [ClienteController::class,'index'])->name('app.cliente');
    
    Route::get('/fornecedor', [FornecedorController::class, 'index'])->name('app.fornecedor');
    Route::post('/fornecedor/listar', [FornecedorController::class, 'listar'])->name('app.fornecedor.listar');
    Route::get('/fornecedor/listar', [FornecedorController::class, 'listar'])->name('app.fornecedor.listar');
    Route::get('/fornecedor/adicionar', [FornecedorController::class, 'adicionar'])->name('app.fornecedor.adicionar');
    Route::post('/fornecedor/adicionar', [FornecedorController::class, 'adicionar'])->name('app.fornecedor.adicionar');
    Route::get('/fornecedor/editar/{id}/{msg?}', [FornecedorController::class, 'editar'])->name('app.fornecedor.editar');
    Route::get('/fornecedor/excluir/{id}', [FornecedorController::class, 'excluir'])->name('app.fornecedor.excluir');
    // Route::get('/produto', function () {
    //         return 'produtos';
    //     })->name('app.produto');

    //Produtos
    //php artisan route:list
    Route::resource('produto', ProdutoController::class);
    
    //Produtos detalhes
    Route::resource('produto-detalhe',ProdutoDetalheController::class);
    
    Route::resource('cliente',ClienteController::class);
    Route::resource('pedido',PedidoController::class);
    //Route::resource('pedido-produto',PedidoProdutoController::class);
    Route::get('pedido-produto/create/{pedido}',[PedidoProdutoController::class,'create'])->name('pedido-produto.create');
    Route::post('pedido-produto/create/{pedido}',[PedidoProdutoController::class,'store'])->name('pedido-produto.store');
    // Route::delete('pedido-produto/destroy/{pedido}/{produto}',[PedidoProdutoController::class,'destroy'])->name('pedido-produto.destroy');
    Route::delete('pedido-produto/destroy/{pedidoProduto}/{pedido_id}',[PedidoProdutoController::class,'destroy'])->name('pedido-produto.destroy');
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
