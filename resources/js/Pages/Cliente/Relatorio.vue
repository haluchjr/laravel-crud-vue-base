<script setup>
import { ref, computed } from 'vue';
import { useForm, Link, router } from '@inertiajs/vue3';
import Layout from '@/Layouts/CrudLayout.vue';
import ModalBootstrap from '@/Components/ModalBs.vue';

const { dados } = defineProps({
    dados: {
        type: Object,
        required: true
    },
    
});

function exportarPara(formato){
  const url = route('usuario.exportarPara', { formato: formato });
    // Abre no navegador em uma nova aba/janela, o que força o download
    window.open(url, '_blank');
}
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
        
    <div class="btn-group" role="group" aria-label="Basic example">
        <span  @click="exportarPara('xlsx')" class="bi bi-filetype-xls btn btn-outline-dark"  title="Exportar para Excel"></span>
        <span  @click="exportarPara('pdf')"  class="bi bi-filetype-pdf btn btn-outline-dark"  title="Exportar para Pdf"></span>
        <span  @click="exportarPara('csv')"  class="bi bi-filetype-csv btn btn-outline-dark"  title="Exportar para CSV"></span>
    </div>



    
    <template #sistema>
        <span>Sistema de pedidos</span>
    </template>

</Layout>
</template>

<style scoped>
</style>