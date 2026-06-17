<?php

namespace App\Http\Controllers;

use App\Models\Cadastro;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Http\Requests\NovoUsuarioRequest;

use App\Repositories\CadastroRepository;

class CadastroController extends Controller
{
    public function __construct(protected CadastroRepository $cadastroRepository) {
        $this->cadastroRepository = $cadastroRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dados = $this->cadastroRepository->paginate(15);
        return Inertia::render('Cadastro/Index',['dados'=> $dados]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NovoUsuarioRequest $request)
    {
        $validados  = $request->validated();
        //return redirect()->route('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cadastro $cadastro)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cadastro $cadastro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cadastro $cadastro)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if ($this->cadastroRepository->deletar($id)){
            return redirect()->back()->with('sucesso', "Registro ID {$id} excluído com sucesso!");
        }
        return redirect()->back()->with('erro', "Registro ID {$id} excluído com sucesso!");
    }
}
