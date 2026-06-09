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
                    'email' => $request->user()->email, // 👈 Aqui só entra se não for null
                    'nivel' => $request->user()->nivel,
                ] : null, // Se não tiver logado, envia null com segurança
            ],
            'menu_sistema' => function (Request $request) {
                if (! $request->user()) return [];

                return \App\Models\Menu::query()
                    ->whereNull('menu_pai_id') // Pega apenas os pais (raiz)
                    ->where(function($query) use ($request) {
                        if ($request->user()->nivel !== 'admin') {
                            $query->where('nivel_permissao', $request->user()->nivel);
                        }
                    })
                    ->with(['filhosRecursivos']) // Garante o carregamento da árvore
                    ->orderBy('ordem')
                    ->get()
                    ->map(function ($menu) {
                        // 💡 FORÇANDO O PADRÃO: Esse map garante que o Laravel entregue
                        // a propriedade exatamente como 'filhos_recursivos' para o Vue
                        return [
                            'id' => $menu->id,
                            'nome' => $menu->nome,
                            'url' => $menu->url,
                            'icon' => $menu->icon,
                            'filhos_recursivos' => $menu->filhosRecursivos->map(function ($filho) {
                                return $this->formatarMenuParaVue($filho);
                            })->toArray(),
                        ];
                    });
            },
            'appName' => config('app.name'),
            'flash' => [
                'sucesso' => fn () => $request->session()->get('sucesso'),
                'erro'    => fn () => $request->session()->get('erro'),
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
