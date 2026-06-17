# Guia de Referência: Imports Essenciais (Vue 3 + Inertia.js)

Este guia prático foi criado para servir como uma "colinha" rápida de consulta para o seu dia a dia desenvolvendo com **Vue 3 (`<script setup>`)** e **Inertia.js**.

---

## 1. Core do Vue 3 (`'vue'`)
Recursos essenciais para gerenciar reatividade, propriedades computadas, observadores e o ciclo de vida do componente.

| O que digitar | De onde vem | Para que serve? (Exemplo prático) |
| :--- | :--- | :--- |
| `ref` | `'vue'` | Cria variáveis reativas de tipos primitivos ou objetos (`const status = ref(true)`). |
| `reactive` | `'vue'` | Cria um objeto reativo (ideal para agrupar estados relacionados, ex: `const estado = reactive({})`). |
| `computed` | `'vue'` | Cria uma variável derivada cujo valor é recalculado automaticamente baseado em outra. |
| `watch` | `'vue'` | Escuta alterações em uma variável reativa e executa uma função colateral (efeito). |
| `onMounted` | `'vue'` | Gancho de ciclo de vida que roda um bloco de código assim que o componente é montado na tela. |
| `defineProps` | *(Global)* | **Não precisa de import!** Declara as propriedades que o componente recebe do backend ou pai. |
| `defineEmits` | *(Global)* | **Não precisa de import!** Declara os eventos que este componente pode emitir para o pai. |

---

## 2. Ecossistema Inertia.js (`'@inertiajs/vue3'`)
Recursos que substituem o Vue Router e o Axios, fazendo a ponte direta e transparente entre o Vue e o seu framework de backend (como o Laravel).

| O que digitar | De onde vem | Para que serve? |
| :--- | :--- | :--- |
| `Link` | `'@inertiajs/vue3'` | Componente para criar links de navegação SPA (muda de página sem dar *refresh* completo). |
| `Head` | `'@inertiajs/vue3'` | Permite injetar e gerenciar tags no `<head>` da página, como `<title>` e `<meta>`. |
| `useForm` | `'@inertiajs/vue3'` | **O mais importante para formulários.** Gerencia dados, estado de envio (`processing`) e erros vindos do backend. |
| `router` | `'@inertiajs/vue3'` | Objeto utilitário para navegação manual e disparos de requisições programáticas (`router.visit`, `router.post`). |
| `usePage` | `'@inertiajs/vue3'` | Hook para acessar dados globais compartilhados pelo backend em qualquer lugar (ex: `page.props.auth.user`). |

---

## 💻 Exemplo Prático de Aplicação

Abaixo está a estrutura ideal de um componente moderno utilizando a sintaxe `<script setup>` combinando os recursos de ambas as tabelas:

```html
<script setup>
// 1. Imports do Vue 3
import { ref, computed } from 'vue'

// 2. Imports do Inertia.js
import { Head, Link, useForm } from '@inertiajs/vue3'

// Recebendo dados injetados pelo controller do Laravel automaticamente
const props = defineProps({
  usuarios: Array
})

// Inicializando o formulário inteligente do Inertia
const form = useForm({
  nome: '',
  email: ''
})

// Função para disparar os dados do formulário
const enviarFormulario = () => {
  form.post('/usuarios/salvar', {
    onSuccess: () => form.reset()
  })
}

// Exemplo de propriedade computada (Vue)
const totalUsuarios = computed(() => props.usuarios.length)
</script>

<template>
  <!-- Controlando metadados da página -->
  <Head title="Gerenciamento de Usuários" />

  <div class="container">
    <h1>Novo Usuário (Total atual: {{ totalUsuarios }})</h1>
    
    <form @submit.prevent="enviarFormulario">
      <input v-model="form.nome" type="text" placeholder="Nome completo" />
      <input v-model="form.email" type="email" placeholder="E-mail" />
      
      <!-- Feedback visual nativo do form helper do Inertia -->
      <button type="submit" :disabled="form.processing">
        {{ form.processing ? 'Salvando...' : 'Salvar Registro' }}
      </button>
    </form>

    <!-- Navegação SPA sem recarregamento de página -->
    <Link href="/dashboard" class="btn-voltar">Voltar para a Home</Link>
  </div>
</template>