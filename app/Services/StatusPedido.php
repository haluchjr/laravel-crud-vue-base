<?php

namespace App\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\DB;

class StatusPedido
{
    // Status permitidos por perfil
    private $statusFinanceiro = [];

    private $statusProducao = [];
}