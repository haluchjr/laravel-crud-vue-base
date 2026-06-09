<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // ---------------------------------------------------------
        // CATEGORIA 1: PEDIDOS (Nível Pai)
        // ---------------------------------------------------------
        $pedidosPai = Menu::create([
            'nome' => 'Pedidos',
            'url' => '#',
            'icon' => 'bi-cart',
            'ordem' => 1,
            'nivel_permissao' => 'usuario'
        ]);

        // Submenu Nível 1 (Filho)
        $nacionais = Menu::create([
            'nome' => 'Nacionais',
            'url' => '#',
            'icon' => 'bi-flag',
            'ordem' => 1,
            'menu_pai_id' => $pedidosPai->id,
            'nivel_permissao' => 'usuario'
        ]);

        // Submenu Nível 2 (Netos - Links Finais)
        Menu::create([
            'nome' => 'Vendas Próprias',
            'url' => '/pedidos/nacionais/proprias',
            'icon' => 'bi-dot',
            'ordem' => 1,
            'menu_pai_id' => $nacionais->id,
            'nivel_permissao' => 'usuario'
        ]);

        Menu::create([
            'nome' => 'Revenda',
            'url' => '/pedidos/nacionais/revenda',
            'icon' => 'bi-dot',
            'ordem' => 2,
            'menu_pai_id' => $nacionais->id,
            'nivel_permissao' => 'usuario'
        ]);


        // ---------------------------------------------------------
        // CATEGORIA 2: SISTEMA (Nível Pai - Apenas Admin)
        // ---------------------------------------------------------
        $sistemaPai = Menu::create([
            'nome' => 'Sistema',
            'url' => '#',
            'icon' => 'bi-sliders',
            'ordem' => 2,
            'nivel_permissao' => 'admin'
        ]);

        // Submenu Nível 1 (Filho)
        $usuariosFilho = Menu::create([
            'nome' => 'Usuários',
            'url' => '#',
            'icon' => 'bi-people',
            'ordem' => 1,
            'menu_pai_id' => $sistemaPai->id,
            'nivel_permissao' => 'admin'
        ]);

        // Submenu Nível 2 (Netos - Links Finais dentro de Usuários)
        Menu::create([
            'nome' => 'Listar Todos',
            'url' => '/usuarios',
            'icon' => 'bi-list-task',
            'ordem' => 1,
            'menu_pai_id' => $usuariosFilho->id,
            'nivel_permissao' => 'admin'
        ]);

        Menu::create([
            'nome' => 'Permissões (ACL)',
            'url' => '/usuarios/permissoes',
            'icon' => 'bi-shield-lock',
            'ordem' => 2,
            'menu_pai_id' => $usuariosFilho->id,
            'nivel_permissao' => 'admin'
        ]);
    }
}