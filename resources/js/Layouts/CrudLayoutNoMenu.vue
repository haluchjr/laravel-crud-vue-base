<script setup>
import { ref, computed } from 'vue';
import { usePage, Head } from '@inertiajs/vue3';
import FlashMessage from '@/Components/FlashMessage.vue';
import MenuLateral from '@/Components/MenuLateral.vue';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css'; 

const hoje = new Date();
const ano = ref(hoje.getFullYear());

const inertiaPage = usePage();
const flashProps = computed(() => inertiaPage.props.flash);

defineProps({
    title: {
        type: String,
        default: 'Sistema'
    },
});
</script>

<template>
    <Head :title="title" />

    <div class="d-flex min-vh-100 bg-light align-items-stretch">

        <div class="d-flex flex-column flex-grow-1 min-w-0 bg-light">
            
            <header v-if="$slots.header" class="bg-white py-3 border-bottom shadow-sm px-4">
                <div class="container-fluid p-0">
                    <slot name="header" />
                </div>
            </header>

            <FlashMessage :flash="flashProps" />

            <main class="p-4 flex-grow-1">
                <div class="container-fluid p-0">
                    <div class="table-responsive style-scroll">
                        <slot />
                    </div>
                </div>
            </main>

            <footer class="bg-white py-3 text-center border-top text-muted small px-4 mt-auto">
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
    /* 🪄 MUDANÇA: Tiramos o height 100% rígido daqui para evitar travas no scroll principal */
    min-height: 100%;
    background-color: #f8f9fa;
}

/* Scrollbar horizontal customizada para quando a tabela for muito larga */
.style-scroll::-webkit-scrollbar {
    height: 6px;
}
.style-scroll::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}
.style-scroll::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}
.style-scroll::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>