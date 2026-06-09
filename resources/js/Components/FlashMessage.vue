<script setup>
// 💡 IMPORTANTE: Adicionados os imports do ref, watch e onUnmounted que faltavam
import { ref, watch, onUnmounted } from 'vue';

// Recebe o objeto flash vindo do Laravel/Inertia
const props = defineProps({
    flash: {
        type: Object, // 💡 Boa prática definir o tipo explicitamente
        default: () => ({ sucesso: false, erro: false })
    }
});

// Criamos um estado interno para controlar a visibilidade na tela
const visivel = ref(false);
let timer = null;

// Função que inicia a contagem regressiva para fechar o alerta
const iniciarTimer = () => {
    // Limpa o timer anterior se o Laravel enviar duas mensagens seguidas
    if (timer) clearTimeout(timer);

    // Se houver qualquer mensagem, mostra o alerta
    if (props.flash?.sucesso || props.flash?.erro) {
        visivel.value = true;

        // 💡 3000ms = 3 segundos. Mude para 5000 se quiser 5 segundos.
        timer = setTimeout(() => {
            visivel.value = false;
        }, 3000); 
    }
};

// Fica de olho (watch) nas props. Se o Laravel mandar um flash novo, ativa o timer
watch(() => props.flash, () => {
    iniciarTimer();
}, { deep: true, immediate: true });

// Boa prática: limpa o timer se o usuário mudar de página antes do tempo acabar
onUnmounted(() => {
    if (timer) clearTimeout(timer);
});

// 💡 Removi o computed antigo daqui porque ele não estava mais sendo usado no template.
</script>

<template>
    <div v-if="visivel" class="flash-container my-3">
        
        <div v-if="flash?.sucesso" class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <span class="me-2">✅</span>
                <div>{{ flash.sucesso }}</div>
            </div>
            <button type="button" class="btn-close" @click="visivel = false" aria-label="Close"></button>
        </div>

        <div v-if="flash?.erro" class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <span class="me-2">❌</span>
                <div>{{ flash.erro }}</div>
            </div>
            <button type="button" class="btn-close" @click="visivel = false" aria-label="Close"></button>
        </div>

    </div>
</template>