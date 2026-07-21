<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\ValidationException;
use App\Models\Perfil;
use App\Models\NivelPermissao;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class Usuarios extends Authenticatable
{
    use HasFactory, Notifiable;


    protected $table = "tb_usuarios";
    //protected $guarded = []; // Se tiver nao entra.
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'nivel'
    ];
    
    protected $casts = [
        'nivel' => 'integer',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function temAcesso(string $nivelRequerido): bool
    {
        // Se o usuário for admin, ele tem acesso a tudo
        if ($this->nivel === 'admin') {
            return true;
        }

        return $this->nivel === $nivelRequerido;
    }
    
    public function hasPermission(string $urlAmigavel, string $acao, bool $exibirOpcoes = false)
    {
        if ($this->nivel == 99){

            $colunas = \Schema::getColumnListing('tb_nivel_permissoes');
            // Colunas que queremos ignorar (metadados e chaves)
            $ignorar = ['id', 'nivel_id', 'url_amigavel', 'created_at', 'updated_at'];

            $adminPermissoes = [];
            foreach ($colunas as $coluna) {
                if (!in_array($coluna, $ignorar)) {
                    $adminPermissoes[$coluna] = 1; // Dá acesso total a qualquer permissão existente
                }
            }
                return (object) $adminPermissoes;
        }

        if (in_array($urlAmigavel ,['usuario.index','login','logout','redirect'])){
            return true;
        }
        
        // if (!$this->nivel){
        //     abort(403, 'Rota não mapeada para permissões.');
        //     return false;
        // }
        
        $acoesPermitidas = [
            'botoes',
            'salvar',
            'editar',
            'excluir',
            'ver',
            'btn_pdf',
        ];

        if (! in_array($acao, $acoesPermitidas, true)) {
            ////throw new InvalidArgumentException('Ação inválida.');
            echo "ruim,..";exit;
        }

        if (!is_null($acao)){

            if ($acoesPermitidas[0] == $acao && $exibirOpcoes){
                $sql = "SELECT *
                    FROM tb_nivel_permissoes
                    where tb_nivel_permissoes.url_amigavel = '{$urlAmigavel}' ";

                $resultado = DB::selectOne($sql);


                if(!is_object($resultado)){
                    log::error("Problema com permissão. Verificar banco. " ,[
                        'URL Amigavel' => $urlAmigavel,
                    ]);
                    return false;
                }
                
                return $resultado;  
            }


            $sql = "SELECT
                        EXISTS 
                        (
                            SELECT
                                1
                            FROM
                                tb_nivel_permissoes
                            where tb_nivel_permissoes.url_amigavel = '{$urlAmigavel}' 
                            and tb_nivel_permissoes.{$acao} = '1'
                        ) AS autorizado";
                        
            $resultado = DB::selectOne($sql);
            if ((int)$resultado->autorizado !== 1 ){
                return false;
            }

            return $resultado;
        }

        


    }

} // Fim classe
