<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusPedidoItem extends Model
{
    use HasFactory; 
    
    protected $table = "tb_status_pedido_item";

    protected $fillable = []; // Permite insert

    // Proibidos no insert, update
    protected $guarded = []; // Se tiver nao entra.

}