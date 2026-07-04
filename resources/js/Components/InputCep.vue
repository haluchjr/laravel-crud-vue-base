<script setup>

import { ref } from 'vue';
import axios from 'axios';

// Define os eventos que este componente pode disparar para o pai
const emit = defineEmits(['enderecoEncontrado']);

const cep = ref('');
const carregando = ref(false);

const buscarCep = async () => {
    // Remove traços ou espaços para validar o tamanho
    const cepLimpo = cep.value.replace(/\D/g, '');
    
    if (cepLimpo.length === 8) {
        carregando.value = true;
        try {
            // Faz a chamada para a sua rota do Laravel (que usa o Service)
            //
            //const response = await axios.get(`/api/cep/${cepLimpo}`);
            const response = await axios.get(`https://viacep.com.br/ws/${cepLimpo}/json/`);
            
            if (response.data) {
                // Emite o evento enviando os dados mapeados para o componente pai
                emit('enderecoEncontrado', {
                    cep: cepLimpo,
                    endereco: response.data.logradouro,
                    bairro: response.data.bairro,
                    cidade: response.data.localidade,
                    estado: response.data.uf
                });
            }
        } catch (error) {
            console.error("Erro ao buscar CEP:", error);
            alert('CEP não encontrado ou inválido.');
        } finally {
            carregando.value = false;
        }
    }
};
</script>

<template>
    <div class="form-group position-relative">
        <label for="cep">CEP</label>
        <input 
            type="text" 
            id="cep"
            v-model="cep" 
            @input="buscarCep"
            class="form-control" 
            placeholder="00000-000"
            maxlength="9"
            :disabled="carregando"
        />
        <small v-if="carregando" class="text-muted position-absolute end-0 bottom-0 mb-2 me-2">
            Buscando...
        </small>
    </div>
</template>