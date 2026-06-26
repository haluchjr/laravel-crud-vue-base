<?php
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\WikiController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PedidoController;

function routeHash(string $nome): string
{
    //return hash_hmac('sha256', $nome, config('app.key'));
    return sha1($nome);
}

Route::get('/hash/{texto}', function ($texto) {
    return sha1($texto);
});

//Route::get('/',[BaseController::class,'main'])->name('tela.index'); // AJustar depois...senao em producao da erro.

Route::middleware('auth')->group(function () {
    //Route::get('/',[BaseController::class,'main'])->name('redirect');

    // Alteracoes de senha.
    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');
    Route::get('/profile', [PasswordController::class, 'edit'])->name('profile.edit');
    
    // MENU USUARIO
    Route::get('/7239b827d37d653d84361615bbf75feeb5f376a6', [PedidoController::class,  'novoPedido'])->name('pedido.novo');
    Route::get('/406223ece94e5c03170b598ca9dce09481a7f97a', [UsuarioController::class, 'index'])->name('usuario.index');
    Route::get('/63bd6233d34eea3c1d7993ab33c0523deb75473b', [UsuarioController::class, 'alterarDados'])->name('usuario.meusdados');
    Route::get('/dbc84778d7aed4575ba29dbbf67770ec488374d5', [PedidoController::class,  'relatorioPedidos'])->name('pedido.relatorio');
    Route::get('/26', [PedidoController::class,  'listarPedidos'])->name('pedido.relatorio.cliente');
    
    // Outros perfis
    Route::get('/23a1bf2b4836567c6092a984f7b2c15172f3d328', [PedidoController::class, 'listarPedidosClientes'])->name('adm.pedidos.pistar');
    

    
    // Rotas Administrativo        
    // Visualizador de eventos , restringir no menu a nivel ADM/99
    Route::get('/logs/list',[LogController::class,'list'])->name('log.list');
    Route::get('/logs/show/{id}',[LogController::class,'showLog'])->name('log.show');
    Route::get('/logs/destroy/{id}',[LogController::class,'destroy'])->name('log.destroy');

    // Mini Wiki, , restringir no menu a nivel ADM/99
    Route::get('/markdown', [WikiController::class, 'listarMarkdown'])->name('wiki.docs');
    Route::get('/markdown/conteudo/{nomeDocumento}', [WikiController::class, 'getConteudo'])->name('markdown.conteudo');//->middleware('nivel:99');
    Route::get('/markdown/img/{nomeImagem}', [WikiController::class, 'getImagem'])->name('markdown.imagem')->where('nomeImagem', '.*'); // Aceita subpastas e exten0
});

require __DIR__.'/auth.php'; // Tava no final do codigo.

/*  _______  _______ __  __ ____  _     ___  ____   */
/* | ____\ \/ / ____|  \/  |  _ \| |   / _ \/ ___|  */
/* |  _|  \  /|  _| | |\/| | |_) | |  | | | \___ \  */
/* | |___ /  \| |___| |  | |  __/| |__| |_| |___) | */
/* |_____/_/\_\_____|_|  |_|_|   |_____\___/|____/  */
/*


use App\Http\Controllers\CrudController;
Route::middleware('auth')->group(function () {
    // Alteracoes de senha.
    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');
    Route::get('/profile', [PasswordController::class, 'edit'])->name('profile.edit');

    // Visualizador de eventos , restringir no menu a nivel ADM/99
    Route::get('/logs/list',[LogController::class,'list'])->name('log.list');
    Route::get('/logs/show/{id}',[LogController::class,'showLog'])->name('log.show');
    Route::get('/logs/destroy/{id}',[LogController::class,'destroy'])->name('log.destroy');

    // Mini Wiki, , restringir no menu a nivel ADM/99
    Route::get('/markdown', [WikiController::class, 'listarMarkdown'])->name('markdown.index');
    Route::get('/markdown/conteudo/{nomeDocumento}', [WikiController::class, 'getConteudo'])->name('markdown.conteudo');//->middleware('nivel:99');
    Route::get('/markdown/img/{nomeImagem}', [WikiController::class, 'getImagem'])->name('markdown.imagem')->where('nomeImagem', '.*'); // Aceita subpastas e exten0

    // localhost:8080/crud/
    Route::prefix('crud')->group(function(){
        
        // URL: localhost:8020/crud
        Route::get('/', [CrudController::class, 'index'])->name('crud.index'); // direcionar para um novo layouyt..
        
        // Novo registro
        Route::post('/', [CrudController::class, 'store'])->name('crud.store');

        // URL: localhost:8020/crud/{id} (Corrigido removendo o 'crud' duplicado)
        Route::put('/{id}', [CrudController::class, 'update'])->name('crud.update');
        
        // URL: localhost:8020/crud/{id}
        Route::delete('/{id}', [CrudController::class, 'destroy'])->name('crud.destroy');
        
    });


});

use App\Http\Controllers\CadastroController;
Route::get('cadastro', [CadastroController::class, 'index'])->name('cadastro.index');
Route::get('cadastro/tabela', [CadastroController::class, 'list'])->name('cadastro.list');
Route::post('cadastro', [CadastroController::class, 'store'])->name('cadastro.store'); // novo
Route::get('cadastro/edit/{id}', [CadastroController::class, 'edit'])->name('cadastro.edit'); // novo
Route::put('cadastro/{id}', [CadastroController::class, 'update'])->name('cadastro.update');
Route::delete('cadastro/{id}', [CadastroController::class, 'destroy'])->name('cadastro.destroy');

// Rotas pra testar somente exemplos, uso de api.
Route::get('/teste', [CrudController::class, 'teste'])->name('crud.teste');
Route::get('/cep', [CrudController::class, 'consultaCep'])->name('crud.cep');
Route::get('/teste1', [CrudController::class, 'gorest']);


// Teste de vue...
Route::get('/estudo/teste',[CrudController::class,'testeVue'])->name('estudo.teste');
Route::post('/estudo/teste',[CrudController::class,'salvarTesteVue'])->name('estudo.teste.salvar');
Route::post('/estudo/teste-axios',[CrudController::class,'salvarTesteVueAxios'])->name('estudo.teste.axios'); 


// Crud Teste
Route::get('/crud1/teste-insert',[CrudController::class,'testeView'])->name('crud.teste.insert');
route::post('/crud1/teste-insert',[CrudController::class,'testeInsert'])->name('crud.teste.insert.salvar');
route::post('/crud1/teste-update',[CrudController::class,'testeUpdate'])->name('crud.teste.update');
route::post('/crud1/teste-delete',[CrudController::class,'testeDelete'])->name('crud.teste.delete');

Route::get('/diretivas', function () {
    return Inertia::render('Estudo/Index'); 
});

// Rota pública para onde o usuário será enviado após se cadastrar
Route::get('/em-analise', function () {
    return Inertia::render('Auth/EmAnalise'); 
})->name('em-analise');

// Cache
use Illuminate\Support\Facades\Cache;
use App\Models\Usuarios;
Route::get('/teste-cache', function () {
    
    // Tenta buscar 'total_usuarios' no Redis. 
    // Se não achar, roda a função, conta os usuários no banco, salva por 10 segundos e retorna.
    $usuarios = Cache::remember('total_usuarios', 10, function () {
        logger('O cache estava vazio! Executando a query no banco...');
        return Usuarios::count(); 
    });

    return "Total de usuários no sistema: " . $usuarios;

});
*/
        

/// Fim exemplos.