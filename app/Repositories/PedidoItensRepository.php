<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\PedidoItens;

class PedidoItensRepository
{
    // Passamos o Model pelo construtor (Injeção de Dependência)
    public function __construct(protected PedidoItens $model) {}

    public function findAll()
    {
        return $this->model->all();
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function salvar(array $dados)
    {
        
        try{
            $pedido = $this->model->create($dados);
            return $pedido->id;

        }catch(\Exception $e){
            Log::error('Erro ao salvar: ' . $e->getMessage());
            return false;
        }
    }

    public function atualizar($id, array $dados)
    {
        try{
            $pedido = $this->model->find($id);
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
            $pedido = $this->model->find($id);
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