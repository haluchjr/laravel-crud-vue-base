<?php
namespace App\Repositories\Cliente;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Request;

use App\Models\Pedidos;

class PedidoRepository
{
    // Passamos o Model pelo construtor (Injeção de Dependência)
    public function __construct(protected Pedidos $pedido) {}

    public function listarPedidosByIdCliente($idCliente, $limite = 5){
        $sql = "SELECT 
                    tb_usuarios.name,
                    tb_pedidos.id nr_pedido,
                    tb_pedidos.descricao,
                    date_format(tb_pedidos.data_inclusao, '%d/%m/%Y') data_inclusao,
                    date_format(tb_pedidos.data_entrega, '%d/%m/%Y') data_entrega,
                    tb_pedidos.status_pedido_id,
                    tb_status_pedido.descricao_site,
                    CONCAT('R$ ', FORMAT(tb_pedidos.valor_total_pedido, 2, 'pt_BR')) valor_total_pedido
                FROM tb_pedidos 
                INNER JOIN tb_status_pedido on tb_status_pedido.id = tb_pedidos.status_pedido_id
                inner join tb_usuarios on tb_usuarios.id = tb_pedidos.cliente_id
                where cliente_id = $idCliente 
                order by  tb_pedidos.id desc
                limit $limite";
        //echo $sql;exit;
        $sql = DB::select($sql);
        $sql = Pedidos::Hydrate($sql);
        return $sql;
    }

    public function obterItens($id){
        $sql = "SELECT
                    tb_componentes.label,
                    tb_pedidos_itens_arquivos.caminho_arquivo,
                    REPLACE(
                        TRIM(TRAILING '/' FROM REPLACE(
                            REPLACE(caminho_arquivo, SUBSTRING_INDEX(caminho_arquivo, '/', -1), ''),
                            '/var/www/html/', '' 
                        )),
                        '/', '\\\\' 
                    ) AS caminho_limpo
                FROM
                    tb_pedido_itens
                INNER JOIN tb_pedidos_itens_arquivos ON tb_pedidos_itens_arquivos.pedido_item_id = tb_pedido_itens.id
                inner join tb_componentes on tb_componentes.id = tb_pedidos_itens_arquivos.produto_componente_id
                WHERE
                    pedido_id = $id ";
                
        $sql = DB::select($sql);
        $sql = Pedidos::Hydrate($sql);
        return $sql;
    }


    // Somente consultas pontuais, se repetir colar no PedidoRepository na raiz.
    public function tudo1(){
        $sql = "select * from fk_pedid";
        $sql = DB::select($sql);
        $sql = Pedidos::Hydrate($sql);
        return response()->json($sql);
        
    }

    public function tudo(){
        $perPage = 1;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // 2. Calcule o OFFSET para o SQL
        $offset = ($currentPage - 1) * $perPage;

        // 3. Busque apenas os dados da página atual usando LIMIT e OFFSET
        $dadosRaw = DB::select("
            SELECT * FROM tb_pedido
            LIMIT :limit OFFSET :offset
        ", [
            'limit' => $perPage,
            'offset' => $offset
        ]);

        // 4. Pegue o total geral de registros (necessário para o paginador saber o total de páginas)
        $totalGeral = DB::selectOne("SELECT COUNT(*) as total FROM tb_usuarios")->total;

        // 5. Hidrate os dados brutos para o Model Pedido
        $itensHidratados = Pedido::hydrate($dadosRaw);

        // 6. Monte o Paginador Manual
        $paginador = new LengthAwarePaginator(
            $itensHidratados, // Os itens da página atual (já transformados em Model)
            $totalGeral,      // Total de registros no banco
            $perPage,         // Itens por página
            $currentPage,     // Página atual
            ['path' => Request::url(), 'query' => Request::query()] // Mantém os filtros da URL
        );

        // Retorna o JSON estruturado com 'data', 'current_page', 'last_page', etc.
        return $paginador;
        
    }
    
}