<script setup>
import { ref, computed } from 'vue';
import { router, useForm,usePage} from '@inertiajs/vue3'; 
import Layout from '@/Layouts/CrudLayout.vue';
import ModalBootstrap from '@/Components/ModalBs.vue';

const { dados } = defineProps({
    dados: {
        type: Object,
        required: true
    }
});
</script>

<template>
<Layout>
    <template #header>
        <h1 class="h3 mb-0">Relatório de pedidos</h1>
    </template>
    <div class="container-fluid">
        
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Data do pedido</th>
                    <th>Entrega</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="linha in dados" :key="linha.nr_pedido">
                    <td>{{ linha.nr_pedido }}</td>
                    <td>{{ linha.descricao }}</td>
                    <td>1</td>
                    <td>{{ linha.data_inclusao }}</td>
                    <td>{{ linha.data_entrega }}</td>
                </tr>
            </tbody>
            </table>



    </div>

    <template #sistema>
        <span>Sistema de pedidos</span>
    </template>

</Layout>
</template>

<style scoped>
</style>