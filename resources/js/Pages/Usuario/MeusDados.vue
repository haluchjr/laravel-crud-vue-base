<script setup>
import { ref } from 'vue'
import { Head , usePage, Link } from '@inertiajs/vue3'
import Layout from '@/Layouts/CrudLayout.vue'
import DadosPessoaisForm from '@/Pages/Usuario/Partials/DadosPessoais.vue';
import UpdatePasswordForm from '@/Pages/Usuario/Partials/UpdatePassword.vue';
import EnderecosForm from '@/Pages/Usuario/Partials/Enderecos.vue';
defineProps({
  tipos_enderecos: Array, // Recebe do Controller
  enderecos_cadastrados:Array,
  dados_pessoais: Object,
  endereco_editado : Object,
});
</script>

<template>
<Layout>
    <Head title="Meus dados"/>
    <template #header>
        <h1 class="h3 mb-0">Meus dados</h1>
    </template>
    
    <div class="container mt-4">
        <!-- 1. Cabeçalho das Abas -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
            <button class="nav-link active" id="dados-tab" data-bs-toggle="tab" data-bs-target="#dados" type="button" role="tab">
                Dados Pessoais
            </button>
            </li>
            <li class="nav-item" role="presentation">
            <button class="nav-link" id="enderecos-tab" data-bs-toggle="tab" data-bs-target="#enderecos" type="button" role="tab">
                Meus Endereços
            </button>
            </li>
            <li class="nav-item" role="presentation">
            <button class="nav-link" id="senha-tab" data-bs-toggle="tab" data-bs-target="#senha" type="button" role="tab">
                Alterar senha de acesso
            </button>
            </li>
        </ul>

        <!-- 2. Container do Conteúdo (com borda e espaçamento interno do BS) -->
        <div class="tab-content border-start border-end border-bottom p-4 bg-white rounded-bottom" id="myTabContent">
            
            <!-- Painel: Dados Pessoais (Ativo por padrão) -->
            <div class="tab-pane fade show active" id="dados" role="tabpanel">
                <div class="row g-3"> <!-- g-3 cria o espaçamento (gap) perfeito entre as colunas do form -->
                    <DadosPessoaisForm 
                        :dados_pessoais="dados_pessoais"
                    />
                </div>
            </div>

            <!-- Painel: Meus Endereços -->
            <div class="tab-pane fade" id="enderecos" role="tabpanel">
                <div class="row g-3">
                    <EnderecosForm 
                        :tipos_enderecos="tipos_enderecos" 
                        :enderecos_cadastrados="enderecos_cadastrados" 
                        :endereco_editado="endereco_editado"
                    />
                </div>
            </div>

            <!-- Painel: Senha -->
            <div class="tab-pane fade" id="senha" role="tabpanel">
                <div class="row g-3">
                    <UpdatePasswordForm />
                </div>
            </div>

        </div>
    </div>

</Layout>
</template>

<style scoped>
</style>