<template>
  <ModalBs 
    :show="show" 
    :title="formulario.id ? '📝 Editar Card' : '➕ Novo Card'"
    @close="$emit('close')"
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
        @click="$emit('close')" 
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
</template>

<script setup>
import { watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ModalBs from '@/Components/ModalBs.vue';
import { useEventBus } from '@/Utils/eventBus';

const { emit } = useEventBus();

const props = defineProps({
  show: {
    type: Boolean,
    required: true
  },
  card: {
    type: Object,
    default: null // Se for null, significa criação de um novo card
  }
});

const emitEvents = defineEmits(['close']);

// useForm dedicado a este modal
const formulario = useForm({
  id: null,
  title: '',
  description: '',
  priority: 'medium',
  tagsInput: '',
  tags: []
});

// Fica monitorando a propriedade 'card' que o pai envia.
// Sempre que ela mudar, repopula ou limpa o formulário reativo.
watch(() => props.card, (novoCard) => {
  formulario.clearErrors();
  
  if (novoCard) {
    // Modo Edição
    formulario.id = novoCard.id;
    formulario.title = novoCard.title;
    formulario.description = novoCard.description || '';
    formulario.priority = novoCard.priority;
    formulario.tagsInput = novoCard.tags ? novoCard.tags.join(', ') : '';
  } else {
    // Modo Criação
    formulario.reset();
    formulario.id = null;
  }
}, { immediate: true });

const enviar = () => {
  // Converte a string de tags em array antes de enviar
  formulario.tags = formulario.tagsInput
    ? formulario.tagsInput.split(',').map(t => t.trim()).filter(t => t)
    : [];

  if (formulario.id) {
    formulario.put(route('kanban.update', { id: formulario.id }), {
      onSuccess: () => {
        emitEvents('close');
        emit('toast', { tipo: 'success', mensagem: 'Card atualizado com sucesso!' });
      },
      onError: () => {
        emit('toast', { tipo: 'danger', mensagem: 'Erro ao atualizar o card.' });
      }
    });
  } else {
    formulario.post(route('kanban.store'), {
      onSuccess: () => {
        emitEvents('close');
        emit('toast', { tipo: 'success', mensagem: 'Card criado com sucesso!' });
      },
      onError: () => {
        emit('toast', { tipo: 'danger', mensagem: 'Erro ao criar o card.' });
      }
    });
  }
};
</script>