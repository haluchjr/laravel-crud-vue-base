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
//use App\Repositories\FoneRepository;



class UsuarioController extends Controller
{

    use ValidatesRequests;

    public function __construct(
        protected TipoEnderecoRepository $tipoEnderecoRepository, 
        protected EnderecoRepository $enderecoRepository,
        protected UsuarioRepository $usuarioRepository,
        //protected FoneRepository $foneRepository
    
        ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return Inertia::render('Usuario/Index');
    }

    public function alterarDados(){
        

        return Inertia::render('Usuario/MeusDados',[
            'dados_pessoais'        => $this->usuarioRepository->visualizaCadastroPorId(Auth::user()->id),
            'tipos_enderecos'       => $this->tipoEnderecoRepository->findAll(),
            'enderecos_cadastrados' => $this->enderecoRepository->listarEnderecosByID(Auth::user()->id),

        ]);
    }

    public function SalvaralterarDados(Request $request){
        log::error($request->all());

        $a = $this->validate($request, [
            'apelido' => 'required|string|max:255',
            'cep' => 'required|string|max:10',
            'endereco' => 'required|string|max:255',
            'numero' => 'required|string|max:10',   
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'tipo_endereco_id' => 'required'
            // Adicione outras validações conforme necessário
        ]);

        try{
            DB::beginTransaction();
                $dados = [
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

            $this->enderecoRepository->salvar($dados);
            
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

        $dados = [
            'nome'      => $request->nome,
            'cpf_cnpj'  => $request->cpf_cnpj,
            'ie'        => $request->ie,
            'email'     => $request->email,
            'id'        => Auth::user()->id
        ];

        $dadosFoneFixo = [
            'usuario_id' => Auth::user()->id,
            'ddd_numero' => $request->telefonefixo,
            'tipo_fone'  => 1
        ];

        $dadosFoneCel = [
            'usuario_id' => Auth::user()->id,
            'ddd_numero' => $request->telefonecel,
            'tipo_fone'  => 2
        ];
        
       // $this->usuarioRepository->salvar($dados);
       // $this->foneRepository->salvar($dadosFoneFixo);
       // $this->foneRepository->salvar($dadosFoneCel);

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
