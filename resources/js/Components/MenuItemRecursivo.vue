<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
// 💡 IMPORTANTE: Importamos o próprio componente explicitamente para o Vue 3 não se perder na recursão
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

// Marca como ativo se a URL bater exatamente
const estaAtivo = computed(() => rotaAtual.value === item.url);
</script>

<template>
  <li class="w-100 list-unstyled">
    
    <Link 
      v-if="!temFilhos"
      :href="route(item.url)" 
      class="nav-link d-flex align-items-center gap-2 text-secondary py-2 px-3 rounded"
      :class="{ 'active text-white bg-primary fw-bold': estaAtivo }"
    >
      <i class="bi" :class="item.icon || 'bi-dot'"></i>
      <span>{{ item.nome }}</span>
    </Link>

    <div v-else class="w-100">
      <div 
        @click="aberto = !aberto"
        class="nav-link d-flex align-items-center justify-content-between text-secondary py-2 px-3 rounded gatilho"
        :class="{ 'text-dark fw-bold bg-light': aberto }"
      >
        <div class="d-flex align-items-center gap-2">
          <i class="bi" :class="item.icon || 'bi-folder'"></i>
          <span>{{ item.nome }}</span>
        </div>
        <i class="bi bi-chevron-down small text-muted seta" :class="{ 'rotacionar': aberto }"></i>
      </div>

      <ul v-if="aberto" class="nav flex-column ms-3 ps-2 border-start d-flex flex-column gap-1 my-1 container-filhos">
        <MenuItemRecursivo 
          v-for="filho in item.filhos_recursivos" 
          :key="filho.id" 
          :item="filho" 
        />
      </ul>
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
</style>