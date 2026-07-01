<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory; 
    
    protected $table = "tb_endereco";

    protected $fillable = []; // Permite insert

    // Proibidos no insert, update
    protected $guarded = []; // Se tiver nao entra.

}