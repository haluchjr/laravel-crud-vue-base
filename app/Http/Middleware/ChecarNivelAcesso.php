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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string|int  ...$niveisPermitidos
     */
    public function handle(Request $request, Closure $next, ...$niveisPermitidos): Response
    {
        // 1. Verifica se o usuário está logado
        if (!auth()->check()) {
            abort(403, 'Você não tem permissão para acessar esta página.');
        }

        // ⚡ FORÇA O VALOR A SER UM INTEIRO (Evita bug de String vs Int)
        $nivelUsuario = (int) auth()->user()->nivel;

        // Se o nível for 99, ele é o Super Admin master e acessa QUALQUER rota do sistema
        $isSuperAdmin = ($nivelUsuario === 99);

        // 2. Verifica se ele é super admin OU se o nível dele está na lista de permitidos da rota
        // Usamos a comparação flexível do in_array para garantir
        if (!$isSuperAdmin && !in_array($nivelUsuario, $niveisPermitidos, false)) {
            abort(403, 'Você não tem permissão para acessar esta página.');
        }

        return $next($request);
    }
}