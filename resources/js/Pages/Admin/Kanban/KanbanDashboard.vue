<script setup>
import { ref, computed } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import draggable from 'vuedraggable';
import tela from '@/Layouts/CrudLayout.vue'

import ModalBs from '@/Components/ModalBs.vue';
import { useEventBus } from '@/Utils/eventBus';

const { emit } = useEventBus();

const props = defineProps({
  cards: {
    type: Array,
    required: true
  },
  colunas: {
    type: Array,
    required: true
  }
});

const priorities = {
  high: {
    label: 'Alta',
    border: 'border-danger bg-danger-subtle bg-opacity-10'
  },
  medium: {
    label: 'Média',
    border: 'border-warning bg-warning-subtle bg-opacity-10'
  },
  low: {
    label: 'Baixa',
    border: 'border-success bg-success-subtle bg-opacity-10'
  }
};

const exibirModal = ref(false);

// Form com padrões limpos
const formulario = useForm({
  id: null,
  title: '',
  description: '',
  priority: 'medium',
  tagsInput: '',
  tags: []
});

/**
 * Filtra os cards pertencentes a uma coluna específica.
 * NOTA: Se o seu banco de dados salvar o ID da coluna (ex: coluna_id) no card 
 * em vez de um índice posicional, altere para: card.coluna_id === colunaId
 */
// const getColumnCards = (colIndex) => {
//   return props.cards.filter(card => card.column_index === colIndex);
// };
const getColumnCards = (colunaId) => {
  return props.cards.filter(card => card.column_index === colunaId);
};

// Salvar / Atualizar
const enviar = () => {
  formulario.tags = formulario.tagsInput
    ? formulario.tagsInput.split(',').map(t => t.trim()).filter(t => t)
    : [];

  if (formulario.id) {
    formulario.put(route('kanban.update', { id: formulario.id }), {
      onSuccess: () => closeCardModal(),
    });
  } else {
    formulario.post(route('kanban.store'), {
      onSuccess: () => closeCardModal(),
    });
  }
};

// Movimentação de Cards
const handleDragChange = (evt, newColumnId) => {
  if (evt.added) {
    const card = evt.added.element;
    const newPosition = evt.added.newIndex;
    
    router.post(route('kanban.move'), {
      card_id: card.id,
      column_index: newColumnId, // Se o backend esperar o ID da coluna, passe 'coluna.id' aqui
      position: newPosition
    }, {
      preserveScroll: true
    });
  }
};

const deleteCard = (id) => {
  if (!confirm('Deseja realmente excluir este card?')) return;

  router.delete(route('kanban.destroy', { id: id }), {
    preserveScroll: true
  });
};

// Gerenciamento de Modal (Evitando lixo de memória)
const openAddCardModal = () => {
  formulario.clearErrors();
  
  formulario.id = null;
  formulario.title = '';
  formulario.description = '';
  formulario.priority = 'medium';
  formulario.tagsInput = '';
  formulario.tags = [];
  
  formulario.defaults(); 
  exibirModal.value = true;
};

const editCard = (card) => {
  formulario.clearErrors();
  
  formulario.id = card.id;
  formulario.title = card.title;
  formulario.description = card.description || '';
  formulario.priority = card.priority;
  formulario.tagsInput = card.tags ? card.tags.join(', ') : '';
  formulario.tags = card.tags || [];
  
  formulario.defaults();
  exibirModal.value = true;
};

const closeCardModal = () => {
  exibirModal.value = false;
};
</script>

<template>
<tela>
  <Head title="Kanban"/>
   <template #header>
            <h1 class="h3 mb-0">Quadro de Tarefas</h1>
        </template>
  <div class="">
    
      <div class="d-flex justify-content-between align-items-center mb-3">
        
        <button 
          @click="openAddCardModal" 
          class="btn btn-outline-primary d-flex align-items-end gap-2 shadow-sm"
        >
          Novo Card
          <span class="bi bi-plus"></span>
        </button>


      </div>
      

    <div class=" ">
      <div class="row g-3 row-cols-1 row-cols-md-3 row-cols-xl-6">
        <div 
          v-for="(coluna, index) in colunas" 
          :key="coluna.id || index" 
          class="col"
        >
          <div class="bg-white rounded-3 p-3 shadow-sm border h-100 d-flex flex-column" style="min-height: 550px;">
            
            <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
              <h2 class="h6 fw-bold text-secondary text-truncate m-0" :title="coluna.text">
                <i v-if="coluna.icon" :class="['bi', coluna.icon]"></i> {{ coluna.text }}
              </h2>
              <span class="badge bg-secondary rounded-pill">
                {{ getColumnCards(coluna.id).length }}
              </span>
            </div>

            <draggable
              :list="getColumnCards(coluna.id)"
              group="kanban"
              item-key="id"
              class="flex-grow-1 d-flex flex-column gap-3"
              style="min-height: 450px;"
              ghost-class="ghost-card"
              drag-class="drag-card"
              @change="(evt) => handleDragChange(evt, coluna.id)"
            >
              <template #item="{ element }">
                <div :class="[priorities[element.priority].border, 'card rounded-3 shadow-sm hover-shadow']">
                  <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                      <h3 class="card-title h6 fw-bold text-dark m-0 leading-tight" :title="`Criado: ${element.incluso} | Atualizado: ${element.atualizado}`">
                        {{ element.title }}
                      </h3>
                      <button 
                        @click.stop="deleteCard(element.id)" 
                        class="btn btn-link btn-sm text-muted p-0 border-0 hover-danger"
                        title="Excluir card"
                      >
                        🗑️
                      </button>
                    </div>
                    
                    <p v-if="element.description" class="card-text text-muted small mb-3 text-truncate-3">
                      {{ element.description }}
                    </p>

                    <div v-if="element.tags?.length" class="d-flex flex-wrap gap-1 mb-3">
                      <span 
                        v-for="tag in element.tags" 
                        :key="tag" 
                        class="badge bg-light text-primary border border-primary-subtle font-weight-normal"
                      >
                        {{ tag }}
                      </span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-2 border-top text-muted small">
                      <span class="fw-semibold">{{ priorities[element.priority].label }}</span>
                      <button 
                        @click="editCard(element)" 
                        class="btn btn-link btn-sm p-0 text-decoration-none fw-bold"
                      >
                        Editar
                      </button>
                    </div>
                    
                  </div>
                </div>
              </template>
            </draggable>
          </div>
        </div>
      </div>
    </div>

    <ModalBs 
      :show="exibirModal" 
      :title="formulario.id ? '📝 Editar Card' : '➕ Novo Card'"
      @close="closeCardModal"
    >
      <form @submit.prevent="enviar" id="kanban-form">
        <div class="mb-3">
          <label class="form-label fw-semibold small">Título *</label>
          <input 
            v-model="formulario.title" 
            type="text" 
            required 
            placeholder="Digite o título da tarefa"
            class="form-control"
          >
        </div>
        
        <div class="mb-3">
          <label class="form-label fw-semibold small">Descrição</label>
          <textarea 
            v-model="formulario.description" 
            rows="3" 
            placeholder="Descreva os detalhes da tarefa..."
            class="form-control"
          ></textarea>
        </div>
        
        <div class="mb-3">
          <label class="form-label fw-semibold small">Prioridade</label>
          <select v-model="formulario.priority" class="form-select">
            <option value="low">Baixa</option>
            <option value="medium">Média</option>
            <option value="high">Alta</option>
          </select>
        </div>
        
        <div class="mb-3">
          <label class="form-label fw-semibold small">Tags (separadas por vírgula)</label>
          <input 
            v-model="formulario.tagsInput" 
            type="text" 
            placeholder="Backend, PHP, Bug" 
            class="form-control"
          >
        </div>
      </form>

      <template #actions>
        <button 
          type="button" 
          @click="closeCardModal" 
          class="btn btn-light me-2"
        >
          Cancelar
        </button>
        <button 
          type="submit" 
          form="kanban-form"
          :disabled="formulario.processing"
          class="btn btn-primary fw-bold"
        >
          {{ formulario.processing ? 'Salvando...' : 'Salvar' }}
        </button>
      </template>
    </ModalBs>

  </div>
</tela>
</template>

<style scoped>
.cursor-move {
  cursor: move;
}
.ghost-card {
  opacity: 0.3;
  background-color: #f8f9fa !important;
  border: 2px dashed #6c757d !important;
}
.drag-card {
  transform: rotate(2deg);
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
.text-truncate-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;  
  overflow: hidden;
}
.hover-shadow {
  transition: box-shadow 0.2s ease-in-out;
}
.hover-shadow:hover {
  box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.1) !important;
}
.hover-danger:hover {
  color: #dc3545 !important;
}
</style>