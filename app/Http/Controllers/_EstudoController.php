<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class EstudoController extends Controller
{
    public function mostrarPagina()
    {
        // Simulando dados que poderiam vir do banco de dados (ex: User::all())
        $dadosDoProjeto = [
            'nome_modulo' => 'Dominando Inertia com Vue 3',
            'status'      => 'sucesso',
            'aulas_assistidas' => 122
        ];

        // Enviando para a página "Estudo/PaginaEstudo.vue"
        return Inertia::render('Estudo/RecebendoBack', [
            'projeto' => $dadosDoProjeto
        ]);
    }

    public function salvarProduto(Request $request)
    {
        // 1. Validação padrão do Laravel
        $request->validate([
            'nome_produto' => 'required|min:3|max:100',
        ]);

       
        // Se quiser ver o que chegou de imagem, descomente o Base64 aqui:
            if ($request->hasFile('imagem')) {
            // 💾 SALVA NO DISCO: 
            // O Laravel joga na pasta 'produtos' dentro de 'storage/app/public'
            // E gera um nome aleatório único automaticamente (Ex: xY9zK...jpg)
            $caminhoNoDisco = $request->file('imagem')->store('produtos', 'public');
            
            // Transforma o caminho interno (produtos/nome_aleatorio.jpg) em uma URL legível para o HTML
            $urlPublicaImagem = Storage::url($caminhoNoDisco);
            Log::info('Upload feito com sucesso', ['caminho_salvo' => $caminhoNoDisco]);
        }

        // Montando o objeto exatamente com as chaves que seu Estudo.vue precisa ler:
        $payloadDeRetorno = [
            'nome' => $request->nome_produto,
            'preco' => $request->preco ?? 0, // Evita erro se o preço for vazio
            'url_imagem' => $urlPublicaImagem, // Caminho público da fot
            'processado_em' => now()->format('H:i:s')
        ];

        // 4. Redireciona de volta para a rota GET injetando os dados na sessão
        return redirect('/vue')->with([
            'dados_retornados' => $payloadDeRetorno,
            'flash' => [
                'mensagem' => 'Produto "' . $request->nome_produto . '" processado com sucesso!',
                'tipo' => 'sucesso'
            ]
        ]);
    }
}