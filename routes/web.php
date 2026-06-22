<?php
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

require __DIR__.'/auth.php'; // Tava no final do codigo.

 use App\Http\Controllers\BaseController;
 Route::get('/',[BaseController::class,'main']); // AJustar depois...senao em producao da erro.


// Modulo Loja

// Modulo Administrativo

// Modulo PreImpressao(producao)


use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\CadastroController;
Route::get('cadastro', [CadastroController::class, 'index'])->name('cadastro.index');
Route::get('cadastro/tabela', [CadastroController::class, 'list'])->name('cadastro.list');
Route::post('cadastro', [CadastroController::class, 'store'])->name('cadastro.store'); // novo
Route::get('cadastro/edit/{id}', [CadastroController::class, 'edit'])->name('cadastro.edit'); // novo
Route::put('cadastro/{id}', [CadastroController::class, 'update'])->name('cadastro.update');
Route::delete('cadastro/{id}', [CadastroController::class, 'destroy'])->name('cadastro.destroy');



// ler documentacao.
// travar com  validacao de autenticacao, somente usuarios autenticados podem acessar a wiki.
use App\Http\Controllers\WikiController;
Route::get('/markdown', [WikiController::class, 'listarMarkdown'])->name('markdown.index');
Route::get('/markdown/conteudo/{nomeDocumento}', [WikiController::class, 'getConteudo'])->name('markdown.conteudo');//->middleware('nivel:99');
Route::get('/markdown/img/{nomeImagem}', [WikiController::class, 'getImagem'])->name('markdown.imagem')->where('nomeImagem', '.*'); // Aceita subpastas e exten


// Rotas pra testar somente exemplos, uso de api.
Route::get('/teste', [CrudController::class, 'teste'])->name('crud.teste');
Route::get('/cep', [CrudController::class, 'consultaCep'])->name('crud.cep');
Route::get('/teste1', [CrudController::class, 'gorest']);


// Teste de vue...
Route::get('/estudo/teste',[CrudController::class,'testeVue'])->name('estudo.teste');
Route::post('/estudo/teste',[CrudController::class,'salvarTesteVue'])->name('estudo.teste.salvar');
Route::post('/estudo/teste-axios',[CrudController::class,'salvarTesteVueAxios'])->name('estudo.teste.axios'); 

use App\Http\Controllers\CrudController;
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

Route::middleware('auth')->group(function () {
    // Alteracoes de senha.
    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');
    Route::get('/profile', [PasswordController::class, 'edit'])->name('profile.edit');
    
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
        

