<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AclSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $perfis = [
            [   'id' => 99,
                'Perfil' => 'Admin',
                'Descricao' => 'Administrador/Desenvolvedor',
            ],
            [
                'id' => 1,
                'Perfil' => 'Usuario',
                'Descricao' => 'Usuário comum',
            ],
            [
                'id'=> 2,
                'Perfil' => 'Baixa',
                'Descricao' => 'Operador Baixa',
            ],
            [
                'id'=> 3,
                'Perfil' => 'Comercial',
                'Descricao' => 'Comercial',
            ],
            [
                'id'=> 4,
                'Perfil' => 'Financeiro',
                'Descricao' => 'Financeiro',
            ],
            [
                'id'=> 5,
                'Perfil' => 'Bureau',
                'Descricao' => 'Operador Bureau',
            ],
        ];

        foreach ($perfis as $perfil) {
            DB::table('tb_nivel')->updateOrInsert(
                ['Perfil' => $perfil['Perfil']], // Chave de busca para evitar duplicados
                ['Descricao' => $perfil['Descricao']]
            );
        }
    }
}