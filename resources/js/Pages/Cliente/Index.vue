<script setup>
import Layout from '@/Layouts/CrudLayout.vue';
import { ref, computed, watch } from 'vue'; // Trocamos onMounted por watch
import { useForm, router } from '@inertiajs/vue3';
import debug from '@/Components/Debug.vue'; 

// 1. Define as duas props vindas do Controller
const props = defineProps({
  produtos: Array,
  formulario: Array, // O lazy do Inertia vai alimentar esse array dinamicamente
  tamanhos:Array,
});

// Chave para forçar o reset visual dos inputs do tipo file
const resetKey = ref(0);

// 2. Inicializa o formulário do Inertia
const form = useForm({
  produtos: null,      // Armazena o ID do produto escolhido no dropdown
  product_id: null,    // ID que vai para o backend associar o pedido ao produto
  observacao: '',
  files: [] ,
  produto_tamanho_id: null
});

// 3. Monitora a prop 'formulario'. Toda vez que o Lazy trouxer dados novos, monta a estrutura
watch(() => props.formulario, (novoFormulario) => {
  if (novoFormulario && novoFormulario.length > 0) {
    // Alimenta o ID do produto automaticamente baseado na query organizada
    form.product_id = novoFormulario[0].produto_id;
    
    // Mapeia a casca dos inputs conforme o retorno limpo do SQL
    form.files = novoFormulario.map(componente => ({
      //produtos_componentes_id: componente.id_componente, 
      produto_componente_id: componente.componente_id,
      label_componente: componente.label || componente.label_componente,
      requerido: componente.requerido === 1,
      tipo_arquivo: componente.tipo_arquivo || null,              
      extensoes: componente.extensoes || null,
      file: null                                        
    }));
  } else {
    // Se não vier nada (ou limpar a seleção), esvazia os inputs dinâmicos
    form.files = [];
  }
}, { deep: true });

// Disparado no evento @change do Select
const produtoSelecionado = () => {
  if (!form.produtos) return;
  // Faz a chamada em background requisitando APENAS o lazy property 'formulario'
  router.reload({
    only: ['formulario','tamanhos'], // Apenas o lazy property 'formulario' será atualizado
    data: { produto_id: form.produtos }, // Envia o ID via query string para o request() do Laravel
  });
};

// Resgata o nome do produto dinamicamente para o título
const nomeProduto = computed(() => {
  return props.formulario && props.formulario.length > 0 
    ? props.formulario[0].produto_nome 
    : '';
});

// Captura o arquivo binário do upload
const handleFileChange = (index, event) => {
  form.files[index].file = event.target.files[0];
};

// Computada inteligente para o Grid do Bootstrap (calcula colunas sozinho)
const colunaClass = computed(() => {
  const totalItens = props.formulario?.length || 0;
  if (!totalItens) return 'col-12 mb-3';
  
  const tamanhoColuna = Math.floor(12 / totalItens);
  return tamanhoColuna < 3 ? 'col-md-3 mb-3' : `col-md-${tamanhoColuna} mb-3`;
});

// Envio dos dados para o backend
const submit = () => {
  form.post(route('usuario.salvar'), {
    onSuccess: () => {
      form.reset('nome', 'nome1', 'nome2');
      form.files.forEach(item => { item.file = null; });
      resetKey.value++;
    }
  });
};
</script>

<template>
  <Layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Novo Pedido
      </h2>
    </template>

    <form @submit.prevent="submit">
      <!-- <debug></debug> -->
      
      <div class="container mb-3">
        <label for="selecaoProduto" class="form-label">Escolha o Produto</label>
        <select 
          id="selecaoProduto" 
          v-model="form.produtos" 
          class="form-select form-select-sm" 
          @change="produtoSelecionado"
        >
          <option :value="null" disabled>Escolha uma opção...</option>
          <option v-for="produto in props.produtos" :key="produto.id" :value="produto.id">
            {{ produto.nome }}
          </option>
        </select>      
      </div>

      <hr>

      <div v-if="form.files.length > 0">
        <h6 class="ms-3">Produto Selecionado: {{ nomeProduto }}</h6>
        
        <div class="container mt-4">
          <div class="row"> 
            <div 
              v-for="(item, index) in form.files" 
              :key="`${item.produtos_componentes_id}-${resetKey}`" 
              :class="colunaClass"
            >
              <label class="form-label h6">{{ item.label_componente }}<span v-if="item.requerido">*</span></label>
              <input 
                :required="item.requerido"
                class="form-control form-control-sm" 
                :accept="item.extensoes"
                type="file" 
                @change="handleFileChange(index, $event)" 
              />
              <small class="">Formatos aceitos : {{ item.extensoes.replaceAll(".","")}}</small>
              <span v-if="form.errors[`files.${index}.file`]" class="text-danger d-block small mt-1">
                {{ form.errors[`files.${index}.file`] }}
              </span>
            </div>
          </div>
          <hr>
             <h6>Tamanhos</h6>
            <select 
              v-model="form.produto_tamanho_id" 
              class="form-select form-select-sm" 
            >
              <option :value="null" disabled>Escolha uma opção...</option>
              <option v-for="tamanho in props.tamanhos" :key="tamanho.id" :value="tamanho.id">
                {{ tamanho.tamanho_real }}
              </option>
            </select>
        </div>
        <hr>
        <div class="container mt-4">
        <div class="row"> 
          <div class="">
            <label for="input1" class="form-label">Observação</label>
            <input type="text" v-model="form.observacao" autocomplete="off" class="form-control form-control-sm" id="input1">
          </div>
        </div>
      </div>
      
        <div class="container">
         
          <button 
            class="btn btn-sm btn-outline-primary"  
            type="submit" 
            :disabled="form.processing" 
            style="margin-top: 20px;"
          >
            {{ form.processing ? 'Enviando...' : 'Enviar novo pedido' }}
          </button>
        </div>
      </div>

    </form> 
  </Layout>
</template>