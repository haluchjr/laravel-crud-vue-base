<script setup>
import { computed } from 'vue'
import { Head, Link } from '@inertiajs/vue3'

const props = defineProps({
  status: {
    type: Number,
    required: true
  }
})

// Define os títulos e descrições com base no código do erro
const errorContent = computed(() => {
  return {
    503: {
      title: '503: Serviço Indisponível',
      description: 'Desculpe, estamos em manutenção. Voltamos logo!',
    },
    500: {
      title: '500: Erro Interno do Servidor',
      description: 'Ops, algo deu errado nos nossos servidores. Já estamos verificando.',
    },
    404: {
      title: '404: Página Não Encontrada',
      description: 'A página que você está procurando não existe ou foi movida.',
    },
    403: {
      title: '403: Acesso Proibido',
      description: 'Você não tem permissão para acessar esta página.',
    },
    401: {
      title: '401: Não Autorizado',
      description: 'Você precisa estar logado para acessar esta página.',
    },
  }[props.status] || {
    title: `${props.status}: Erro Inesperado`,
    description: 'Ocorreu um erro inesperado. Tente novamente mais tarde.',
  }
})
</script>

<template>
  <Head :title="errorContent.title" />

  <div class="d-flex min-vh-100 flex-column align-items-center justify-content-center bg-dark text-light p-4 text-center">
    <div style="max-width: 450px;">
      
      <h1 class="display-1 fw-bold text-danger">
        {{ props.status }}
      </h1>
      
      <h2 class="h4 my-3 fw-bold text-white">
        {{ errorContent.title }}
      </h2>
      
      <p class="text-muted mb-4">
        {{ errorContent.description }}
      </p>
      
      <div>
        <Link 
          href="/" 
          class="btn btn-success px-4 py-2"
        >
          Voltar para a Home
        </Link>
      </div>

    </div>
  </div>
</template>