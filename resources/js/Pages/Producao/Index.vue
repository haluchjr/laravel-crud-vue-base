<script setup>
import { ref } from 'vue'
import { Head , usePage,Link} from '@inertiajs/vue3'
import Layout from '@/Layouts/CrudLayout.vue'


</script>

<template>
<Layout>
    <Head title="Pedidos do cliente"/>
     <template #header>
        <h1 class="h3 mb-0">Pedidos</h1>
    </template>


    Em breve lista de pedidos...

</Layout>
</template>

<style scoped>
</style>