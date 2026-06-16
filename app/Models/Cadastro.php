<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cadastro extends Model
{

    protected $fillable = ['nome','email','ddd_telefone','ddd_celular','cpf_cnpj','cep','endereco','nr','bairro','cidade','estado'];

    // Proibidos no insert, update
    protected $guarded = ['is_admin'];
}
