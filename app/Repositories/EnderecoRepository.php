<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Enderecos;

class EnderecoRepository
{
    public function __construct(protected Enderecos $model) {}

    public function findById($id,$coluna = 'id')
    {
        //return $this->model->find($id, $coluna);
        return $this->model->where($coluna, $id)->get();
    }

    public function findAll()
    {
        return $this->model->all();
    }

    public function listarEnderecosByID($idCliente){
        $sql = "SELECT * 
                from tb_enderecos
                inner join tb_tipo_endereco 
                    on tb_tipo_endereco.id = tb_enderecos.tipo_endereco_id
                where usuario_id = $idCliente";
        
        $sql = DB::select($sql);
        $sql = Enderecos::Hydrate($sql);
        return $sql;
    }

    public function salvar(array $dados)
    {
        try{
            $dado = $this->model->create($dados);
            return $dado->id;
        }catch(\Throwable $e){
            Log::error('Erro ao salvar usuário: ' . $e->getMessage());
           throw $e;
        }
    }

    public function atualizar($id, array $dados)
    {
        try{
            $atualizar = $this->model->find($id);
            if ($atualizar) {
                $atualizar->update($dados);
                return true;
            }
            return false;
        }catch(\Throwable $e){
            Log::error('Erro ao atualizar usuário: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deletar($id)
    {
        try{
            $deletar = $this->model->find($id);
            if ($deletar) {
                $deletar->delete();
                return true;
            }
            return false;
        }catch(\Throwable$e){
            Log::error('Erro ao deletar usuário: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Localiza e pagina os cadastros ativos no sistema.
     * * @param int $perPage Quantidade de registros por página.
     * @param string|null $busca Termo para filtrar nome ou e-mail.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = 15, $busca = null)
    {
        $query = $this->model->query();

        if (!empty($busca)) {
            $query->where(function ($q) use ($busca) {
                $q->where('nome', 'like', "%{$busca}%")
                ->orWhere('email', 'like', "%{$busca}%")
                ->orWhere('cidade', 'like', "%{$busca}%");
                if (is_numeric($busca)) {
                    $q->orWhere('id', $busca);
                }

            });
        }

        return $query->orderBy('id', 'asc')->paginate($perPage);
    }

}