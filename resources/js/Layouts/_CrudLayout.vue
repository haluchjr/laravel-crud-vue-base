<script setup>
import { ref, computed } from 'vue';
import { usePage, Head } from '@inertiajs/vue3';
import FlashMessage from '@/Components/FlashMessage.vue';
import MenuLateral from '@/Components/MenuLateral.vue';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css'; 

// 1. Recebendo a configuração do Controller (opcional, com valor padrão 'light')
const props = defineProps({
    title: {
        type: String,
        default: 'Sistema'
    },
    theme: {
        type: String,
        default: 'dark' // 🪄 Se o controller não mandar nada, o padrão será 'dark'
    }
});

const hoje = new Date();
const ano = ref(hoje.getFullYear());

const inertiaPage = usePage();
const flashProps = computed(() => inertiaPage.props.flash);

// 2. Criando a lógica do "IF" usando computed para definir o tema atual
// Ele vai olhar primeiro se veio algo global do Inertia, depois a prop, ou você pode fixar aqui.
const temaAtual = computed(() => {
    // Exemplo de trava manual se quiser testar direto no topo do arquivo:
    // return 'dark'; 

    return props.theme || inertiaPage.props.auth?.user?.theme || 'light';
});
</script>

<template>
    <Head :title="title" />

    <div 
        class="d-flex min-vh-100 align-items-stretch transition-theme" 
        :data-bs-theme="temaAtual"
        :class="temaAtual === 'dark' ? 'bg-dark-custom' : 'bg-light'"
    >
        
        <aside class="border-end bg-body-tertiary" style="z-index: 1030;">
            <MenuLateral />
        </aside>

        <div class="d-flex flex-column flex-grow-1 min-w-0">
            
            <header v-if="$slots.header" class="bg-body-tertiary py-3 border-bottom shadow-sm px-4">
                <div class="container-fluid p-0">
                    <slot name="header" />
                </div>
            </header>

            <FlashMessage :flash="flashProps" />

            <main class="p-4 flex-grow-1">
                <div class="container-fluid p-0">
                    <div class="table-responsive style-scroll" :class="temaAtual">
                        <slot />
                    </div>
                </div>
            </main>

            <footer class="bg-body-tertiary py-3 text-center border-top text-secondary small px-4 mt-auto">
                <div class="container-fluid p-0 d-flex justify-content-between align-items-center">
                    <span>&copy; {{ ano }} - Painel Administrativo</span>
                    <slot name="sistema" />
                </div>
            </footer>

        </div>
    </div>
</template>

<style>
body, html {
    margin: 0;
    padding: 0;
    min-height: 100%;
}

/* Classes customizadas para controle fino do fundo do body/container */
.bg-dark-custom {
    background-color: #121212 !important;
}

/* Suaviza a transição quando o tema mudar */
.transition-theme {
    transition: background-color 0.3s ease, color 0.3s ease;
}

/* Scrollbar condicional baseada na classe do tema */
.style-scroll.dark::-webkit-scrollbar-track {
    background: #1e1e1e;
}
.style-scroll.dark::-webkit-scrollbar-thumb {
    background: #444c56;
}
.style-scroll.dark::-webkit-scrollbar-thumb:hover {
    background: #576270;
}

.style-scroll.light::-webkit-scrollbar-track {
    background: #f1f1f1;
}
.style-scroll.light::-webkit-scrollbar-thumb {
    background: #cbd5e1;
}
.style-scroll.light::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>