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

    public function hasPermission($a){}
    
    public function hasPermission1(string $urlAmigavel)
    {
        if (in_array($urlAmigavel ,['usuario.index','login','logout','redirect'])){
            return true;
        }
        
        if (!$this->nivel){
            abort(403, 'Rota não mapeada para permissões.');
            return false;
        }
        
        $sql = "SELECT 
                    -- tb_usuarios.id,
                    -- tb_usuarios.`name`,
                    -- tb_usuarios.nivel,
                    -- tb_perfil.descricao,
                    -- tb_menus.nome,
                    -- tb_menus.url,
                COALESCE(tb_nivel_permissoes.criar, 0) AS criar,
                COALESCE(tb_nivel_permissoes.editar, 0) AS editar,
                COALESCE(tb_nivel_permissoes.excluir, 0) AS excluir,
                COALESCE(tb_nivel_permissoes.ver, 0) AS ver,
                COALESCE(tb_nivel_permissoes.btn_pdf, 0) AS btn_pdf
                    
                FROM tb_usuarios
                inner join tb_perfil on tb_perfil.id = tb_usuarios.nivel
                inner join tb_nivel_permissoes on tb_nivel_permissoes.nivel_id = tb_usuarios.nivel
                inner join tb_menus on tb_menus.id = tb_nivel_permissoes.menu_id
                where tb_usuarios.nivel = :nivel_id
                and tb_menus.url = :menu_url ";

        $resultado = DB::selectOne($sql, [
            'nivel_id' => $this->nivel,
            'menu_url' => $urlAmigavel
            ]);
        
        if (!$resultado ){
            abort(403, 'Rota não mapeada para permissões.');
            return false;
        }

        //var_dump($resultado);exit;
        return $resultado;


    }
}
