<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusPedido extends Model
{
    use HasFactory; 
    
    protected $table = "tb_status_pedido";

    protected $fillable = []; // Permite insert

    // Proibidos no insert, update
    protected $guarded = []; // Se tiver nao entra.

}