<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\Kanban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class KanbanController extends Controller
{
    /**
     * Renderiza a página do Kanban com os cards via Inertia Props
     */
    public function index()
    {
        $cards = Kanban::orderBy('column_index')
            ->orderBy('position')
            ->get();

        // Altere 'KanbanDashboard' para o caminho exato dentro de Pages/
        return Inertia::render('Kanban/KanbanDashboard', [
            'cards' => $cards
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

        $columnIndex = $validated['column_index'] ?? 0;

        $nextPosition = Kanban::where('column_index', $columnIndex)->max('position');
        $position = is_null($nextPosition) ? 0 : $nextPosition + 1;

        Kanban::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'priority' => $validated['priority'] ?? 'medium',
            'column_index' => $columnIndex,
            'position' => $position,
            'tags' => $validated['tags'] ?? []
        ]);

        // O Inertia recarrega a página automaticamente com os novos dados
        return redirect()->back()->with('success', 'Tarefa criada!');
    }

    /**
     * Atualiza um card existente
     */
    public function update(Request $request, $id)
    {
        $card = Kanban::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|string|in:low,medium,high',
            'tags' => 'nullable|array'
        ]);

        $card->update($validated);

        return redirect()->back()->with('success', 'Tarefa atualizada!');
    }

    /**
     * Remove um card
     */
    public function destroy($id)
    {
        $card = Kanban::findOrFail($id);
        $card->delete(); // Faz o soft delete

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

        $cardId = $validated['card_id'];
        $newColumnIndex = $validated['column_index'];
        $newPosition = $validated['position'];

        DB::transaction(function () use ($cardId, $newColumnIndex, $newPosition) {
            Kanban::where('id', $cardId)->update([
                'column_index' => $newColumnIndex,
                'position' => $newPosition
            ]);

            Kanban::where('column_index', $newColumnIndex)
                ->where('position', '>=', $newPosition)
                ->where('id', '!=', $cardId)
                ->increment('position');
        });

        return redirect()->back();
    }
}