<?php
namespace App\Services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use App\Models\Cadastro;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BaseService 
{
    public function main(){
         // Lendo o composer.json para pegar dependências do PHP/Laravel
        $composerPath = base_path('composer.json');
        $composerData = file_exists($composerPath) ? json_decode(file_get_contents($composerPath), true) : [];
        
        // Lendo o package.json para pegar dependências do Vue/Inertia Frontend
        $packagePath = base_path('package.json');
        $packageData = file_exists($packagePath) ? json_decode(file_get_contents($packagePath), true) : [];

        return Inertia::render('Welcome', [
            'info' => [
                'environment' => [
                    'php_version' => PHP_VERSION,
                    'laravel_version' => App::version(),
                    'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'N/A',
                    'os' => PHP_OS,
                ],
                'backend_deps' => [
                    'inertia_laravel' => $composerData['require']['inertiajs/inertia-laravel'] ?? 'Não instalado',
                    'laravel_framework' => $composerData['require']['laravel/framework'] ?? 'N/A',
                ],
                'frontend_deps' => [
                    'vue' => $packageData['dependencies']['vue'] ?? ($packageData['devDependencies']['vue'] ?? 'Não instalado'),
                    'inertia_vue' => $packageData['dependencies']['@inertiajs/vue3'] ?? ($packageData['devDependencies']['@inertiajs/vue3'] ?? 'Não instalado'),
                    'vite' => $packageData['devDependencies']['vite'] ?? 'Não instalado',
                ]
            ]
        ]);
    }

}
