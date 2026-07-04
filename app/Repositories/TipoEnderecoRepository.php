<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\TipoEndereco;

class TipoEnderecoRepository
{
    // Passamos o Model pelo construtor (Injeção de Dependência)
    public function __construct(protected TipoEndereco $tipoEndereco) {}

    public function findAll()
    {
        return $this->tipoEndereco->all();
    }

    public function listarTipoEnderecos(){
        $sql = "SELECT * FROM tb_tipo_endereco";
        $resultado = DB::select($sql);
        //return collect($resultado);
         return TipoEndereco::hydrate($resultado);
    }

    
}