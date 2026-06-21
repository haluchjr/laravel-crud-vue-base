<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ViaCepService
{
    public function consultar(string $cep)
    {
        $cepLimpo = preg_replace('/[^0-9]/', '', $cep);
        
        // O serviço faz a requisição para o mundo externo
        $resposta = Http::get("https://viacep.com.br/ws/{$cepLimpo}/json/");

        if ($resposta->failed() || isset($resposta->json()['erro'])) {
            return null;
        }

        return $resposta->json();
    }


}