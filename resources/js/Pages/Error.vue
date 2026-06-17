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

  <div class="flex min-h-screen flex-col items-center justify-center bg-gray-100 p-6 text-center dark:bg-gray-900">
    <div class="max-w-md">
      <h1 class="text-6xl font-extrabold text-red-500 drop-shadow">
        {{ props.status }}
      </h1>
      
      <h2 class="mt-4 text-2xl font-bold text-gray-800 dark:text-gray-100">
        {{ errorContent.title }}
      </h2>
      
      <p class="mt-2 text-gray-600 dark:text-gray-400">
        {{ errorContent.description }}
      </p>
      
      <div class="mt-6">
        <Link 
          href="/" 
          class="rounded bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700 transition"
        >
          Voltar para a Home
        </Link>
      </div>
    </div>
  </div>
</template>