<?php
namespace App\Repositories;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\Cadastro;

class CadastroRepository
{
    public function __construct(protected Cadastro $model) {
        $this->model = $model;
    }

    public function salvar(array $dados)
    {
        try{
            return $this->model->create($dados);

        }catch(\Exception $e){
            Log::error('Erro ao salvar usuário: ' . $e->getMessage());
            return false;
        }
    }

    public function atualizar($id, array $dados)
    {
        try{
            $usuario = $this->model->find($id);
            if ($usuario) {
                $usuario->update($dados);
                return true;
            }
            return false;
        }catch(\Exception $e){
            Log::error('Erro ao atualizar usuário: ' . $e->getMessage());
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
            Log::error('Erro ao deletar usuário: ' . $e->getMessage());
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