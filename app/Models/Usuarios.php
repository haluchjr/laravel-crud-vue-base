<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\ValidationException;

class Usuarios extends Authenticatable
{
    use HasFactory, Notifiable;


    protected $table = "tb_usuarios";
    //protected $guarded = []; // Se tiver nao entra.
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'nivel'
    ];
    
    protected $casts = [
        'nivel' => 'integer',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function temAcesso(string $nivelRequerido): bool
    {
        // Se o usuário for admin, ele tem acesso a tudo
        if ($this->nivel === 'admin') {
            return true;
        }

        return $this->nivel === $nivelRequerido;
    }
}
