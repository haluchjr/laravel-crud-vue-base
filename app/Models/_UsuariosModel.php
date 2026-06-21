<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuariosModel extends Model
{
    protected $table = 'usuarios_models';
    protected $fillable = [
        'nome',
        'email',
    ];
}
