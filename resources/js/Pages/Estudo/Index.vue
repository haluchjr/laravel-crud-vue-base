<script setup>
// Padrao do JS
import { ref, computed } from 'vue';
import { router, useForm,usePage} from '@inertiajs/vue3'; 

// Meus Imports
import CrudLayout from '@/Layouts/CrudLayoutNoMenu.vue';

</script>

<template>
     <CrudLayout title="----">
        <template #header>
            <h1 class="h3 mb-0">Listagem de Projetos</h1>
        </template>
        
        <div>
            PRINCIPAL
        </div>
        
        
        
        
        <template #sistema>Ambiente de Desenvolvimento</template>
    </CrudLayout>
</template>

<style scoped>
</style>