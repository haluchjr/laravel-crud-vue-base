<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    status: Number,
});

const title = computed(() => {
    return {
        503: '503: Serviço Indisponível',
        500: '500: Erro Interno do Servidor',
        404: '404: Página Não Encontrada',
        403: '403: Acesso Proibido',
    }[props.status];
});

const description = computed(() => {
    return {
        503: 'Desculpe, estamos fazendo uma manutenção rápida. Voltamos já!',
        500: 'Oops, algo deu errado em nossos servidores.',
        404: 'A página que você está procurando não pôde ser encontrada.',
        403: 'Você não tem permissão para acessar esta página.',
    }[props.status];
});
</script>

<template>
    <div class="flex min-h-screen flex-col bg-white dark:bg-gray-900 pt-16 pb-12">
        <main class="mx-auto flex w-full max-w-7xl flex-grow flex-col justify-center px-6 lg:px-8">
            <div class="py-16 text-center">
                <h1 class="text-4xl font-bold tracking-tight text-indigo-600 dark:text-indigo-400 sm:text-5xl">
                    {{ title }}
                </h1>
                <p class="mt-4 text-base text-gray-500 dark:text-gray-400">
                    {{ description }}
                </p>
                <div class="mt-6">
                    <Link :href="route('profile.edit')" class="text-base font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
                        Voltar para o sistema <span aria-hidden="true"> &rarr;</span>
                    </Link>
                </div>
            </div>
        </main>
    </div>
</template>