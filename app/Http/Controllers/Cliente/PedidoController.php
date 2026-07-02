<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
// user request
use App\Http\Requests\ValidaNovoPedidoRequest;

use App\Repositories\ProdutoRepository as ProdutoGeralRepository;
use App\Repositories\PedidoRepository as PedidoGeralRepository;
use App\Repositories\PedidoItensRepository as PedidoItensGeralRepository;
use App\Repositories\PedidoItemArquivoRepository as PedidoItemArquivoGeralRepository;
use App\Repositories\Cliente\PedidoRepository as PedidoClienteRepository;

class PedidoController extends Controller
{
    public function __construct(
        protected ProdutoGeralRepository $ProdutoGeralRepository,
        protected PedidoClienteRepository $PedidoClienteRepository,
        protected PedidoGeralRepository $PedidoGeralRepository,
        protected PedidoItensGeralRepository $PedidoItensGeralRepository,
        protected PedidoItemArquivoGeralRepository $PedidoItemArquivoGeralRepository
    ) {}



    public function listar(){
        $pedidos = $this->PedidoClienteRepository->listarPedidosByIdCliente(Auth::user()->id);
        return Inertia::render('Cliente/Listar',[
            'dados'         => $pedidos,
            'itensPedido'   => Inertia::lazy(fn () => $this->PedidoClienteRepository->obterItens(request('pedido_id')))
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
       $produtos = $this->ProdutoGeralRepository->listarProdutos();

        return Inertia::render('Cliente/Index', [
            'produtos' => $produtos,

            // 2. Transforma o 'formulario' em Lazy.
            // Só vai rodar no banco quando o dropdown no Vue for acionado.
            'formulario' => Inertia::lazy(function () {
                $produtoId = request('produto_id');
                return $this->ProdutoGeralRepository->listarCamposById($produtoId);
            }),
            'tamanhos' => Inertia::lazy(function () {
                $produtoId = request('produto_id');
                return $this->ProdutoGeralRepository->tamanho($produtoId);
            }),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
             //dd($request->all());
        try{
            DB::beginTransaction();

            $nrPedido = $this->PedidoGeralRepository->salvar([
                'cliente_id'    => Auth::user()->id,
                'data_inclusao' => date('Y-m-d'),
                'data_entrega'  => date('Y-m-d'), // Trazer futuramente de outro local
                'observacao'    => $request->input('observacao'),
                'descricao'     => $request->input('observacao'),
            ]);

            $nrItemPedido = $this->PedidoItensGeralRepository->salvar([
                'pedido_id'     => $nrPedido,
                'produto_id'    => $request->input('product_id'),
                'tamanho_id'    => $request->input('produto_tamanho_id'),
                //'quantidade'  => 1, // Trazer futuramente de outro local
            ]);
        
        
            if ($request->has('files') && is_array($request->input('files'))) {

                foreach ($request->input('files') as $index => $item) {
                    
                    if ($request->hasFile("files.{$index}.file") && $request->file("files.{$index}.file")->isValid()) {
                        
                        $arquivo = $request->file("files.{$index}.file");
                        
                        // Pegamos o nome original que o cliente enviou (ex: "manual_da_grafica.pdf")
                        $nomeOriginalCliente = $arquivo->getClientOriginalName();
                       
                        // Geramos o seu nome único em MD5 para o processo interno
                        //$nomeInternoMD5 = md5(uniqid()) . '.' . $arquivo->getClientOriginalExtension();
                        $nomeInternoMD5 = $nrPedido . "_". $nrItemPedido . $item['tipo_arquivo'] ."." .$arquivo->getClientOriginalExtension();// Prefixo para identificar que é um arquivo de pedido
                        

                        $ano = date('Y');
                        $mes = date('m');
                        $dia = date('d');
                        // Definimos a pasta de destino dentro do seu public
                        $diretorioDestino = public_path('artes') . '/' . $ano . '/'. $mes . '/' . $dia .'/'. $nrPedido;
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
-
                        $this->PedidoItemArquivoGeralRepository->salvar([
                            'pedido_item_id'        => $nrItemPedido,
                            'data_inclusao'         => date('Y-m-d H:i:s'),
                            'produto_componente_id' => $item['produtos_componentes_id'],
                            'nome_original'         => $nomeOriginalCliente, // Nome que o cliente enviou  
                            'nome_interno'          => $nomeInternoMD5,      // Nome que o sistema vai usar
                            'caminho_arquivo'       => $diretorioDestino . '/' . $nomeInternoMD5,
                            'caminho_backup'        => 'tmp/' . $nomeOriginalCliente, // Qdo o pedido mudar para ENTREGUE , apagar automaticamente. e tb apagar o arquivo de produção.
                        ]);

                    }
                }
                DB::commit();
                return redirect()->route('usuario.index')->with('success', 'Cadastrado com sucesso!');
            }
        }catch(\Throwable $e){
            DB::rollBack();

            if (!empty($arquivosCriados)) {
                foreach ($arquivosCriados as $caminhoArquivo) {
                    if (file_exists($caminhoArquivo)) {
                        unlink($caminhoArquivo);
                    }
                }
            }

            // Grava o erro detalhado no log do Laravel (storage/logs/laravel.log) para você analisar depois
            Log::error('Erro ao salvar pedido: ' . $e->getMessage(), ['exception' => $e]);

            // Retorna para a tela anterior mostrando o erro amigável ao usuário
            return redirect()->back()->withInput()->with('error', 'Falha ao salvar o pedido. Tente novamente.');
        }
    }


    public function limpaPedidoEntregue($id){
        try{
            DB::beginTransaction();

           // $pedido = $this->PedidoGeralRepository->findById($id);
           // if (!$pedido) {
              //  return redirect()->back()->with('error', 'Pedido não encontrado.');
          //  }

            // Exclui os arquivos associados ao pedido
            $arquivos = $this->PedidoItemArquivoGeralRepository->findById($id);
            foreach ($arquivos as $arquivo) {
                if (file_exists($arquivo->caminho_arquivo)) {
                    unlink($arquivo->caminho_arquivo);
                }
                if (file_exists(public_path($arquivo->caminho_backup))) {
                    unlink(public_path($arquivo->caminho_backup));
                }
                $this->PedidoItemArquivoGeralRepository->deletar($arquivo->id);
            }

            /*
            // da pra incluir uma anotacao no log do pedido.
            // Exclui os itens do pedido
            $itens = $this->PedidoItensGeralRepository->findById($id);
            foreach ($itens as $item) {
                $this->PedidoItensGeralRepository->deletar($item->id);
            }

            // Exclui o pedido
            $this->PedidoGeralRepository->deletar($id);
            */
            DB::commit();
            return redirect()->route('usuario.index')->with('success', 'Pedido excluído com sucesso!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Erro ao excluir pedido: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->with('error', 'Falha ao excluir o pedido. Tente novamente.');
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
