<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\Menu;

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
                $isSuperAdmin = ($nivelUsuario === 99);

                // 1. Buscamos a árvore pura do banco (rápido e sem travar a query)
                $menus = \App\Models\Menu::query()
                    ->whereNull('menu_pai_id')
                    ->with(['filhosRecursivos'])
                    ->orderBy('ordem')
                    ->get();
                // 2. Criamos uma função interna para filtrar recursivamente no PHP
                $filtrarMenu = function ($menusColecao) use (&$filtrarMenu, $nivelUsuario, $isSuperAdmin) {
                    return $menusColecao->filter(function ($menu) use ($nivelUsuario, $isSuperAdmin) {
                        // Se for super admin, passa direto. Se não, checa o JSON.
                        if (!$isSuperAdmin) {
                            // Decodifica o JSON do banco para um array PHP se não estiver dropado como cast
                            $permissoes = is_array($menu->nivel_permissao) 
                                ? $menu->nivel_permissao 
                                : json_decode($menu->nivel_permissao, true) ?? [];

                            // Se o nível do usuário não estiver nas permissões deste item, ELIMINA ele.
                            if (!in_array($nivelUsuario, $permissoes)) {
                                return false;
                            }
                        }
                        return true;
                    })->map(function ($menu) use (&$filtrarMenu) {
                        // Se passar no filtro, formata e filtra os filhos dele recursivamente
                        return [
                            'id' => $menu->id,
                            'nome' => $menu->nome,
                            'url' => $menu->url,
                            'icon' => $menu->icon,
                            // Aqui a mágica acontece: filtramos os filhos com a mesma regra
                            'filhos_recursivos' => $filtrarMenu($menu->filhosRecursivos),
                        ];
                    })->values()->toArray(); // .values() reseta os índices do array pro Vue não ler como objeto
                };
            // 3. Rodamos a nossa função na coleção inicial
                return $filtrarMenu($menus);
            },

            'appName' => config('app.name'),
            'dataAtual' => now()->format('d/m/Y'),
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
