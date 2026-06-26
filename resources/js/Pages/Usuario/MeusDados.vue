<script setup>
import { ref } from 'vue'
import { Head , usePage, Link } from '@inertiajs/vue3'
import Layout from '@/Layouts/CrudLayout.vue'


</script>

<template>
<Layout>
    <Head title="Dados do cliente"/>
    
    Outro campos do cliente para alterar <br>


    <Link href="/profile">
    <span class="btn btn-sm btn-outline-primary">Alterar senha de acesso</span>
    </Link>


</Layout>
</template>

<style scoped>
</style>