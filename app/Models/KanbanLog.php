<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class KanbanLog extends Model
{

    protected $table = 'kanbanLog';

    protected $fillable = [
        'card_id',
        'column_index_old',
        'column_index_new',
    ];



}