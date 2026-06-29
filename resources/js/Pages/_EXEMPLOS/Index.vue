3<script setup>
import { ref, computed } from 'vue';
import { router, useForm,usePage} from '@inertiajs/vue3'; 
import tela from '@/Layouts/CrudLayoutNoMenu.vue';
import Debug from '@/Components/Debug.vue';
import Paginacao from '@/Components/Paginacao.vue'

defineProps({
    dados: Object,
});


</script>

<template>
    <tela>

    <ul v-if="dados?.data">
        <li v-for="dado in dados.data" :key="dado.id">
            {{ dado.fk_usuario }} - R$ {{ dado.valor }}
        </li>
    </ul>
    <p v-else>Nenhum dado encontrado...</p>
    <Paginacao :links="dados.links" />
    </tela>
</template>