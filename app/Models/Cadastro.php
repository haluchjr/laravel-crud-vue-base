<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Crypt;

class Cadastro extends Model
{
    use HasFactory;


    protected $appends = ['id_criptografado'];

    protected $table = "tb_cadastro";

    protected $fillable = [
        'nome',
        'email',
        'ddd_telefone',
        'ddd_celular',
        'cpf_cnpj',
        'cep',
        'endereco',
        'nr',
        'bairro',
        'cidade',
        'estado',
        'foto',
    ];

    // Proibidos no insert, update
    protected $guarded = ['is_admin'];

    /**
     * Gera o ID mascarado/criptografado
     */
    public function getIdCriptografadoAttribute(): string
    {
        return Crypt::encryptString($this->id);
    }

  
}
