<script setup>
import { ref } from 'vue'
import { Head , usePage, Link } from '@inertiajs/vue3'
import { computed } from 'vue';
import Layout from '@/Layouts/CrudLayout.vue';
import debug from '@/Components/Debug.vue';
import { useEventBus } from '@/Utils/eventBus'; // <-- IMPORTA O BUS em cada pagina que precisar.

defineProps({
    dados: Array,
    
});
const page = usePage();
const appName = computed(() => page.props.appName);
const exibirModal = ref(false);

const { emit } = useEventBus();

</script>

<template>
<Layout>
<Head :title="appName"/>
<span v-for="linha in dados" >
    {{ linha }}
</span>
    
</Layout>
</template>

<style scoped>
</style>