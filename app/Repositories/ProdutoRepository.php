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
        $sql = "select 
                    tb_produtos.nome produto_nome,
                    tb_produtos.id as produto_id,
                    tb_componentes.id id_componente,
                    tb_componentes.label label_componente,
                    tb_produtos_componentes.requerido
                from tb_produtos
                inner join tb_produtos_componentes on tb_produtos_componentes.produto_id = tb_produtos.id
                inner join tb_componentes on tb_componentes.id = tb_produtos_componentes.componente_id
                where tb_produtos.id = :id"; // Trocado por :id (seguro)

        // Passa o ID no array de parâmetros do DB::select
        $resultado = DB::select($sql, ['id' => $id]);

        return collect($resultado);

    }
}