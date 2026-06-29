<script setup>
import { ref } from 'vue'
import { Head } from '@inertiajs/vue3'


const variavel = ref(true);

</script>

<template>
<Head title=""/>


<span v-if="variavel">Variável é verdadeira</span>
<span v-else>Variável é falsa</span>

</template>

<style scoped>
</style>