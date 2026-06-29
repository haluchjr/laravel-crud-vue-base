<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class LogController extends Controller
{

    public function teste(){
        dd('oieee.');
    }

    public function list(){
        $logs = storage_path('logs');
        $arqLogs = File::files($logs);
        $lista = [];
        //LOG::warning('OIII');
        foreach ($arqLogs as $arquivo){
            $lista[] = [
                'nome_cifrado' => Crypt::encryptString($arquivo->getFilename()),
                'nome'      => $arquivo->getFilename(),
                'tamanho'   => $arquivo->getSize() . ' bytes',
                'data'      => \Carbon\Carbon::createFromTimestamp($arquivo->getCTime())->format('d/m/Y H:i'),
             ];
        }

        return Inertia::render('Logs/Index', [ 'data' => $lista ]);

    }

    public function showLog($arquivo){
        $arquivo = Crypt::decryptString($arquivo);
        $conteudo = file_get_contents(storage_path('logs/'.$arquivo));
        return Inertia::render('Logs/Show',[
            'arquivo' => $arquivo,
            'conteudo' => $conteudo,
        ]);
    }

    public function destroy($arquivo){
        $arquivo = Crypt::decryptString($arquivo);
        File::delete(storage_path('logs/'. $arquivo));
        return back()->with('success', 'Arquivo excluido.');
    }
}
