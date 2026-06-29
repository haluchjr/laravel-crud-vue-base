<script setup>
import { ref } from 'vue'
import { Head , usePage, Link } from '@inertiajs/vue3'
import { computed, onMounted } from 'vue';
import Layout from '@/Layouts/CrudLayout.vue';
defineProps({
    nome: String,
    conteudo : String,
});

// Importa o motor do Prism
import Prism from 'prismjs';

// Importa o tema escuro (parecido com o VS Code Okadia/Tomorrow Night)
//import 'prismjs/themes/prism-okaidia.css';
import 'prismjs/themes/prism-tomorrow.css';

// Importa o suporte a arquivos de LOG (para ele entender os erros do Laravel)
import 'prismjs/components/prism-log';
// Força o Prism a colorir o texto assim que o componente aparecer na tela
onMounted(() => {
    Prism.highlightAll();
});
</script>

<template>
<Layout>
<Head title="Show Log"/>
<div class="container-fluid " style="max-width: 1180px; margin: 0 auto;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h4 font-weight-bold text-secondary mb-0">{{ nome }}</h1>
            <Link :href="route('log.list')" class="btn btn-secondary">
                Voltar
            </Link>
        </div>

        <pre 
            class="language-log rounded shadow-sm m-0 p-4 overflow-auto" 
            style="max-height: 75vh;"
        ><code class="language-log font-monospace" style="font-size: 0.875rem;">{{ conteudo }}</code></pre>
    </div>
</Layout>
</template>

<style scoped>
/* Ajuste fino para o container do Prism ocupar a largura certa com Bootstrap */
pre[class*="language-"] {
    background: #1e1e1e !important; /* Cor exata do fundo do VS Code */
    margin: -1 !important;
}
</style>