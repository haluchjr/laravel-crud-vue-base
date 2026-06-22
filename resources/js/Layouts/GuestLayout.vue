<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';

import ToastBs from '@/Components/ToastBs.vue';
import { useToastHandler } from '@/Composables/useToastHandler'; // <-- IMPORTA
const { msgToast, tipoToast, limparToast } = useToastHandler();

</script>

<template>
    <div class="d-flex flex-column align-items-center justify-content-center min-vh-100 bg-light py-4">
        <ToastBs 
            :mensagem="msgToast" 
            :tipo="tipoToast" 
            @fechar="limparToast" 
        />
        <div class="mb-4">
            <Link href="/">
                <ApplicationLogo style="width: 80px; height: 80px;" class="text-secondary" />
            </Link>
        </div>

        <div class="container" style="max-width: 450px;">
            <div class="card shadow-sm border-0 p-4">
                <slot />
            </div>
        </div>

    </div>
</template>

<style scoped>
/* Garante que o fundo ocupe toda a tela se o utilitário padrão não cobrir */
.min-vh-100 {
    min-height: 100vh;
}
</style>