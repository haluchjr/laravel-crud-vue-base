<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Artisan::command('db:install', function (){

    $path = database_path('install.sql');

    // 1. Valida se o arquivo realmente existe antes de tentar ler
    if (!File::exists($path)) {
        $this->error("Erro: O arquivo não foi encontrado em: {$path}");
        return;
    }

    $this->info('Lendo o arquivo SQL...');
    $sql = File::get($path);

    // 2. Verifica se o arquivo não está vazio
    if (empty(trim($sql))) {
        $this->warn('O arquivo install.sql está vazio. Nada a executar.');
        return;
    }

    $this->info('Executando as instruções no banco de dados...');

    try {
        DB::unprepared($sql);
        $this->info('SQL executado com sucesso!');
        
    } catch (\Exception $e) {
        $this->error('Falha ao executar o SQL:');
        $this->line($e->getMessage());
    }

})->purpose('Executa uma query SQL customizada');

Artisan::command('db:menu {limite}', function ($limite){
$resultados = DB::select("SELECT * FROM tb_menus LIMIT ?",[$limite]);
    
    if (count($resultados) > 0) {
        // Converte os objetos stdClass para array para a tabela do Artisan aceitar
        $dados = array_map(function ($item) {
            return (array) $item;
        }, $resultados);

        $this->table(['ID', 'Nome', 'E-mail', '-','-','Nivel Permissao'], $dados);
    } else {
        $this->warn("Nenhum registro encontrado.");
    }

})->purpose('Executa uma query SQL customizada');