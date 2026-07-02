<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoItemArquivo extends Model
{
    protected $table = 'tb_pedidos_itens_arquivos';
    ///protected $fillable = [];
    protected $guarded = [];
    public $timestamps = false;
}
