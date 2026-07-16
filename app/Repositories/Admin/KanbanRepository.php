<?php
namespace App\Repositories\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Kanban;
use App\Models\KanbanLog;

class KanbanRepository
{

    public function findById($id){
        return Kanban::findOrFail($id);
    }

    public function findAll(){
        return Kanban::orderBy('column_index')->orderBy('position')->get();
    }

    public function create($validated){
        $columnIndex = $validated['column_index'] ?? 1;

        $nextPosition = Kanban::where('column_index', $columnIndex)->max('position');
        $position = is_null($nextPosition) ? 0 : $nextPosition + 1;

        return Kanban::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'priority' => $validated['priority'] ?? 'medium',
            'column_index' => $columnIndex,
            'position' => $position,
            'tags' => $validated['tags'] ?? []
        ]);

    }

    public function destroy($id){
        $card = Kanban::findOrFail($id);
        return $card->delete(); // Faz o soft delete
    }

    public function update( $id, $validated){
        $card = Kanban::findOrFail($id);
        return $card->update($validated);
    }

    public function moveCard($validated){

        $cardId = $validated['card_id'];
        $newColumnIndex = $validated['column_index'];
        $newPosition = $validated['position'];
        
        DB::transaction(function () use ($cardId, $newColumnIndex, $newPosition) {
            $atualPosition = Kanban::findOrFail( $cardId);

            log::error([ 
                'cartao' => $cardId,
                'onde_estava' => $atualPosition->column_index,
                'onde_foi' =>$newColumnIndex]
                );

            KanbanLog::create([
                'card_id'           => $cardId,
                'column_index_old'  => $atualPosition->column_index,
                'column_index_new'  => $newColumnIndex
            ]);

            Kanban::where('id', $cardId)->update([
                'column_index' => $newColumnIndex,
                'position' => $newPosition
            ]);

            Kanban::where('column_index', $newColumnIndex)
                ->where('position', '>=', $newPosition)
                ->where('id', '!=', $cardId)
                ->increment('position');

            


        });

    }

}