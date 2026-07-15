<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes; // Importante!

class Kanban extends Model
{
    use SoftDeletes; // Ativa o Soft Delete

    protected $dates = ['deleted_at'];

    // Força o Eloquent a usar a tabela singular 'kanban'
    protected $table = 'kanban';

    protected $fillable = [
        'title',
        'description',
        'priority',
        'column_index',
        'position',
        'tags'
    ];

    // Converte o campo 'tags' de JSON no banco para Array no PHP automaticamente
    protected $casts = [
        'tags' => 'array',
        'column_index' => 'integer',
        'position' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    // 1. Diz ao Laravel para incluir o campo customizado no JSON/Array enviado ao Vue
    protected $appends = ['incluso','atualizado'];

    /**
     * 2. Cria o campo virtual 'data_br'
     * Acessível no Vue como: projeto.data_br
     */
    protected function incluso(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at 
                ? Carbon::parse($this->created_at)->format('d/m/Y H:i') 
                : '-',
        );
    }

     protected function atualizado(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->updated_at 
                ? Carbon::parse($this->updated_at)->format('d/m/Y H:i') 
                : '-',
        );
    }
}