<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fones extends Model
{
    use HasFactory; 
    
    protected $table = "tb_fones";

    //protected $fillable = []; // Permite insert

    // Proibidos no insert, update
    protected $guarded = []; // Se tiver nao entra.

}