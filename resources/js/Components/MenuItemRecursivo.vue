<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
// 💡 Importação explícita para o Vue 3 não perder a referência na recursão
import MenuItemRecursivo from './MenuItemRecursivo.vue';

const { item } = defineProps({
    item: { 
        type: Object, 
        required: true 
    }
});

const page = usePage();
const rotaAtual = computed(() => page.url);

// Controla se este nível específico está expandido ou não
const aberto = ref(false);

// Verifica se este item possui submenus
const temFilhos = computed(() => item.filhos_recursivos && item.filhos_recursivos.length > 0);

// Marca como ativo se a URL bater exatamente com a rota atual
const estaAtivo = computed(() => rotaAtual.value === item.url);

// 🌟 LOGICA DE CORES PARA O ADMIN
// Verifica se quem está logado é o Admin (Nível 99)
const ehAdmin = computed(() => page.props.auth.user?.nivel === 99);

// Verifica se este item específico do menu é visível por usuários comuns (Nível 1)
// Substitua a antiga por esta versão blindada:
const ehOpcaoUsuarioComum = computed(() => {
    let permissoes = item.nivel_permissao;

    // Se o backend mandou como String JSON (ex: "[1]"), transformamos em Array no Vue
    if (typeof permissoes === 'string') {
        try {
            permissoes = JSON.parse(permissoes);
        } catch (e) {
            permissoes = [];
        }
    }

    // Garante que é um array antes de checar
    if (Array.isArray(permissoes)) {
        // Usamos .some com == para aceitar tanto o número 1 quanto a string "1"
        return permissoes.some(p => p == 1);
    }

    return false;
});

// Define se a opção deve receber o destaque de "comum" na tela do Admin
const deveDestacarParaAdmin = computed(() => ehAdmin.value && ehOpcaoUsuarioComum.value);
</script>

<template>
  <li class="w-100 list-unstyled">
    
    <Link 
      v-if="!temFilhos"
      :title="deveDestacarParaAdmin ? 'Visível para CLIENTES' : null"
      :href="item.url && item.url.includes('.') ? route(item.url) : item.url || '#'" 
      class="nav-link d-flex align-items-center gap-2 py-2 px-3 rounded"
      :class="{ 
        'active text-white bg-primary fw-bold': estaAtivo, 
        'text-secondary': !estaAtivo && !deveDestacarParaAdmin,
        'opcao-comum-admin': deveDestacarParaAdmin && !estaAtivo /* Aplica cor fosca se for rota de user comum */
      }"
    >
      <i class="bi" :class="item.icon || 'bi-dot'"></i>
      <span>{{ item.nome }}</span>
    </Link>

    <div v-else class="w-100">
      <div 
        @click="aberto = !aberto"
        :title="deveDestacarParaAdmin ? 'Visivel para CLIENTES' : null"
        class="nav-link d-flex align-items-center justify-content-between py-2 px-3 rounded gatilho"
        :class="{ 
          'text-dark fw-bold bg-light': aberto, 
          'text-secondary': !aberto && !deveDestacarParaAdmin,
          'opcao-comum-admin': deveDestacarParaAdmin && !aberto /* Aplica cor fosca no nó pai também */
        }"
      >
        <div class="d-flex align-items-center gap-2">
          <i class="bi" :class="item.icon || 'bi-folder'"></i>
          <span>{{ item.nome }}</span>
        </div>
        <i class="bi bi-chevron-down small text-muted seta" :class="{ 'rotacionar': aberto }"></i>
      </div>

      <div v-if="aberto" class="w-100">
        <ul class="nav flex-column ms-3 ps-2 border-start d-flex flex-column gap-1 my-1 container-filhos">
          <MenuItemRecursivo 
            v-for="filho in item.filhos_recursivos" 
            :key="filho.id" 
            :item="filho" 
          />
        </ul>
      </div>
    </div>

  </li>
</template>

<style scoped>
.nav-link {
  cursor: pointer;
  transition: all 0.15s ease-in-out;
  font-size: 0.92rem;
  user-select: none;
}

.nav-link:hover:not(.active) {
  background-color: #f8f9fa;
  color: #0d6efd !important;
}

.gatilho {
  cursor: pointer;
}

.seta {
  transition: transform 0.2s ease;
}

.seta.rotacionar {
  transform: rotate(180deg);
}

.container-filhos {
  border-color: #e9ecef !important; /* Linha guia na esquerda para organizar os níveis */
}

/* 🌟 CLASSE DE DESTAQUE DO ADMIN */
.opcao-comum-admin {
  color: #adb5bd !important; /* Deixa o texto cinza fosco */
  font-style: italic;        /* Deixa em itálico para diferenciar das rotas exclusivas de Admin */
}

.opcao-comum-admin:hover {
  color: #0d6efd !important; /* Restaura a cor azul padrão do sistema ao passar o mouse */
  font-style: italic;
}
</style>