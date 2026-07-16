<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\ValidationException;

class NivelPermissao extends Authenticatable
{
    protected $table = "tb_nivel_permissoes";
    protected $guarded = [];
    public $timestamps = false;
}