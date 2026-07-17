<script setup>
import { ref } from 'vue'
import { Head , usePage, Link } from '@inertiajs/vue3'
import { computed } from 'vue';
import Layout from '@/Layouts/CrudLayout.vue';
import debug from '@/Components/Debug.vue';
import { useEventBus } from '@/Utils/eventBus'; // <-- IMPORTA O BUS em cada pagina que precisar.

defineProps({
    data: Array,
    
});
const page = usePage();
const appName = computed(() => page.props.appName);
const exibirModal = ref(false);

const { emit } = useEventBus();

</script>

<template>
<Layout>
<Head title="Logs"/>
<h2>Logs do sistema</h2>
<span v-if="data.length > 0">
    <table class="table table-striped h6"><thead>
    <tr>
        <th>Arquivo</th>
        <th>Tamanho</th>
        <th>Data</th>
        <th>Ações</th>
    </tr></thead>
    <tbody>
    <tr v-for="linha in data" >
        <td> <Link
                class="btn btn-sm btn-link me-1" style="text-decoration: none"
                :href="route('log.show', linha.nome_cifrado)"
                title="Ver"
            >
                {{ linha.nome }}
            </Link></td>
        <td>{{ linha.tamanho }} </td>
        <td>{{ linha.data }}</td>
        <td>
        

            <Link
                class="btn btn-sm btn-outline-danger " 
                :href="route('log.destroy', linha.nome_cifrado)"
                title="Ver"
            >
                Exluir
            </Link>
            
        </td>
    </tr>
    </tbody>
    </table>
</span>
<span v-else>
    Sem logs, ou desativado.
</span>
</Layout>
</template>

<style scoped>
</style>