<script setup>
import { ref } from 'vue'
import { Head , usePage, Link } from '@inertiajs/vue3'
import Layout from '@/Layouts/CrudLayout.vue'


</script>

<template>
<Layout>
    <Head title="Dados do cliente"/>
    

    <Link href="/profile">
        <span class="btn btn-sm btn-outline-primary">Dados Pessoais</span>
    </Link>

    <Link href="/profile">
        <span class="btn btn-sm btn-outline-primary">Meus Endereços</span>
    </Link>

    <Link href="/profile">
        <span class="btn btn-sm btn-outline-primary">Alterar senha de acesso</span>
    </Link>

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
            <div class="col-md-6">
            <label class="form-label">Nome Completo</label>
            <input type="text" class="form-control" placeholder="Ex: João Silva">
            </div>
            <div class="col-md-6">
            <label class="form-label">E-mail</label>
            <input type="email" class="form-control" placeholder="joao@email.com">
            </div>
        </div>
        </div>

        <!-- Painel: Meus Endereços -->
        <div class="tab-pane fade" id="enderecos" role="tabpanel">
        <div class="row g-3">
            <div class="col-md-8">
            <label class="form-label">Rua / Logradouro</label>
            <input type="text" class="form-control">
            </div>
            <div class="col-md-4">
            <label class="form-label">Número</label>
            <input type="text" class="form-control">
            </div>
        </div>
        </div>

        <!-- Painel: Senha -->
        <div class="tab-pane fade" id="senha" role="tabpanel">
        <div class="row g-3">
            <div class="col-md-6">
            <label class="form-label">Nova Senha</label>
            <input type="password" class="form-control">
            </div>
        </div>
        </div>

    </div>
    </div>


</Layout>
</template>

<style scoped>
</style>