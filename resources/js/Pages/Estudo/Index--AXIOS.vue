<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import axios from 'axios'; // Importamos o Axios tradicional

const form = useForm({
    nome: '',
});

//  VARIÁVEL REATIVA PARA GUARDAR O RETORNO
const respostaDoBack = ref(null);

const enviarComAxios = () => {
    // 1. Ativamos o estado de processamento manualmente (opcional, mas boa prática)
    form.processing = true; 
    respostaDoBack.value = null; // Limpa a resposta anterior, se houver

    // 2. Fazemos o POST direto para a URL usando o Axios
    axios.post('/estudo/teste-axios', {
        nome: form.nome // Passamos o dado do input no corpo da requisição
    })
    .then((resposta) => {
        //  EQUIVALENTE AO onSuccess
        console.log('Resposta do servidor:', resposta.data);
        respostaDoBack.value = resposta.data; // Guarda a resposta
        alert('Enviado via Axios! Resposta: ' + resposta.data.mensagem);
        
        form.reset(); // Limpa o input
    })
    .catch((erro) => {
        // ❌ EQUIVALENTE AO onError
        console.error('Erro na requisição:', erro.response?.data);
        alert('Erro ao enviar os dados.');
    })
    .finally(() => {
        // Sempre executa aqui, dando certo ou errado (desliga o loading)
        form.processing = false;
    });
};
</script>

<template>
  <div style="padding: 20px;">
    <h3>Enviar via Axios:</h3>
    <input type="text" v-model="form.nome" placeholder="Digite seu nome" />
    
    <button @click="enviarComAxios" :disabled="form.processing">
        {{ form.processing ? 'Enviando...' : 'Enviar via Axios' }}
    </button>

    <div v-if="respostaDoBack" style="margin-top: 20px; padding: 10px; border: 1px solid #ccc;">
        <h4>Resposta do Backend:</h4>
        <pre>{{ respostaDoBack }}</pre>
    </div>
  </div>
</template>