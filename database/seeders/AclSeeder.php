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
            [
                'Perfil' => 'Admin',
                'Descricao' => 'Administrador',
            ],
            [
                'Perfil' => 'Usuario',
                'Descricao' => 'Usuário comum',
            ],
            [
                'Perfil' => 'Baixa',
                'Descricao' => 'Operador Baixa',
            ],
            [
                'Perfil' => 'Bureau',
                'Descricao' => 'Operador Bureau',
            ],
            [
                'Perfil' => 'Orcamentista',
                'Descricao' => 'Pessoa Orçamentista',
            ],
        ];

        foreach ($perfis as $perfil) {
            DB::table('acl')->updateOrCreate(
                ['Perfil' => $perfil['Perfil']], // Chave de busca para evitar duplicados
                ['Descricao' => $perfil['Descricao']]
            );
        }
    }
}