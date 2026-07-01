<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\ValidaNovoPedidoRequest;

use App\Repositories\ProdutoRepository;

use App\Repositories\Cliente\PedidoRepository;
use App\Repositories\PedidoRepository as PedidoRepositoryBase;

class PedidoController extends Controller
{
    public function __construct(
        protected PedidoRepository $PedidoRepository, 
        protected PedidoRepositoryBase $PedidoRepositoryBase,
        protected ProdutoRepository $ProdutoRepository ) {}



    public function listar(){
        $pedidos = $this->PedidoRepository->listarPedidosByIdCliente(Auth::user()->id);
        return Inertia::render('Cliente/Listar',[
            'dados'=> $pedidos,
            'itensPedido' => Inertia::lazy(fn () => $this->PedidoRepository->obterItens(request('pedido_id')))
        ]);
    
    }


    public function relatorioPedidos(){ 
        dd('relatorio pedidos');
        return Inertia::render('Pedido/Relatorio');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       $produtos = $this->ProdutoRepository->listarProdutos();

        return Inertia::render('Cliente/Index', [
            'produtos' => $produtos,

            // 2. Transforma o 'formulario' em Lazy.
            // Só vai rodar no banco quando o dropdown no Vue for acionado.
            'formulario' => Inertia::lazy(function () {
                $produtoId = request('produto_id');
                return $this->ProdutoRepository->listarCamposById($produtoId);
            }),
            'tamanhos' => Inertia::lazy(function () {
                $produtoId = request('produto_id');
                return $this->ProdutoRepository->tamanho($produtoId);
            }),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->input('files'));
        // Gerou numero do pedido e gravou no banco de dados.
        // Gerou numero do item do pedido e gravou no banco de dados.
        if ($request->has('files') && is_array($request->input('files'))) {

            foreach ($request->input('files') as $index => $item) {
                
                if ($request->hasFile("files.{$index}.file") && $request->file("files.{$index}.file")->isValid()) {
                    
                    $arquivo = $request->file("files.{$index}.file");
                    
                    // Pegamos o nome original que o cliente enviou (ex: "manual_da_grafica.pdf")
                    $nomeOriginalCliente = $arquivo->getClientOriginalName();
                    $d = date('d');
                    $m = date('m');
                    $y = date('Y');
                    $h = date('H');
                    $i = date('i');
                    $s = date('s');
                    // Geramos o seu nome único em MD5 para o processo interno
                    //$nomeInternoMD5 = md5(uniqid()) . '.' . $arquivo->getClientOriginalExtension();
                    $nomeInternoMD5 = 'pedido_' . $d . '_' . $m . '_' . $y . '_' . $h . '_' . $i . '_' . $s ."." .$arquivo->getClientOriginalExtension();// Prefixo para identificar que é um arquivo de pedido
                    
                    // Definimos a pasta de destino dentro do seu public
                    $diretorioDestino = public_path('artes');
                    $diretorioTmp = public_path('tmp');

                    // --- PASSO 1: Salvar o arquivo de BACKUP (Nome Original) ---
                    // Como o método 'move' retira o arquivo do TMP na primeira vez,
                    // usamos 'copy' ou fazemos o move do backup primeiro.
                    
                    // Criamos uma cópia do arquivo temporário direto para a pasta de backup
                    // Isso garante que o arquivo temporário continue intacto para o próximo passo
                    copy($arquivo->getRealPath(), $diretorioTmp . '/'. $nomeOriginalCliente);


                    // --- PASSO 2: Salvar o arquivo de PRODUÇÃO (Nome em MD5) ---
                    // Agora sim, movemos o arquivo temporário original para o seu nome definitivo.
                    // O PHP vai limpar o TMP automaticamente após esse move.
                    $arquivo->move($diretorioDestino, $nomeInternoMD5);


                    // --- PASSO 3: Gravar os caminhos no Banco de Dados ---
                    // DB::table('order_item_files')->insert([
                    //     'order_item_id'        => $orderItemId,
                    //     'product_component_id' => $item['product_component_id'],
                    //     'file_path'            => 'uploads/pedidos/' . $nomeInternoMD5,         // Arquivo que o sistema vai usar
                    //     'backup_path'          => 'uploads/pedidos/backup_' . $nomeOriginalCliente, // Seu backup de segurança
                    //     'created_at'           => now(),
                    //     'updated_at'           => now(),
                    // ]);
                }
            }
        }
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
