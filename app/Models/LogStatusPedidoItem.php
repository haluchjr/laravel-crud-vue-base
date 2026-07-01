<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogStatusPedidoItem extends Model
{
    use HasFactory; 
    
    protected $table = "tb_log_status_pedido_item";

    protected $fillable = []; // Permite insert

    // Proibidos no insert, update
    protected $guarded = []; // Se tiver nao entra.

}