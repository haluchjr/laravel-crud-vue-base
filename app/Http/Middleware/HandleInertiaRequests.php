<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\Menu;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user() ? [
                    'id' => $menuUser = $request->user()->id,
                    'name' => $request->user()->name,
                    'email' => $request->user()->email, 
                    'nivel' => $request->user()->nivel,
                    'permissoes' => Auth::user()->hasPermission(Route::currentRouteName(), 'botoes', true), 
                ] : null, // Se não tiver logado, envia null com segurança
            ],
            /* 
            Arvore do menu é baseada no nivel do usuario.
            Na tb_menu, cada elemento eh montado individualmente com base no nivel
            nivel_permissao = [1] 
            Se uma linha tiver nivel_permissao 1 => vai montar somente pro usuario
            
            */
            'menu_sistema' => function (Request $request) {
                if (! $request->user()) return [];

                $nivelUsuario = (int) $request->user()->nivel;

                $sessionId = $request->session()->getId(); // Pega o ID único da sessão atual
                
                // Criamos uma chave única no Redis para cada nível de usuário
                // Ex: "sistema:menu:nivel:1" ou "sistema:menu:nivel:99"
                //$cacheKey = "sistema:menu:nivel:{$nivelUsuario}";
                $cacheKey = "sistema:menu:sessao:{$sessionId}:nivel:{$nivelUsuario}";

                // O Cache::remember tenta buscar do Redis. Se não achar, roda a função interna e salva no Redis automaticamente.
                //return \Illuminate\Support\Facades\Cache::remember($cacheKey, now()->addDays(1), function () use ($nivelUsuario) {
                //return \Illuminate\Support\Facades\Cache::remember($cacheKey, now()->addMinutes(1), function () use ($nivelUsuario) {
                            
                    $isSuperAdmin = ($nivelUsuario === 99);

                    // 1. Buscamos a árvore pura do banco
                    $menus = \App\Models\Menu::query()
                        ->whereNull('menu_pai_id')
                        ->with(['filhosRecursivos'])
                        ->orderBy('ordem')
                        ->get();

                    // 2. Criamos a função interna para filtrar recursivamente no PHP
                    $filtrarMenu = function ($menusColecao) use (&$filtrarMenu, $nivelUsuario, $isSuperAdmin) {
                       // ... dentro do seu HandleInertiaRequests.php
                        return $menusColecao->filter(function ($menu) use ($nivelUsuario, $isSuperAdmin) {
                            if (!$isSuperAdmin) {
                                $permissoes = is_array($menu->nivel_permissao) 
                                    ? $menu->nivel_permissao 
                                    : json_decode($menu->nivel_permissao, true) ?? [];

                                if (!in_array($nivelUsuario, $permissoes)) {
                                    return false;
                                }
                            }
                            return true;
                        })->map(function ($menu) use (&$filtrarMenu) {
                            return [
                                'id' => $menu->id,
                                'nome' => $menu->nome,
                                'url' => $menu->url,
                                'icon' => $menu->icon,
                                'nivel_permissao' => is_array($menu->nivel_permissao) ? $menu->nivel_permissao : json_decode($menu->nivel_permissao, true) ?? [],
                                'filhos_recursivos' => $filtrarMenu($menu->filhosRecursivos),
                            ];
                        })->values()->toArray();
                    };

                    // 3. Retorna o resultado estruturado que será guardado no Redis
                    return $filtrarMenu($menus);
                //});
            },
            'appName'       => config('app.name'),
            'dataAtual'     => now()->format('d/m/Y'),
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error'   => fn () => $request->session()->get('error'),
                'warning' => fn () => $request->session()->get('warning'),
            ],
        ];
    }

    private function formatarMenuParaVue($menu)
    {
        return [
            'id' => $menu->id,
            'nome' => $menu->nome,
            'url' => $menu->url,
            'icon' => $menu->icon,
            'filhos_recursivos' => $menu->filhosRecursivos ? $menu->filhosRecursivos->map(function ($subFilho) {
                return $this->formatarMenuParaVue($subFilho);
            })->toArray() : [],
        ];
    }
}
