
# Usando Gates no Controller e na Rota

```php
app/Providers/AppServiceProvider.php

    public function boot(): void
    {

        Gate::define('deletar-usuarios', function (Usuarios $user) {
        $niveisPermitidos = [99];

        return in_array((int) $user->nivel, $niveisPermitidos)
            ? Response::allow()
            : Response::deny("Acesso negado:\nApenas usuários com nível 99 podem deletar.");
        });
        
        // Você pode adicionar mais Gates aqui embaixo se precisar:
        // Gate::define('editar-produtos', function (Usuarios $user) { ... });
    }
```

No controller:  `Gate::authorize('deletar-usuarios');`
Na rota: `Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->middleware('can:deletar-usuarios');`
