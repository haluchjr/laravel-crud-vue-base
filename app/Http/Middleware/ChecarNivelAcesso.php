<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChecarNivelAcesso
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $nivelRequerido): Response
    {
        // 1. Verifica se o usuário está logado
        // 2. Verifica se o nível dele bate com o requerido (ou se ele é super admin)
        if (!auth()->check() || (auth()->user()->nivel !== $nivelRequerido && auth()->user()->nivel !== 'admin')) {
            abort(403, 'Você não tem permissão para acessar esta página.');
        }

        return $next($request);
    }
}
