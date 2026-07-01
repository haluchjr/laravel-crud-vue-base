<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    protected $table = 'tb_pedidos';
    protected $fillable = ['id','fk_usuario','valor'];
    public $timestamps = false;
}
