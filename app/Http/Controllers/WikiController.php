<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

use Parsedown;

class WikiController extends Controller
{
    //composer remove erusev/parsedown
    //npm uninstall highlight.js
    //php artisan optimize:clear
    //composer dump-autoload
    // Pseudo Wiki.
    
    // Ler markdown.
    public function listarMarkdown(){
        
        // Localizacao: docs/Md/
        $docs = [
            'Estrutura projeto'                                             => 'estrutura_projeto.md',
            'Comandos Artisan'                                              => 'comandos_artisan.md',
            'Migrations'                                                    => 'migrations.md',
            'Git'                                                           => 'git.md',
            'Guia de Referência: Imports Essenciais (Vue 3 + Inertia.js)'   => 'guia_referencia_imports.md',
            'Docker Explicado em Imagem'                                    => 'docker_explicado.md',
            'Padraoes-Aliases'                                              => 'padroes_alias.md',
            'Instalando certificado localmente'                             => 'certificado_local.md', 
            'Props'                                                         => 'entendendo_objeto_global_inertia.md',
        ];
        
        return Inertia::render('Markdown/Index',[
            'docs' => $docs,
        ]);

    }

    public function getConteudo($nomeDocumento)
    {
        $caminhoDoArquivo = "/var/www/html/docs/Md/{$nomeDocumento}";
        
        if (!File::exists($caminhoDoArquivo)) {
            return response()->json(['error' => 'Arquivo não encontrado'], 404);
        }

        $conteudoMarkdown = File::get($caminhoDoArquivo);
        
        // Converte o Markdown para HTML usando seu parser
          $parsedown = new Parsedown();
         $htmlConvertido = $parsedown->text($conteudoMarkdown);

        // Retorna uma resposta JSON comum, sem Inertia!
        return response()->json([
            'html' => $htmlConvertido
        ]);
    }

    // Proxy pra poder conseguir carregar de fora da pasta padrao do laravel.
    public function getImagem($nomeImagem)
    {
        $caminhoDaImagem = base_path("docs/Md/img/{$nomeImagem}");

        if (!File::exists($caminhoDaImagem)) {
            abort(404, 'Imagem não encontrada.');
        }

        $arquivo = File::get($caminhoDaImagem);
        $tipoMime = File::mimeType($caminhoDaImagem);

        return Response::make($arquivo, 200, [
            'Content-Type' => $tipoMime,
            'Cache-Control' => 'public, max-age=86400' // Opcional: faz o navegador guardar em cache por 1 dia para ficar mais rápido
        ]);
    }

}
