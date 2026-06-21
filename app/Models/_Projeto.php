<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class Projeto extends Model
{
    use HasFactory;

    // 1. Define o nome da tabela explicitamente (boa prática)
    protected $table = 'projetos';

    // 2. Campos que o Laravel vai permitir salvar em massa (Mass Assignment)
    protected $fillable = [
        'nome',
        'status',
        'arquivo'
    ];

    // Mantém o cast padrão do banco para o Carbon não se perder no Controller
    protected $casts = [
        'created_at' => 'datetime',
    ];

    // 1. Diz ao Laravel para incluir o campo customizado no JSON/Array enviado ao Vue
    protected $appends = ['data_br'];

    /**
     * 2. Cria o campo virtual 'data_br'
     * Acessível no Vue como: projeto.data_br
     */
    protected function dataBr(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at 
                ? Carbon::parse($this->created_at)->format('d/m/Y H:i') 
                : '-',
        );
    }
}