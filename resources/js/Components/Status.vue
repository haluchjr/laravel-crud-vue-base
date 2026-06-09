<script setup>
import { computed } from 'vue';

const props = defineProps({
    type: {
        type: String,
        required: true
    }
});

// Centralizamos todas as configurações dos status aqui
const statusConfig = {
    ativo: {
        texto: 'Ativo',
        classes: 'bg-success-subtle text-success border border-success'
    },
    inativo: {
        texto: 'Inativo',
        classes: 'bg-secondary-subtle text-secondary border border-secondary'
    },
    pendente: {
        texto: 'Pendente',
        classes: 'bg-warning-subtle text-warning border border-warning'
    },
    vencido:{
        texto: 'Vencido',
        classes: 'bg-danger-subtle text-danger border border-danger'
    },
    // Exemplo de fallback caso venha algo estranho do banco
    default: {
        texto: 'Desconhecido',
        classes: 'bg-light text-dark border'
    }
};

// Computada que busca as classes com base no tipo (substitui o switch)
const classesStatus = computed(() => {
    return (statusConfig[props.type] || statusConfig.default).classes;
});

// Computada que busca o texto com base no tipo
const textoStatus = computed(() => {
    return (statusConfig[props.type] || statusConfig.default).texto;
});
</script>

<template>
   <span 
        class="badge rounded-pill px-2 py-2 d-inline-block text-center shadow-sm" 
        :class="classesStatus"
        style="width: 85px; font-size: 12px;"
    >
        {{ textoStatus }}
    </span>
</template>