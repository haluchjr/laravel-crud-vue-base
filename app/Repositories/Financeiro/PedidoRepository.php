<?php
namespace App\Repositories\Financeiro;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\Pedido;

class PedidoRepository
{
    // Passamos o Model pelo construtor (Injeção de Dependência)
    public function __construct(protected PedidoModel $pedido) {}
    
}