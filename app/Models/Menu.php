<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menu extends Model
{
    protected $table = "tb_menus";

    protected $fillable = ['nome', 'url', 'icon', 'ordem', 'nivel_permissao', 'menu_pai_id'];

    protected $casts = [
        'nivel_permissao' => 'array',
    ];

    /**
     * Relacionamento para pegar os filhos diretos (Submenu Nível 1)
     */
    public function filhos(): HasMany
    {
        return $this->hasMany(Menu::class, 'menu_pai_id')->orderBy('ordem');
    }

    public function filhosRecursivos(): HasMany
    {
        return $this->filhos()->with('filhosRecursivos');
    }

    /**
     * Relacionamento inverso (saber quem é o pai deste item)
     */
    public function pai(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'menu_pai_id');
    }
}