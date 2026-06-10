<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Acl extends Model
{
    protected $table = 'acl';
    protected $fillable = ['id','perfil','descricao'];

}