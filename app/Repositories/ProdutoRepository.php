<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ProdutoRepository
{
    public function listarProdutos(){
        
        $sql = "SELECT * FROM tb_produtos";
        $resultado = DB::select($sql);
        return collect($resultado);
    }

    public function tamanho($id){
        $sql = "SELECT * from tb_tamanhos where produto_id = :id";
        $resultado = DB::select($sql, ['id' => $id]);
        return collect($resultado);
    }


    public function listarCamposById($id){
       // Apelidamos o ID do produto para 'produto_id' para clareza total no Vue

        $sql = "SELECT
                    pc.id AS id_componente,
                    p.nome AS produto_nome,
                    p.id AS produto_id,
                    
                    c.id AS componente_id,
                    c.label AS label_componente,
                    c.tipo_arquivo,
                    pc.requerido,
                    GROUP_CONCAT(
                        e.extensao
                        ORDER BY e.extensao
                        SEPARATOR ', '
                    ) AS extensoes,

                    GROUP_CONCAT(
                        e.nome_formato
                        ORDER BY e.extensao
                        SEPARATOR ', '
                    ) AS formatos

                FROM tb_produtos_componentes AS pc

                INNER JOIN tb_produtos AS p
                    ON p.id = pc.produto_id

                INNER JOIN tb_componentes AS c
                    ON c.id = pc.componente_id

                LEFT JOIN tb_produtos_componentes_extensoes AS pce
                    ON pce.produto_componente_id = pc.id

                LEFT JOIN tb_extensoes AS e
                    ON e.id = pce.extensao_id

                WHERE p.id = :id

                GROUP BY
                    p.nome,
                    p.id,
                    c.id,
                    c.label,
                    c.tipo_arquivo,
                    pc.requerido,
                    pc.id
                ORDER BY
                    c.id;";

         // echo ($sql);exit;
        // Passa o ID no array de parâmetros do DB::select
        $resultado = DB::select($sql, ['id' => $id]);
       // dd($resultado);
        
        return collect($resultado);

    }
}