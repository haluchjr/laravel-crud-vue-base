<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    public function main(){
        if (Auth::user()->nivel == 1){
            return redirect()->route('usuario.index'); // Listagem de pedidos do cliente
        }else{
            return redirect()->route('pedido.index'); // Listagem de Pedidos
        }
    }

    public function loginteste(){
         return Inertia::render('loginteste',['dados'=>'login1111']);
    }
    public function usuario(){
         return Inertia::render('loginteste',['dados'=>'Pedidos do cliente']);
    }
    
    public function pedido(){
         return Inertia::render('loginteste',['dados'=>'Listar pedidos, dos clientes']);
    }

    public function mai1n()
    {
        log::error('AVISO',[ __FILE__ , __line__]);
         // Lendo o composer.json para pegar dependências do PHP/Laravel
        $composerPath = base_path('composer.json');
        $composerData = file_exists($composerPath) ? json_decode(file_get_contents($composerPath), true) : [];
        
        // Lendo o package.json para pegar dependências do Vue/Inertia Frontend
        $packagePath = base_path('package.json');
        $packageData = file_exists($packagePath) ? json_decode(file_get_contents($packagePath), true) : [];
        ob_start();
        phpinfo(INFO_GENERAL | INFO_MODULES); 
        $phpinfoText = ob_get_clean();
        $ambiente = App::environment();
        if ($ambiente == 'local' || true){
            return Inertia::render('Welcome', [
                'info' => [
                    'environment' => [
                        'build_project' => config('app.build_version'),
                        'php_version' => PHP_VERSION,
                        'ambiente' => $ambiente,
                        'laravel_version' => App::version(),
                        'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'N/A',
                        'os' => PHP_OS,
                        // Em vez do phpinfo(), trazemos extensões importantes:
                'loaded_extensions' => [
                    'pdo' => extension_loaded('pdo'),
                    'mbstring' => extension_loaded('mbstring'),
                    'openssl' => extension_loaded('openssl'),
                    'curl' => extension_loaded('curl'),
                    'redis' => extension_loaded('redis'),
                ],
                'memory_limit' => ini_get('memory_limit'),
                'post_max_size' => ini_get('post_max_size'),
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
        }else{
           echo "Ajuste a rota.";
           log::error('sdfsd');
        }
    }
}
