<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\PedidoItemArquivo;

class PedidoItemArquivoRepository
{
    // Passamos o Model pelo construtor (Injeção de Dependência)
    public function __construct(protected PedidoItemArquivo $pedidoItemArquivo) {}

    public function findAll()
    {
        return $this->pedidoItemArquivo->all();
    }

    public function findById($id)
    {
        return $this->pedidoItemArquivo->where('pedido_item_id', $id)->get();
    }

    public function salvar(array $dados)
    {
        try{
            $pedidoItem = $this->pedidoItemArquivo->create($dados);
            return $pedidoItem->id;

        }catch(\Throwable $e){
            Log::error('Erro ao salvar: ' . $e->getMessage());
            throw $e;
        }
    }

    public function atualizar($id, array $dados)
    {
        try{
            $pedidoItem = $this->pedidoItemArquivo->find($id);
            if ($pedidoItem) {
                $pedidoItem->update($dados);
                return true;
            }
            return false;
        }catch(\Throwable $e){
            Log::error('Erro ao atualizar: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deletar($id)
    {
        try{
            $pedidoItem = $this->pedidoItemArquivo->find($id);
            if ($pedidoItem) {
                $pedidoItem->delete();
                return true;
            }
            return false;
        }catch(\Throwable $e){
            Log::error('Erro ao deletar: ' . $e->getMessage());
            throw $e;
        }
    }
    
}