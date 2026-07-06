<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enderecos extends Model
{
    
    protected $table = "tb_enderecos";

    //protected $fillable = []; // Permite insert

    // Proibidos no insert, update
    protected $guarded = []; // Se tiver nao entra.

    // Nao cisma com falta do created_at / updated_at
    public $timestamps = false;
}