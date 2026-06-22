<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate; // 1. IMPORTANTE: Importar o Gate
use App\Models\Usuarios;              // 2. IMPORTANTE: Importar o seu Model de Usuário
use Illuminate\Auth\Access\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);

        // 3. Definindo o portão "deletar-usuarios"
        Gate::define('deletar-usuarios', function (Usuarios $user) {
        $niveisPermitidos = [99];

        return in_array((int) $user->nivel, $niveisPermitidos)
            ? Response::allow()
            : Response::deny("Acesso negado:\nApenas usuários com nível 8 podem deletar.");
        });
        
        // Você pode adicionar mais Gates aqui embaixo se precisar:
        // Gate::define('editar-produtos', function (Usuarios $user) { ... });
    }
}