<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\Usuarios;

class UsuarioRepository
{

    // Passamos o Model pelo construtor (Injeção de Dependência)
    public function __construct(protected Usuarios $model) {
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

    public function atualizar($id, array $dados)
    {
        try{
            $usuario = $this->model->find($id);
            if ($usuario) {
                $a = $usuario->update($dados);
                return $a;
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


    public function visualizaCadastroPorId($id){
        $sql = "SELECT
                    tb_usuarios.id,
                    tb_usuarios.name,
                    tb_usuarios.email,
                    tb_usuarios.cpf_cnpj,
                    tb_usuarios.ie,

                    MAX(CASE
                        WHEN tb_fones.tipo_fone = 1
                        THEN tb_fones.ddd_numero
                    END) AS telefonecel,

                    MAX(CASE
                        WHEN tb_fones.tipo_fone = 2
                        THEN tb_fones.ddd_numero
                    END) AS telefonefixo

                FROM tb_usuarios
                LEFT JOIN tb_fones
                    ON tb_fones.usuario_id = tb_usuarios.id

                WHERE tb_usuarios.id = {$id}

                GROUP BY
                    tb_usuarios.id,
                    tb_usuarios.name,
                    tb_usuarios.email,
                    tb_usuarios.cpf_cnpj,
                    tb_usuarios.ie;";
        $resultado = DB::select($sql);
        return Usuarios::hydrate($resultado)->first();
    }



}