<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    links: {
        type: Array,
        required: true
    }
});

// Função simples para traduzir os termos do Laravel
const traduzirTexto = (label) => {
    return label
        .replace('Previous', 'Anterior')
        .replace('Next', 'Próximo');
};
</script>

<template>
    <nav v-if="links.length > 3" aria-label="Navegação de página">
        <ul class="pagination justify-content-center my-4">
            <li v-for="(link, key) in links" 
                :key="key" 
                class="page-item" 
                :class="{ 'active': link.active, 'disabled': !link.url }">
                
                <Link 
                    :href="link.url || '#'" 
                    class="page-item page-link"
                    v-html="traduzirTexto(link.label)"
                />
            </li>
        </ul>
    </nav>
</template>

