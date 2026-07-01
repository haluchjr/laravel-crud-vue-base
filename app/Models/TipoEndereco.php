<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoEndereco extends Model
{
    use HasFactory; 
    
    protected $table = "tb_tipo_endereco";

    protected $fillable = []; // Permite insert

    // Proibidos no insert, update
    protected $guarded = []; // Se tiver nao entra.

}