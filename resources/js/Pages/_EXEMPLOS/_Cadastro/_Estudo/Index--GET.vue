<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3';
// ----------------------------------------------
// Exemplo simples de GET usando Inertia.js
// ----------------------------------------------
// Quando quero receber, uso o defineProps para definir as propriedades que serão passadas do backend para o frontend. 
// No caso, estou recebendo um nome e uma lista de tecnologias.

defineProps({
    nome: String,
    tecnologias: Array
});


</script>

<template>
Olá, {{ nome }}! Bem-vindo ao estudo de Inertia.js com Laravel e Vue.js. Aqui estão algumas tecnologias que estamos usando:
<ul>
    <li v-for="(tecnologia, index) in tecnologias" :key="index">{{ tecnologia }}</li>
</ul>



</template>

<style scoped>
</style>