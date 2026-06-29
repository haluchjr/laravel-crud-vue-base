<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\Pedido;

class PedidoRepository
{
    //
    //! status
    //? param
    // Passamos o Model pelo construtor (Injeção de Dependência)
    public function __construct(protected Pedido $pedido) {}

    public function findAll()
    {
        return $this->pedido->all();
    }

    public function findById($id)
    {
        return $this->pedido->find($id);
    }

    public function salvar(array $dados)
    {
        try{
            return $this->pedido->create($dados);

        }catch(\Exception $e){
            Log::error('Erro ao salvar: ' . $e->getMessage());
            return false;
        }
    }

    public function atualizar($id, array $dados)
    {
        try{
            $pedido = $this->pedido->find($id);
            if ($pedido) {
                $pedido->update($dados);
                return true;
            }
            return false;
        }catch(\Exception $e){
            Log::error('Erro ao atualizar: ' . $e->getMessage());
            return false;
        }
    }

    public function deletar($id)
    {
        try{
            $pedido = $this->pedido->find($id);
            if ($pedido) {
                $pedido->delete();
                return true;
            }
            return false;
        }catch(\Exception $e){
            Log::error('Erro ao deletar: ' . $e->getMessage());
            return false;
        }
    }
    
}