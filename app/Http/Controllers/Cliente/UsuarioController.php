<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\TipoEnderecoRepository;
use App\Repositories\EnderecoRepository;
use App\Repositories\UsuarioRepository;
use App\Repositories\FoneRepository;
use Illuminate\Support\Facades\Route;


class UsuarioController extends Controller
{

    use ValidatesRequests;

    public function __construct(
        protected TipoEnderecoRepository $tipoEnderecoRepository, 
        protected EnderecoRepository $enderecoRepository,
        protected UsuarioRepository $usuarioRepository,
        protected FoneRepository $foneRepository
    
        ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return Inertia::render('Usuario/Index');
    }

    public function alterarDados(){

    //print_r($this->enderecoRepository->selecionaEnderecoByID(request('enderecoId')));    exit;
        return Inertia::render('Usuario/MeusDados',[
            'dados_pessoais'        => $this->usuarioRepository->visualizaCadastroPorId(Auth::user()->id),
            'tipos_enderecos'       => $this->tipoEnderecoRepository->findAll(),
            'enderecos_cadastrados' => $this->enderecoRepository->listarEnderecosByID(Auth::user()->id),
            'permissoes'            => Auth::user()->hasPermission(Route::currentRouteName()),
            'endereco_editado' => Inertia::lazy(function () {
                return $this->enderecoRepository->selecionaEnderecoByID(request('enderecoId'));
            }),

        ]);
    }

    public function excluirEndereco($id){
        $this->enderecoRepository->deletar($id);
        return redirect()->route('usuario.ajustes')->with('success', 'Excluido com sucesso!');
    }

    public function editarEndereco($id){
        return Inertia::render('Usuario/MeusDados',[
            'dados_pessoais'        => $this->usuarioRepository->visualizaCadastroPorId(Auth::user()->id),
            'tipos_enderecos'       => $this->tipoEnderecoRepository->findAll(),
            'enderecos_cadastrados' => $this->enderecoRepository->listarEnderecosByID(Auth::user()->id),
            'endereco_editado' => $this->enderecoRepository->selecionaEnderecoByID($id)
            ]);

    }

    public function SalvaralterarDados(Request $request){
        log::error($request->all());
        /*$a = $this->validate($request, [
            'apelido' => 'required|string|max:255',
            'cep' => 'required|string|max:10',
            'endereco' => 'required|string|max:255',
            'numero' => 'required|string|max:10',   
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'tipo_endereco_id' => 'required'
            // Adicione outras validações conforme necessário
        ]);*/

        try{
            DB::beginTransaction();
                $dados = [
                    'id'    => $request->id,
                    'apelido' => $request->apelido,
                    'cep' => $request->cep,
                    'endereco' => $request->endereco,
                    'numero' => $request->numero,
                    'bairro' => $request->bairro,
                    'cidade' => $request->cidade,
                    'estado' => $request->estado,
                    'usuario_id' => Auth::user()->id,
                    'tipo_endereco_id' => $request->tipo_endereco_id
                ];
            if ($request->id){
                $this->enderecoRepository->atualizar($request->id, $dados);
            }else{

                $this->enderecoRepository->salvar($dados);
            }
            
            DB::commit();// Sempre ultimo antes do Return
            return redirect()->route('usuario.ajustes')->with('success', 'Cadastrado com sucesso!');

        }catch(\Throwable $e){
            DB::rollBack();
            // Grava o erro detalhado no log do Laravel (storage/logs/laravel.log) para você analisar depois
            Log::error('Erro ao salvar pedido: ' . $e->getMessage(), ['exception' => $e]);

            // Retorna para a tela anterior mostrando o erro amigável ao usuário
            return redirect()->back()->with('error', $e->getMessage() );
        }
        
    }

    // Update...
    public function  SalvaralterarDadosPessoais (Request $request){

        $this->usuarioRepository->atualizar( Auth::user()->id, [
        'name'      => $request->nome,
        'cpf_cnpj'  => $request->cpf_cnpj,
        'ie'        => $request->ie,
        'email'     => $request->email,
        'id'        => Auth::user()->id,
        'password'  => Auth::user()->password
        ]);
        
        $this->foneRepository->atualizar( 
            [
                'usuario_id' => Auth::user()->id,
                'tipo_fone'     => 2
            ], ['ddd_numero' => $request->telefonefixo]);

        $this->foneRepository->atualizar( [
            'usuario_id'=> Auth::user()->id,
            'tipo_fone' => 1
        ], ['ddd_numero' => $request->telefonecel]);

        return redirect()->route('usuario.index')->with('success', 'Atualizado com sucesso!');

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
