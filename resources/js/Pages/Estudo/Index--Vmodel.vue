<script setup>
import { ref } from 'vue'
import Custom from '@/Components/Estudo/CustomInput.vue';



// Criamos a nossa variável reativa (o estado)
const texto = ref('');
const aceitarTermos = ref(false);
const tecnologias = ref([]);
const planoSelecionado = ref('') // Começa vazio

const nomeDesafio = ref('');
const turmaDesafio = ref('');

const textoPai = ref('Texto inicial');
</script>

<template>
  <div class="container">
    <h2>Entendendo o v-model</h2>
    
    <input 
      v-model="texto" 
      placeholder="Digite algo aqui..."
    />

    <p>O que você está digitando: <strong>{{ texto }}</strong></p>
    
    <button @click="texto = 'Texto resetado!'">Resetar Texto</button>
    <hr>
    <label><input  type="checkbox" v-model="aceitarTermos"/>
        Aceito.
    </label>
    <p>Status {{ aceitarTermos ? 'sim' : 'nao'  }}</p>
    <hr>
    <h3>O que você estuda?</h3>
  
  <label><input type="checkbox" value="Vue" v-model="tecnologias"> Vue.js</label><br>
  <label><input type="checkbox" value="Laravel" v-model="tecnologias"> Laravel</label><br>
  <label><input type="checkbox" value="Docker" v-model="tecnologias"> Docker</label>

  <p>Tecnologias selecionadas: <strong>{{ tecnologias }}</strong></p>
    <hr>
    <h3>Selecione seu plano:</h3>
  
  <select v-model="planoSelecionado">
    <option value="" disabled>Escolha uma opção...</option>
    <option value="basic">Plano Básico - R$ 29/mês</option>
    <option value="pro">Plano Pro - R$ 59/mês</option>
    <option value="enterprise">Plano Enterprise - R$ 119/mês</option>
  </select>

  <p>ID do plano para enviar para a API: <strong>{{ planoSelecionado }}</strong></p>
  <hr>

    <div>
        <h2>Formulario</h2>
        <hr>
        <Label>
            Informe seu nome: <input v-model="nomeDesafio" />
        </Label>
        <label>
            Selecione uma turma : 
            <select v-model="turmaDesafio">
                <option value="1">Primeiro</option>
                <option value="2">Segundo</option>
                <option value="3">Terceiro</option>
            </select>
        </label>
        <span>{{ nomeDesafio }} selecionou {{turmaDesafio}}</span>
    </div>

    <hr>
    Custom componentes.
    <Custom v-model="textoPai"/>
    Valor : {{ textoPai }}



  </div>
</template>

<style scoped>
.container {
  padding: 20px;
  font-family: sans-serif;
}
input {
  padding: 8px;
  font-size: 16px;
  margin-right: 10px;
}
button {
  display: block;
  margin-top: 15px;
  padding: 8px 12px;
  cursor: pointer;
}

hr{
     width: 100%;
    height: 1px;
    border: 0px;
    border-top: 1px solid red;
    background-color: #dddddd;
}
</style>