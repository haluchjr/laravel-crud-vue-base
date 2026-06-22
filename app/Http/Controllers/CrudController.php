<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate; // Não esqueça de importar o Gate no topo!

use App\Models\Projeto;
use App\Repositories\UserRepository;
use App\Repositories\UsuarioRepository;

use App\Services\ViaCepService;
use App\Services\ConsultaFilmeService;

class CrudController extends Controller
{
    
    // Crud teste - Carregar tela.
    public function testeView(UsuarioRepository $rep){
            //dd($rep->findAll())
            // Inertia::render lê em Pages em diante.
        return Inertia::render('Estudo/Index',[
            'dados' => $rep->findAll()
        ]);
    }

    // Crud teste - Insert POST
    public function testeInsert(UsuarioRepository $rep, Request $request){
        $dadosValidados = $request->validate([
            'nome'   => 'required|string|max:150',
            'email'  => 'required|string|email|unique:usuarios_models,email',
        ], [
            'nome.required' => 'O nome do projeto é obrigatório.',
            'email.required' => 'O email do projeto é obrigatório.',
            'email.email' => 'O email do projeto deve ser um email válido.',
            'email.unique' => 'O email do projeto já está em uso.',
        ]);

       

        if ($rep->salvar($dadosValidados)) {
            return redirect()->back()->with('success', 'Projeto atualizado com sucesso!');
        } else {
            //return redirect()->back()->with('erro', 'Erro ao salvar usuário.');
            return redirect()->back()->with('error', 'Projeto atualizado com sucesso!');
        }

    }

    public function testeUpdate(UsuarioRepository $rep, Request $request){
    
        
        $dadosValidados = $request->validate([
            'id'    => 'required|integer|exists:usuarios_models,id',
            'nome'   => 'required|string|max:150',
            'email'  => 'required|string|email|unique:usuarios_models,email,' . $request->input('id'),
        ], [
            'id.required' => 'O ID do usuário é obrigatório.',
            'id.integer' => 'O ID do usuário deve ser um número inteiro.',
            'id.exists' => 'O ID do usuário não existe.',
            'nome.required' => 'O nome do projeto é obrigatório.',
            'email.required' => 'O email do projeto é obrigatório.',
            'email.email' => 'O email do projeto deve ser um email válido.',
            'email.unique' => 'O email do projeto já está em uso por outro usuário.',
        ]);

        if ($rep->atualizar($request->id,$dadosValidados)) {
            return redirect()->back()->with('success', 'Projeto atualizado com sucesso!');
        } else {
            return redirect()->back()->with('error', 'Erro ao atualizar usuário.');
        }
    }



    public function testeDelete(UsuarioRepository $rep, Request $request){
        if ($rep->deletar($request->input('id'))){
            return redirect()->back()->with('success', 'Projeto atualizado com sucesso!');
        }
        return redirect()->back()->with('error', 'Erro ao deletar usuário.');
    }


    // Para o codigo todo...
    //public function __construct(protected UserRepository $userRepo) {}

    // Ou com injecao de dependencia direto na metodo especifico.
    public function teste(UserRepository $rep){
        //$rep = new UserRepository();
        //$usuarios = $rep->findById(2);
        $usuarios = $rep->getUsuariosPaginados();
        dd($usuarios['cep']);
    }
    
    public function consultaCep(ViaCepService $viaCepService){
        $cep = '80330380';
        $retorno = $viaCepService->consultar($cep);
        dd($retorno['cep']);

    }


    // Api pra brincar com verbos.
    public function gorest(ConsultaFilmeService $api){
        $api->teste1();
    }

    public function testeVue(){
        return Inertia::render('Estudo/Index',[
            'nome' => Auth::user()->name ?? 'Desenvolvedor',
            'tecnologias' => ['PHP', 'Laravel', 'Vue.js', 'Inertia.js']
        ]);
    }

    public function salvarTesteVue(Request $request){
        $dados = $request->validate([
            'nome' => 'required|string|max:100',
        ]);

        // Aqui você poderia salvar no banco, enviar email, etc.
        // Por enquanto, vamos só logar os dados recebidos:
        Log::info("Dados recebidos do Vue:", $dados);

        // Redireciona de volta para a página de teste com uma mensagem de sucesso
        return redirect()->route('estudo.teste')->with('success', 'Dados salvos com sucesso!');
    }

    public function salvarTesteVueAxios(Request $request){
        // 1. Validação normal do Laravel
        $dados = $request->validate([
            'nome' => 'required|string|max:100',
        ]);

        // Loga os dados recebidos no arquivo laravel.log
        Log::info("Dados recebidos via Axios:", $dados);

        // 2. A MUDANÇA AQUI: Retornamos um JSON com status 200 (Sucesso)
        return response()->json([
            'sucesso' => true,
            'mensagem' => 'Dados processados com sucesso pelo Laravel!',
            'dado_recebido' => $dados['nome']
        ], 200); 
    }



    public function index()
    {
        // 1. Buscamos os dados do banco (trazendo o ID, Nome e Status)
        $projetos = Projeto::select('id', 'nome', 'status', 'created_at','arquivo')->paginate(5);

        $projetos->through(function ($projeto) {
            if (!empty($projeto->created_at) && $projeto->created_at !== '-') {
                
                // 1. Cria o objeto do Carbon garantindo que ele use o fuso correto do banco
                $dataCriacao = Carbon::parse($projeto->created_at);
                
                // 2. Calcula a data limite exata de 2 dias atrás (48 horas atrás a partir de AGORA)
                $limiteExato = Carbon::now()->subDays(2);
                
                // 3. REGRA MATEMÁTICA REAL: 
                // O projeto só está vencido se ele foi criado ANTES (lessThan) do nosso limite de 48h atrás.
                $projeto->vencido = $dataCriacao->lessThan($limiteExato);
                
                $projeto->data_formatada = $dataCriacao->format('d/m/Y H:i');
            } else {
                $projeto->vencido = false;
                $projeto->data_formatada = '-';
            }
            
            return $projeto;
        });

        // 2. Enviamos para a View do Vue dentro do array do Inertia
        return Inertia::render('Crud/Index', [
            'retorno' => $projetos,
            'usuario' => [
                'nome' => Auth::user()->name,
            ]
        ]);
    }
    
    public function store(Request $request)
    {
        // 1. Validação estrita dos dados recebidos do Vue
        $dadosValidados = $request->validate([
            'nome'   => 'required|string|max:150',
            'status' => 'required|string|in:ativo,inativo',
        ], [
            'nome.required' => 'O nome do projeto é obrigatório.',
        ]);

        // 2. Instancia e salva o novo registro
        $projeto = new Projeto();
        $projeto->nome = $dadosValidados['nome'];
        $projeto->status = $dadosValidados['status'];

        // 2.5
        if ($request->hasFile('arquivo')) {
            // Salva na pasta 'storage/app/public/projetos' e retorna o caminho
            $path = $request->file('arquivo')->store('projetos', 'public');
            $projeto->arquivo = $path;
        }

        $projeto->save();

        // 3. Redireciona de volta com a Flash Message de sucesso!
        return redirect()->back()->with('success', 'Projeto cadastrado com sucesso!');
    }

    /**
     * Atualiza o projeto no banco de dados.
     * * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $dadosValidados = $request->validate([
            'nome'    => 'required|string|min:3|max:150|unique:projetos,nome,' . $id,
            'status'  => 'required|string|in:ativo,inativo',
            'arquivo' => 'nullable|file|mimes:jpeg,png,jpg,pdf,docx|max:2048',
        ]);

        $projeto = Projeto::findOrFail($id);
        $projeto->nome = $dadosValidados['nome'];
        $projeto->status = $dadosValidados['status'];

        if ($request->hasFile('arquivo')) {
            // [Opcional] Se quiser deletar o arquivo antigo do disco antes de salvar o novo:
            if ($projeto->arquivo) {
                Storage::disk('public')->delete($projeto->arquivo);
            }

            $path = $request->file('arquivo')->store('projetos', 'public');
            $projeto->arquivo = $path;
        }

        $projeto->save();

        return redirect()->back()->with('success', 'Projeto atualizado com sucesso!');
    }



    public function list()
    {
        // 1. O CONTEÚDO (Pode vir do banco: ex: Projeto::all())
        $dadosDoProjeto = [
            'nome_modulo' => 'Dominando Inertia com Vue 3',
            'status'      => 'sucesso',
            'aulas_assistidas' => 122
        ];

        // 2. O RETORNO (Envia o Flash e o Conteúdo como "props" pro Vue)
        return Inertia::render('Crud/Index', [
            'retorno' => $dadosDoProjeto,
            'flash'   => [
                'sucesso' => session('sucesso'), 
                'erro'    => session('erro')
            ]
        ]);
    }

    public function destroy($id)
    {
        try{
            Gate::authorize('deletar-usuarios');
            // 1. Busca o projeto pelo ID ou estoura um erro 404 caso não encontre
            $projeto = Projeto::findOrFail($id);
            
            if ($projeto->arquivo) {
                // O Laravel já sabe que deve procurar dentro de 'storage/app/public/' por causa do disco 'public'
                Storage::disk('public')->delete($projeto->arquivo);
                }
                
                // 2. Deleta o registro do banco
                $projeto->delete();
                
                // 3. Redireciona de volta para a listagem
                // O Inertia intercepta isso, recarrega o index() e atualiza a prop 'teste1' no Vue
                return redirect()->back()->with('warning', "Registro ID {$id} excluído com sucesso!");
        } catch ( \Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back()->with('error', $e->getmessage());
        }
    }


    public function destroy1($id){
        // No mundo real seria algo como: 
        // $item = MeuModel::findOrFail($id);
        // $item->delete();
        //Log::info("ID excluido ... {$id}");
        //Log::warning("ID excluido ... {$id}");
        
        //Log::notice("ID excluido ... {$id}");
        //Log::debug("ID excluido ... {$id}");
        //Log::error("ID excluido ... {$id}");
        //Log::critical("ID excluido ... {$id}");
        //Log::emergency("ID excluido ... {$id}");
        LOG::emergency("Servidor caiu",[
            'IP'        => '192.168.18.100',
            'Serviço'   => 'Mysql',
            'Situação'  => 'Estouro de espaço em disco'
        ]);

        Log::emergency("🚨 ALERTA GERAL: COLAPSO CRÍTICO DA INFRAESTRUTURA - PRODUÇÃO FORA DO AR!", [
            'ambiente'         => 'PROD-MAIN-CLUSTER',
            'servico_afetado'  => 'MySQL Server (Daemon: mysqld)',
            'ip_servidor'      => '192.168.18.100',
            'status_retorno'   => 'CATASTRÓFICO / CRITICAL FAILURE',
            'causa_raiz'       => 'Estouro iminente de capacidade em disco (0 bytes livres no volume /var/lib/mysql).',
            'consequencia'     => 'O banco de dados entrou em modo Read-Only preventivo e travou todos os pools de conexão. O SysAdm está completamente inoperante.',
            'acao_imediata'    => 'Derrubar o container, expandir o volume via Docker ou purgar logs antigos/Telescope MANUALMENTE AGORA!',
            'solicitante'      => 'Robô de Monitoramento Auto-SRE'
        ]);

        // Se tiver requisicao externa, vai pro telescope -> http client
        $response = Http::get('https://jsonplaceholder.typicode.com/todos/1');
        
       // dump($id); // -Direto pro telescope -> aba Dumps ( tem que ta com a aba aberta, debug em tempo real)

        // Redireciona de volta para a listagem enviando o flash de sucesso
        return redirect('/crud')->with('success', "Registro ID {$id} excluído com sucesso!");

    }
}
