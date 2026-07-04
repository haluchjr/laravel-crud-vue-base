<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    mensagem: String,
    tipo: { type: String, default: 'success' } // success, danger, warning
});

const emit = defineEmits(['fechar']);
const visivel = ref(false);
let timer = null;

// Sempre que uma mensagem nova chegar, exibe o toast e inicia o cronômetro para sumir
watch(() => props.mensagem, (novaMensagem) => {
    if (novaMensagem) {
        visivel.value = true;
        
        // Some automaticamente após 4 segundos
        setTimeout(() => {
            fecharToast();
        }, 6000);
    }
}, { immediate: true });

const fecharToast = () => {
    visivel.value = false;
    emit('fechar');
};
</script>

<template>
    <div class="position-fixed top-0 end-0 p-3 " style="z-index: 1080">
        <div 
            v-if="visivel && mensagem" 
            class="toast show align-items-center text-white border-0 shadow "
            :class="`bg-${tipo === 'error' ? 'danger' : tipo}`"
            role="alert" 
            aria-live="assertive" 
            aria-atomic="true"
        >
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center gap-2" style="white-space: pre-line;">
                    <i v-if="tipo === 'success'" class="bi bi-check-circle-fill"></i>
                    <i v-if="tipo === 'error'" class="bi bi-exclamation-triangle-fill"></i>
                    <span>{{ mensagem }}</span>
                </div>
                <button 
                    type="button" 
                    class="btn-close btn-close-white me-2 m-auto" 
                    @click="fecharToast" 
                    aria-label="Close"
                ></button>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Transição suave para o toast não sumir do nada */
.toast {
    transition: opacity 0.3s ease;
}
</style>