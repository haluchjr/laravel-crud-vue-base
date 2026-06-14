<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3';
// ----------------------------------------------
// Exemplo simples de POST usando Inertia.js
// ----------------------------------------------
// Quando quero enviar dados do frontend para o 
// backend, uso o useForm para criar um formulário reativo.
//-----------------------------------------------
// @click fica ouvindo a mudança no botão, e quando o usuário clicar, 
// ele chama a função enviar, que é onde fazemos a requisição POST usando o form.post.

const form = useForm({
    // Define your form fields here
    nome: '',
    idade: '',
});

// post
const enviar = () => {
    form.post(route('estudo.teste.salvar'), {
        onSuccess: () => {
            console.log('Formulário enviado com sucesso!');
            form.reset(); // Limpa o formulário após o envio bem-sucedido
        },
        onError: (errors) => {
            console.error('Erro ao enviar formulário:', errors);
        },
    });
};

</script>

<template>


<input type="text" v-model="form.nome" placeholder="Digite seu nome" /><br>
<input type="text" v-model="form.idade" placeholder="Digite sua idade" /><br>
<button @click="enviar">Enviar</button>

</template>

<style scoped>
</style>