<script setup>
// Padrao do JS
import { ref, computed } from 'vue';
import { router, useForm,usePage} from '@inertiajs/vue3'; 

// Meus Imports
import CrudLayout from '@/Layouts/CrudLayout.vue';
import ModalBootstrap from '@/Components/ModalBs.vue';


const modalAberto = ref(false);
const projetoIdSelecionado = ref(null); // Guarda o ID temporariamente

// 1. Abre o modal e memoriza o ID do projeto clicado
const abrirModalExclusao = (id) => {
    projetoIdSelecionado.value = id;
    modalAberto.value = true;
};

// 2. A função de exclusão apenas lê o ID que foi guardado
const confirmarExclusao = () => {
    console.log('Deletando o projeto de ID:', projetoIdSelecionado.value);
    // Ex: router.delete(`/projetos/${projetoIdSelecionado.value}`);
    alert(`Projeto com ID ${projetoIdSelecionado.value} deletado!`);
    modalAberto.value = false;
    projetoIdSelecionado.value = null; // Reseta o estado
};

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

        <button class="btn btn-primary" @click="abrirModalExclusao('1')">Abrir Modal</button>
        <button class="btn btn-primary" @click="abrirModalExclusao('2')">Abrir Modal</button>
        <button class="btn btn-primary" @click="abrirModalExclusao('3')">Abrir Modal</button>

        <ModalBootstrap :show="modalAberto" title="Confirmar Exclusão" @close="modalAberto = false">
            <p>Você quer fazer algo aqui ???</p>
            <template #actions>
                <button type="button" class="btn btn-light" @click="modalAberto = false">
                    Cancelar
                </button>
                <button type="button" class="btn btn-danger" @click="confirmarExclusao()">
                    Confirmar Exclusão
                </button>
            </template>
        </ModalBootstrap>

    </CrudLayout>
</template>

<style scoped>
</style>