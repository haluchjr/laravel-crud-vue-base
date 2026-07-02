3<script setup>
import { ref, computed } from 'vue';
import { router, useForm,usePage} from '@inertiajs/vue3'; 
import Layout from '@/Layouts/CrudLayout.vue';
import ModalBootstrap from '@/Components/ModalBs.vue';
import Debug from '@/Components/Debug.vue';
import Paginacao from '@/Components/Paginacao.vue'
import { obterClasseStatus } from '@/Utils/classesPorStatus';

const page = usePage();
const itensPedido = computed(() => page.props.itensPedido);

const { dados } = defineProps({
    dados: {
        type: Object,
        required: true
    }
});

const pedidoSelecionado = ref(null);
const modalAberto = ref(false);
const detalhesPedido = (item) => {
    pedidoSelecionado.value = item;
    modalAberto.value = true;

    router.reload({
        data: { pedido_id: item.nr_pedido },
        only: ['itensPedido'], 
    });

};



</script>
<template>
    <Layout>
        <template #header>
            <h1 class="h3 mb-0">Últimos pedidos</h1>
        </template>
        <div class="container mt-4">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Produto</th>
                        <th>Data inclusão</th>
                        <th>Entrega Prevista</th>
                        <th>Status</th>
                        <th>Valor</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="linha in dados" :key="linha.nr_pedido">
                        <td>{{ linha.nr_pedido }}</td>
                        <td>{{ linha.descricao }}</td>
                        <td>{{ linha.data_inclusao }}</td>
                        <td>{{ linha.data_entrega }}</td>
                        <td ><span :class="obterClasseStatus(linha.status_pedido_id)">{{ linha.descricao_site }}</span></td>
                        <td>{{ linha.valor_total_pedido }}</td>
                        <td><i title="Visualizar" class="bi-receipt" @click="detalhesPedido(linha)" ></i></td>
                    </tr>
                </tbody>
            </table>
        </div>



        <ModalBootstrap :show="modalAberto" :title="`Detalhes pedido #${pedidoSelecionado?.nr_pedido ?? ''}`" @close="modalAberto = false">

             <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Descrição</th>
                        <th>Data inclusão</th>
                        <th>Arte</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="linha in itensPedido" :key="linha.id">
                        <td>{{ linha.pdf_valido }}</td>
                        <td>{{ linha.boneco_gerado }}</td>
                        <td>{{ linha.total_paginas_pdf }}</td>
                        <td><a href="LocalExplorer:\\wsl$\Ubuntu\home\dev\Crud11Base\public\artes" >teste</a></td>
                    </tr>
                </tbody>
            </table>

            <template #actions>
                <button type="button" class="btn btn-light" @click="modalAberto = false">
                    Cancelar
                </button>
            </template>
        </ModalBootstrap>

    </Layout>
</template>