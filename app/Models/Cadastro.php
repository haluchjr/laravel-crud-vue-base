<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cadastro extends Model
{
    use HasFactory;

    protected $table = "cadastro";
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
        'estado'
    ];

    // Proibidos no insert, update
    protected $guarded = ['is_admin'];
}
