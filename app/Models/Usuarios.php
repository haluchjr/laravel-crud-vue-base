<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\ValidationException;
use App\Models\Perfil;
use App\Models\NivelPermissao;
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
    
    public function hasPermission(string $urlAmigavel, bool $exibirAcoes = false)
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
        
        $sql = "SELECT
                    COALESCE (tb_nivel_permissoes.criar, 0) AS criar,
                    COALESCE ( tb_nivel_permissoes.editar, 0) AS editar,
                    COALESCE (tb_nivel_permissoes.excluir, 0) AS excluir,
                    COALESCE (tb_nivel_permissoes.ver, 0) AS ver,
                    COALESCE (tb_nivel_permissoes.btn_pdf, 0) AS btn_pdf
                FROM
                    tb_nivel_permissoes
                where 
                    tb_nivel_permissoes.nivel_id = :nivel_id
                AND tb_nivel_permissoes.url_amigavel = :menu_url";

        $resultado = DB::selectOne($sql, [
            'nivel_id' => $this->nivel,
            'menu_url' => $urlAmigavel
            ]); 

        if (!$resultado && !$exibirAcoes){
            abort(403, 'Rota não mapeada para permissões.');
            return false;
        }

        return $resultado;

    }

} // Fim classe
