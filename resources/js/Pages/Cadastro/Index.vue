<script setup>
import { ref } from 'vue';
import InputCep from '@/Components/InputCep.vue'; // Ajuste o caminho conforme seu projeto
import CrudLayout from '@/Layouts/CrudLayoutNoMenu.vue';
/*
====================================================================================================
           EXPLICAÇÃO DO FLUXO: COMUNICAÇÃO ENTRE COMPONENTES (VUE 3)
====================================================================================================

Este documento explica de forma detalhada o funcionamento técnico do formulário de cadastro, focando em como os dados retornados 
pelo componente filho ("InputCep") entram no estado global do formulário pai ("formulario") para serem enviados ao Laravel.

----------------------------------------------------------------------------------------------------
1. O ESTADO LOCAL DO FORMULÁRIO (A REATIVIDADE DO VUE)
----------------------------------------------------------------------------------------------------
No bloco do <script>, a constante "formulario" guarda a estrutura de dados reativa da tela:

    const formulario = ref({
        nome: '',
        email: '',
        cep: '',
        endereco: '',
        bairro: '',
        cidade: '',
        estado: '',
        nr: ''
    });

* O que acontece aqui? O método "ref()" torna este objeto reativo. No Vue, isso significa que qualquer alteração nas propriedades 
(como "formulario.value.endereco") vai atualizar a interface visual (HTML) instantaneamente, e vice-versa (através do "v-model").

----------------------------------------------------------------------------------------------------
2. A PONTE ENTRE OS COMPONENTES (A TAG INPUTCEP)
----------------------------------------------------------------------------------------------------
Dentro do <template>, o componente de CEP é invocado desta forma:

    <InputCep @enderecoEncontrado="preencherEndereco" />

* O que o "@" faz? Ele é um escutador de eventos (v-on:). O componente "InputCep" está isolado. Quando ele termina a busca na 
API do ViaCep/Laravel, ele dispara um "alarme" interno chamado "enderecoEncontrado", empacotando junto os dados descobertos (JSON).
* Destino da ação: Ao escutar o "alarme", a tela pai intercepta esse sinal e redireciona os dados recebidos diretamente para a 
função "preencherEndereco". O Vue faz o repasse do parâmetro de forma automática por baixo dos panos.

----------------------------------------------------------------------------------------------------
3. A FUNÇÃO DE CAPTURA ("preencherEndereco")
----------------------------------------------------------------------------------------------------
Quando o evento é disparado, a função "preencherEndereco" entra em execução recebendo o objeto do filho:

    const preencherEndereco = (dados) => {
        formulario.value.cep = dados.cep;
        formulario.value.endereco = dados.endereco;
        formulario.value.bairro = dados.bairro;
        formulario.value.cidade = dados.cidade;
        formulario.value.estado = dados.estado;
        
        document.getElementById('nr')?.focus();
    };

* Atualização do Estado: O parâmetro "dados" contém o logradouro, bairro, cidade, etc. A função substitui os valores vazios 
do "formulario.value" pelos valores reais encontrados.
* Fluidez de UX: A linha "document.getElementById('nr')?.focus();" é um toque de usabilidade. Assim que o endereço aparece na 
tela, o cursor do teclado pula sozinho para o campo "Número", evitando que o usuário precise clicar nele manualmente.

----------------------------------------------------------------------------------------------------
4. EXIBIÇÃO VISUAL E SEGURANÇA NO HTML
----------------------------------------------------------------------------------------------------
No HTML, os campos de endereço utilizam o modificador "readonly":

    <input type="text" v-model="formulario.endereco" class="form-control" readonly>

* Por que usar readonly? O "v-model" faz o vínculo bidirecional. Ao marcar o campo como "readonly" (apenas leitura), 
o usuário consegue ver o endereço que foi injetado pelo JavaScript, mas fica impossibilitado de digitar ou alterar o texto. 
Isso garante que a base de dados não receba nomes de ruas ou cidades inventados ou grafados com erros ortográficos.

----------------------------------------------------------------------------------------------------
5. O FECHAMENTO DO CICLO ("enviarCadastro")
----------------------------------------------------------------------------------------------------
Quando o botão "Salvar Cadastro" é acionado, o formulário dispara o evento de envio:

    <form @submit.prevent="enviarCadastro" ...>

* O modificador ".prevent" cancela o comportamento padrão do HTML (que recarregaria a página inteira).
* A função "enviarCadastro" recolhe o objeto "formulario.value" perfeitamente preenchido: tanto o "nome" e o "nr" 
(que o usuário digitou) quanto o "endereco", "bairro", "cidade" e "estado" (que vieram de forma automatizada do componente de CEP).
* Próximo passo: Esse objeto "formulario.value" consolidado está pronto para ser despachado via Axios ou Inertia para o
 Controller do Laravel, que por sua vez acionará o seu Repository (com o método .create() e proteção do $fillable) para salvar definitivamente no banco de dados.
====================================================================================================
*/

// O seu formulário do cadastro (que depois você enviará para o seu Repository)
const formulario = ref({
    nome: '',
    email: '',
    cep: '',
    endereco: '',
    bairro: '',
    cidade: '',
    estado: '',
    nr: ''
});

// Esta função será executada assim que o componente de CEP achar o endereço
const preencherEndereco = (dados) => {
    formulario.value.cep = dados.cep;
    formulario.value.endereco = dados.endereco;
    formulario.value.bairro = dados.bairro;
    formulario.value.cidade = dados.cidade;
    formulario.value.estado = dados.estado;
    
    // Opcional: Colocar o foco automaticamente no input de "Número" para o usuário continuar digitando
    document.getElementById('nr')?.focus();
};

const enviarCadastro = () => {
    // Aqui você enviaria o formulario.value via axios ou Inertia para o seu Controller/Repository
    console.log('Enviando dados para o Laravel:', formulario.value);
};
</script>

<template>
    <CrudLayout>
        <form @submit.prevent="enviarCadastro" class="container mt-4">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Nome</label>
                    <input type="text" v-model="formulario.nome" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <InputCep @enderecoEncontrado="preencherEndereco" />
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 mb-3">
                    <label>Endereço</label>
                    <input type="text" v-model="formulario.endereco" class="form-control" readonly>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Número</label>
                    <input type="text" id="nr" v-model="formulario.nr" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-md-5 mb-3">
                    <label>Bairro</label>
                    <input type="text" v-model="formulario.bairro" class="form-control" readonly>
                </div>
                <div class="col-md-5 mb-3">
                    <label>Cidade</label>
                    <input type="text" v-model="formulario.cidade" class="form-control" readonly>
                </div>
                <div class="col-md-2 mb-3">
                    <label>Estado</label>
                    <input type="text" v-model="formulario.estado" class="form-control" readonly>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Salvar Cadastro</button>
        </form>
    </CrudLayout>
</template>