<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller; 

use Illuminate\Http\Request;
use Inertia\Inertia;

class PedidoController extends Controller
{
    
    public function novoPedido(){ 
        dd('novo pedido');
        return Inertia::render('Pedido/Index');
    }

    public function relatorioPedidos(){ 
        dd('relatorio pedidos');
        return Inertia::render('Pedido/Relatorio');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
