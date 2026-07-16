<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class KanbanColumns extends Model
{

    protected $table = 'kanbanColumns';

    protected $fillable = [
        'icon',
        'text',
    ];



}