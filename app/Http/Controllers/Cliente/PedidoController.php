<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Repositories\Cliente\PedidoRepository;
use App\Repositories\PedidoRepository as PedidoRepositoryBase;

class PedidoController extends Controller
{
    public function __construct(
        protected PedidoRepository $PedidoRepository, 
        protected PedidoRepositoryBase $PedidoRepositoryBase) {    }

    public function novoPedido(){ 
        $dados = [
            'fk_usuario' => 2,
            'valor'      => 1
        ];

        $a = $this->PedidoRepository->tudo();
        //-dd($a);

        return Inertia::render('Cliente/Index',['dados'=>$a]);
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
