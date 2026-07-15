<template>
<tela>
  <div class="bg-light min-vh-100 py-5">
    
    <div class="container mb-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h2 fw-bold text-dark m-0">🥋 Kanban Dashboard</h1>
        <button 
          @click="openAddCardModal" 
          class="btn btn-primary d-flex align-items-center gap-2 shadow-sm"
        >
          <span>➕</span> Novo Card
        </button>
      </div>
    </div>

    <div class="container-fluid px-4">
      <div class="row g-3 row-cols-1 row-cols-md-3 row-cols-xl-6">
        <div 
          v-for="(columnName, colIndex) in columns" 
          :key="colIndex" 
          class="col"
        >
          <div class="bg-white rounded-3 p-3 shadow-sm border h-100 d-flex flex-column" style="min-height: 550px;">
            
            <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
              <h2 class="h6 fw-bold text-secondary text-truncate m-0" :title="columnName">
                {{ columnName }}
              </h2>
              <span class="badge bg-secondary rounded-pill">
                {{ getColumnCards(colIndex).length }}
              </span>
            </div>

            <draggable
              :list="getColumnCards(colIndex)"
              group="kanban"
              item-key="id"
              class="flex-grow-1 d-flex flex-column gap-3"
              style="min-height: 450px;"
              ghost-class="ghost-card"
              drag-class="drag-card"
              @change="(evt) => handleDragChange(evt, colIndex)"
            >
              <template #item="{ element }">
                <div 
                  :class="[
                    'card border-0 border-start border-4 shadow-sm hover-shadow cursor-move',
                    priorityBorders[element.priority]
                  ]"
                >
               
                  <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                      <h3 class="card-title h6 fw-bold text-dark m-0 leading-tight">
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
                      <span class="fw-semibold">{{ priorityLabels[element.priority] }}</span>
                      <button 
                        @click="editCard(element)" 
                        class="btn btn-link btn-sm p-0 text-decoration-none fw-bold"
                      >
                        Editar
                      </button>
                    </div>
                    <p style="font-size: 60%;">
                      Criado em: {{ element.incluso }}<br>
                      Atualizado em: {{ element.atualizado }}
                    </p>

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

<script setup>
import { ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import draggable from 'vuedraggable';
import tela from '@/Layouts/CrudLayoutNoMenu.vue'

import ModalBs from '@/Components/ModalBs.vue';
import { useEventBus } from '@/Utils/eventBus';

const { emit } = useEventBus();

const props = defineProps({
  cards: {
    type: Array,
    required: true
  }
});

const columns = [
  '📋 Backlog', 
  'To Do', 
  '🚧 In Progress', 
  '👀 Review', 
  '🧪 Testing', 
  '✅ Done'
];

const priorityBorders = {
  high: 'border-danger bg-danger-subtle bg-opacity-10',
  medium: 'border-warning bg-warning-subtle bg-opacity-10',
  low: 'border-success bg-success-subtle bg-opacity-10'
};

const priorityLabels = {
  high: 'Alta',
  medium: 'Média',
  low: 'Baixa'
};

const exibirModal = ref(false);

// Iniciamos o useForm com os padrões vazios
const formulario = useForm({
  id: null,
  title: '',
  description: '',
  priority: 'medium',
  tagsInput: '',
  tags: []
});

const getColumnCards = (colIndex) => {
  return props.cards.filter(card => card.column_index === colIndex);
};

// Salvar / Atualizar
const enviar = () => {
  formulario.tags = formulario.tagsInput
    ? formulario.tagsInput.split(',').map(t => t.trim()).filter(t => t)
    : [];

  if (formulario.id) {
    formulario.put(route('kanban.update', { id: formulario.id }), {
      onSuccess: () => {
        closeCardModal();
        // Dispara o toast após fechar o modal com sucesso
        //emit('toast', { tipo: 'success', mensagem: 'Card atualizado com sucesso!' });
      },
      onError: () => {
        //emit('toast', { tipo: 'danger', mensagem: 'Erro ao atualizar o card.' });
      }
    });
  } else {
    formulario.post(route('kanban.store'), {
      onSuccess: () => {
        closeCardModal();
        // Dispara o toast após fechar o modal com sucesso
        //emit('toast', { tipo: 'success', mensagem: 'Card criado com sucesso!' });
      },
      onError: () => {
        //emit('toast', { tipo: 'danger', mensagem: 'Erro ao criar o card.' });
      }
    });
  }
};

const handleDragChange = (evt, newColumnIndex) => {
  if (evt.added) {
    const card = evt.added.element;
    const newPosition = evt.added.newIndex;
    
    alert(newColumnIndex);
    router.post(route('kanban.move'), {
      card_id: card.id,
      column_index: newColumnIndex,
      position: newPosition
    }, {
      preserveScroll: true
    });
  }
};

const deleteCard = (id) => {
  if (!confirm('Deseja realmente excluir este card?')) return;

  router.delete(route('kanban.destroy', { id: id }), {
    // onSuccess: () => emit('toast', { tipo: 'success', mensagem: 'Card excluído com sucesso!' }),
    // onError: () => emit('toast', { tipo: 'danger', mensagem: 'Erro ao excluir o card.' }),
    preserveScroll: true
  });
};

// Gerenciamento de abertura/fechamento - CORRIGINDO LIXO DE MEMÓRIA
const openAddCardModal = () => {
  formulario.clearErrors();
  
  // Definindo manualmente os campos vazios para garantir que o formulário limpe 100%
  formulario.id = null;
  formulario.title = '';
  formulario.description = '';
  formulario.priority = 'medium';
  formulario.tagsInput = '';
  formulario.tags = [];
  
  // Atualiza os padrões internos do useForm para que futuras chamadas de reset usem este estado vazio
  formulario.defaults(); 
  
  exibirModal.value = true;
};

const editCard = (card) => {
  formulario.clearErrors();
  
  // Atualiza os dados do formulário com o card selecionado
  formulario.id = card.id;
  formulario.title = card.title;
  formulario.description = card.description || '';
  formulario.priority = card.priority;
  formulario.tagsInput = card.tags ? card.tags.join(', ') : '';
  formulario.tags = card.tags || [];
  
  // Seta os padrões para o card que está sendo editado neste momento
  formulario.defaults();

  exibirModal.value = true;
};

const closeCardModal = () => {
  exibirModal.value = false;
};
</script>
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