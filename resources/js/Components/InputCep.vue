<script setup>
/*
                    <InputCep @enderecoEncontrado="preencherEndereco" />

Essa linha é onde acontece a mágica da comunicação entre o Componente Filho (InputCep.vue) 
e o Componente Pai (a sua Tela de Cadastro).

No Vue 3, a estrutura funciona através de um conceito chamado Props down, 
Events up (Propriedades descem, Eventos sobem). Como o componente de CEP está isolado, 
ele precisa de uma forma de "gritar" para a tela principal: "Ei, acabei de achar o endereço! Toma aqui os dados!".

Vamos quebrar essa linha em três partes para entender exatamente como o Vue processa isso:
1. O Componente: <InputCep />

Aqui você está injetando a caixinha do input de CEP que criamos isolada. O Vue vai renderizar o 
campo de texto e gerenciar a digitação e a busca do Axios ali dentro de forma independente.
2. O Ouvinte de Evento: @enderecoEncontrado

O símbolo arroba (@) no Vue é um atalho para v-on:, que serve para escutar um evento.

    Você já deve ter usado o @click="salvar", que escuta o evento nativo de clique do navegador.

    O @enderecoEncontrado é um evento personalizado criado por você dentro do arquivo InputCep.vue através da linha const emit = defineEmits(['enderecoEncontrado']).

Ele funciona como um alarme. A tela pai fica ali parada, olhando para o InputCep, esperando esse alarme disparar.
3. A Ação: ="preencherEndereco"

Este é o nome da função que está criada na sua tela pai (na raiz). Quando o alarme @enderecoEncontrado 
disparar lá de dentro do filho, a tela pai fala: "Opa, o alarme tocou! Deixa eu rodar a minha função preencherEndereco agora".

O Fluxo Completo (Passo a Passo)

Para ficar 100% claro, imagine o caminho que o dado faz:
[Usuário digita o CEP 80000000 no InputCep]
                  ↓
[O InputCep faz o Axios buscar no Laravel]
                  ↓
[Laravel/ViaCep responde com o endereço completo]
                  ↓
[O InputCep executa: emit('enderecoEncontrado', { dados })] (O Alarme toca!)
                  ↓
[A Tela Pai escuta o alarme através do @enderecoEncontrado]
                  ↓
[A Tela Pai pega esses { dados } e joga para dentro da função preencherEndereco(dados)]
                  ↓
[A função atualiza o formulario.value e os campos aparecem preenchidos na tela]


O mais legal é que o Vue passa o argumento automaticamente. Você não precisa escrever @enderecoEncontrado="preencherEndereco(dados)". Ao colocar apenas o nome da função,
 o Vue entende que qualquer dado enviado pelo emit do filho deve ser entregue como o primeiro parâmetro da função do pai.

*/
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