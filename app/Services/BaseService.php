<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Cadastro;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BaseService 
{
    public function main(){
         return Inertia::render('Welcome');
    }

}
