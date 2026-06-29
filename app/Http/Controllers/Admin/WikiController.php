<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

use Parsedown;
use Illuminate\Support\Str;


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
        $logs = base_path('docs/Md/');
        $arqLogs = File::files($logs);

        $lista = [];
        //LOG::warning('OIII');
        foreach ($arqLogs as $arquivo){
            $lista[] = [
                'nome'      => str_replace('.md','',$arquivo->getFilename()),
                'tamanho'   => $arquivo->getSize() . ' bytes',
                'data'      => \Carbon\Carbon::createFromTimestamp($arquivo->getCTime())->format('d/m/Y H:i'),
             ];
        }

        return Inertia::render('Markdown/Index',[
            'docs' => $lista,
        ]);

    }

    public function getConteudo($nomeDocumento)
    {
        $caminhoDoArquivo = "/var/www/html/docs/Md/{$nomeDocumento}.md";
        
        if (!File::exists($caminhoDoArquivo)) {
            return response()->json(['error' => 'Arquivo não encontrado'], 404);
        }

        $conteudoMarkdown = File::get($caminhoDoArquivo);
        
        // Converte o Markdown para HTML usando seu parser
        //$parsedown = new Parsedown();
        //$htmlConvertido = $parsedown->text($conteudoMarkdown);

        $htmlConvertido = Str::markdown($conteudoMarkdown);
        // Retorna uma resposta JSON comum, sem Inertia!
        // return response()->json([
        //     'html' => $htmlConvertido
        // ]);
        return view('markdown', [
            'nome' => $nomeDocumento,
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
