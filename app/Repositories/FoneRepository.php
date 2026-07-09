<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\Fone;

class FoneRepository
{
    // Passamos o Model pelo construtor (Injeção de Dependência)
    public function __construct(protected Fone $model) {
    }

    public function salvar(array $dados)
    {
        try{
            $this->model->create($dados);

        }catch(\Exception $e){
            // Log do erro
            Log::error('Erro ao salvar usuário: ' . $e->getMessage());
           //throw new \Exception('Erro ao salvar usuário.');
            return false;
        }
    }

    public function atualizar( array $coluna, array $dados)
    {
        try{
            $usuario = $this->model->where($coluna)->first();
            if ($usuario) {
                return $usuario->update($dados);
                //return true;
            }
            return false;
        }catch(\Exception $e){
            // Log do erro
            Log::error('Erro ao atualizar usuário: ' . $e->getMessage());
            //throw new \Exception('Erro ao atualizar usuário.');
            return false;
        }
    }

    public function deletar($id)
    {
        try{
            $usuario = $this->model->find($id);
            if ($usuario) {
                $usuario->delete();
                return true;
            }
            return false;
        }catch(\Exception $e){
            // Log do erro
            Log::error('Erro ao deletar usuário: ' . $e->getMessage());
            //throw new \Exception('Erro ao deletar usuário.');
            return false;
        }
    }

    public function findById($id)
    {
        return $this->usuario->find($id);
    }

    public function findAll()
    {
        return $this->usuario->all();
    }



}