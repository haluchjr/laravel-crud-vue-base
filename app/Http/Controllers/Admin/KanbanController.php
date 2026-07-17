<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\KanbanColumns;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Repositories\Admin\KanbanRepository;

class KanbanController extends Controller
{
    public function __construct(protected KanbanRepository $kanbanRepository){}

    /**
     * Renderiza a página do Kanban com os cards via Inertia Props
     */
    public function index()
    {
        return Inertia::render('Admin/Kanban/KanbanDashboard', [
            'cards' => $this->kanbanRepository->findAll(),
            'colunas' => KanbanColumns::orderBy('id')->get(),
        ]);
    }

    /**
     * Cria um novo card
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|string|in:low,medium,high',
            'column_index' => 'nullable|integer',
            'tags' => 'nullable|array'
        ]);

        $this->kanbanRepository->create($validated);

        // O Inertia recarrega a página automaticamente com os novos dados
        return redirect()->back()->with('success', 'Tarefa criada!');
    }

    /**
     * Atualiza um card existente
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|string|in:low,medium,high',
            'tags' => 'nullable|array'
        ]);

        $this->kanbanRepository->update( $id, $validated);

        return redirect()->back()->with('success', 'Tarefa atualizada!');
    }

    /**
     * Remove um card
     */
    public function destroy($id)
    {
        $this->kanbanRepository->destroy($id);

        return redirect()->back()->with('toast', [
            'tipo' => 'success',
            'mensagem' => 'Tarefa movida para a lixeira!'
        ]);
    }

    /**
     * Move o card (Drag and Drop)
     */
    public function move(Request $request)
    {
        $validated = $request->validate([
            'card_id' => 'required|integer|exists:kanban,id',
            'column_index' => 'required|integer',
            'position' => 'required|integer'
        ]);

        $this->kanbanRepository->moveCard($validated);
        return redirect()->back();
    }
}