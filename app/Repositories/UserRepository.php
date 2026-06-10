<?php


namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    // Passamos o Model pelo construtor (Injeção de Dependência)
    public function __construct(protected User $user) {}

    public function getActiveUsers()
    {
        return $this->user->where('status', 'active')
                          ->orderBy('name')
                          ->get();
    }

    public function findById($id)
    {
        return $this->user->findOrFail($id);
    }
}