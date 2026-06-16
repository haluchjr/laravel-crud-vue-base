<script setup>
// Padrao do JS
import { ref, computed } from 'vue';
import { router, useForm,usePage} from '@inertiajs/vue3'; 

// Meus Imports
import CrudLayoutNoMenu from '@/Layouts/CrudLayoutNoMenu.vue';

</script>

<template>
     <CrudLayoutNoMenu title="----">
        <template #header>
            <h1 class="h3 mb-0">--- </h1>
        </template>
        
        <div>
            PRINCIPAL
        </div>
        
        
        
        
        <template #sistema>Ambiente de Desenvolvimento</template>
    </CrudLayoutNoMenu>
</template>

<style scoped>
</style>