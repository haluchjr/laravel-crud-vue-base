<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fone extends Model
{
    
    protected $table = "tb_fones";

    //protected $fillable = []; // Permite insert

    // Proibidos no insert, update
    protected $guarded = []; // Se tiver nao entra.
    public $timestamps = false;

}