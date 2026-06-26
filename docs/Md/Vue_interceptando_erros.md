# Usando interceptacao de erros direto

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Inertia\Inertia;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);
        // ADICIONADO: Registra o apelido para o seu middleware genérico de ACL
        $middleware->alias([
            'nivel' => \App\Http\Middleware\ChecarNivelAcesso::class,
        ]);
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Customização dos erros com Inertia
        $exceptions->respond(function (Response $response, Throwable $exception, Request $request) {
            // Lista de status que queremos interceptar
            $statusCodes = [401, 403, 404, 419, 429, 500, 503];

            if (in_array($response->getStatusCode(), $statusCodes)) {
                return Inertia::render('Error', [
                    'status' => $response->getStatusCode(),
                ])
                ->toResponse($request)
                ->setStatusCode($response->getStatusCode());
            }

            return $response;
        });
    })->create();

```