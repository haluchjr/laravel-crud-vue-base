<script setup>
import { ref } from 'vue'
import { Head , usePage,Link} from '@inertiajs/vue3'
import Layout from '@/Layouts/CrudLayout.vue'


</script>

<template>
<Layout>
    <Head title="Pedidos do cliente"/>
    <h3>Últimos 15 pedidos feitos</h3>
    <table class="table table-striped"><thead>
    <tr>
        <th>Data do pedido</th>
        <th>Pedido</th>
        <th>Valor</th>
        <th>Data de entrega</th>
        <th>Detalhes</th>
    </tr></thead>
    <tbody>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><i class="bi-pencil" ></i></td>
    </tr>
    </tbody>
    </table>
    Para pedidos anteriores solicitar ao departamento comercial.

</Layout>
</template>

<style scoped>
</style>