<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoItens extends Model
{
    /* 
        $fillable: É uma lista branca (Só aceita o que estiver aqui dentro).
        $guarded: É uma lista negra (Aceita tudo, exceto o que estiver aqui dentro).
    */
    protected $table = 'tb_pedido_itens';
    //protected $fillable = [1];
    protected $guarded = [];

    public $timestamps = false;
}
