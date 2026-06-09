<?php
use App\Http\Controllers\EstudoController;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\Auth\PasswordController;



use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


// 💡 Rota pública para onde o usuário será enviado após se cadastrar

Route::get('/em-analise', function () {
    return Inertia::render('Auth/EmAnalise'); // Criaremos essa tela no Vue
})->name('em-analise');

Route::middleware('auth')->group(function () {
    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');
    Route::get('/profile', [PasswordController::class, 'edit'])->name('profile.edit');
    
    // https://gemini.google.com/share/5370ba57f132
    // localhost:8080/crud/
    Route::prefix('crud')->group(function(){
        
        // URL: localhost:8020/crud
        Route::get('/', [CrudController::class, 'index'])->name('crud.index');
        
        // Novo registro
        Route::post('/', [CrudController::class, 'store'])->name('crud.store');

        // URL: localhost:8020/crud/{id} (Corrigido removendo o 'crud' duplicado)
        Route::put('/{id}', [CrudController::class, 'update'])->name('crud.update');
        
        // URL: localhost:8020/crud/{id}
        Route::delete('/{id}', [CrudController::class, 'destroy'])->name('crud.destroy');
        
        // URL: localhost:8020/crud/tmp-list
        // Route::get('/tmp-list', [CrudController::class, 'list']); 

    });

});
        

require __DIR__.'/auth.php'; // Tava no final do codigo.