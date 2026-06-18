<?php

namespace App\Http\Controllers;

use App\Models\Cadastro;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\NovoUsuarioRequest;

use App\Repositories\CadastroRepository;

class CadastroController extends Controller
{
    public function __construct(protected CadastroRepository $cadastroRepository) {
        $this->cadastroRepository = $cadastroRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dados = $this->cadastroRepository->paginate(15);
        
        return Inertia::render('Cadastro/Index',['dados'=> $dados]);
    }

    

    public function list(Request $request)
    {
        // Captura o que foi digitado (se houver)
        $termoBusca = $request->input('busca');

        // Se o seu Repository já aceita filtros, você pode passar o termo para ele.
        // Se não, você pode ajustar o método paginate() do seu Repository para receber a busca:
        $dados = $this->cadastroRepository->paginate(15, $termoBusca);

        // O appends ou withQueryString garante que, se o usuário buscar algo e mudar de página, 
        // o link da página 2 continue filtrado:
        $dados->withQueryString();

        return Inertia::render('Cadastro/Tabela', [
            'dados' => $dados,
            'filtros' => $request->only(['busca']), // Devolve o termo para o Vue manter o input preenchido
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(NovoUsuarioRequest $request,)
    {
        // 1. Pega os dados validados
        $dados = $request->validated();

        // 2. Processa o arquivo e altera o valor de $dados['foto']
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $arquivo = $request->file('foto');
            
            // 1. Gera um nome único aleatório para não sobrescrever arquivos
            $nomeArquivo = md5(uniqid()) . '.' . $arquivo->getClientOriginalExtension();
            
            // 2. Move o arquivo DIRETO para public/usuarios/ dentro do seu projeto
            $arquivo->move(public_path('usuarios'), $nomeArquivo);
            
            // 3. Salva no banco o caminho relativo
            $dados['foto'] = 'usuarios/' . $nomeArquivo;
        }

        // 3. 🛑 O ERRO ESTAVA AQUI: Você deve passar $dados e NÃO $request->all()
        if ($this->cadastroRepository->salvar($dados)) { // 💡 Mude de $request->all() para $dados
            return redirect()->route('cadastro.list')->with('success', 'Cadastrado com sucesso!');
        } else {
            if (isset($caminhoFoto)) {
                Storage::disk('public')->delete($caminhoFoto);
            }
            return redirect()->back()->with('error', 'Erro ao salvar.');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Cadastro $cadastro)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cadastro $cadastro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NovoUsuarioRequest $request, $id)
    {
        // 1. Pega os dados validados pelo seu Form Request
        $dados = $request->validated();
        
        // 2. Busca o registro atual no banco pelo repositório para checar se ele já tinha foto
        $usuario = $this->cadastroRepository->findById($id); 

        // 3. Verifica se um NOVO arquivo de foto foi enviado
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $arquivo = $request->file('foto');
            
            // 💡 DELETAR A FOTO ANTIGA: Se o usuário já tinha uma foto salva, apaga ela direto da pasta pública
            if ($usuario->foto && file_exists(public_path($usuario->foto))) {
                unlink(public_path($usuario->foto)); // Deleta o arquivo físico antigo
            }

            // 💡 SALVAR A FOTO NOVA: Gera um nome único aleatório
            $nomeArquivo = md5(uniqid()) . '.' . $arquivo->getClientOriginalExtension();
            
            // Move o arquivo direto para public/usuarios/
            $arquivo->move(public_path('usuarios'), $nomeArquivo);
            
            // Define o caminho limpo que vai pro banco de dados (ex: 'usuarios/abc123...png')
            $dados['foto'] = 'usuarios/' . $nomeArquivo;

        } else {
            // 💡 TRUQUE DO INERTIA: Se não veio um arquivo novo, o Vue enviou a string do caminho antigo.
            // Para o Laravel não tentar atualizar a coluna com lixo ou dar erro, removemos o campo do array.
            // Assim, o banco mantém a foto que já estava lá intacta.
            unset($dados['foto']);
        }

        // 4. Envia os dados tratados para o repositório atualizar no MySQL
        if ($this->cadastroRepository->atualizar($id, $dados)) {
            return redirect()->back()->with('success', 'Cadastro atualizado com sucesso!');
        }
        
        return redirect()->back()->with('error', 'Erro ao atualizar cadastro.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if ($this->cadastroRepository->deletar($id)){
            return redirect()->back()->with('success', "Registro ID {$id} excluído com sucesso!");
        }
        return redirect()->back()->with('error', "Registro ID {$id} excluído com sucesso!");
    }
}
