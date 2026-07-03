<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/teste', function () {
    return response()->json([
        'status' => 'sucesso',
        'mensagem' => 'Conexão com o Laravel funcionou perfeitamente!',
        'horario' => now()->toDateTimeString()
    ]);
});


Route::post('log-javascript-error', function (Request $request) {
    // Valida os dados recebidos do front-end
    $validated = $request->validate([
        'message' => 'required|string',
        'url'     => 'nullable|string',
        'line'    => 'nullable|integer',
        'column'  => 'nullable|integer',
        'stack'   => 'nullable|string',
    ]);

    // Formata a mensagem que irá para o laravel.log
    Log::error('JS Error: ' . $validated['message'], [
        'url'         => $validated['url'],
        //'line'        => $validated['line'],
        //'column'      => $validated['column'],
        //'stack_trace' => $validated['stack'],
        //'user_agent'  => $request->userAgent(),
        //'ip'          => $request->ip(),
    ]);

    return response()->json(['status' => 'success'], 200);
});