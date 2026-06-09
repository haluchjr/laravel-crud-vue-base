<template>
  <div class="hello-container">
    <h1>¡Ambiente Vue Configurado! 🚀</h1>
    <p class="subtitle">Se você está vendo isso, o Vite + Docker estão conversando.</p>
    
    <div class="card">
      <p>Cliques no botão: <strong>{{ contador }}</strong></p>
      <button @click="incrementar">Incrementar Contador</button>
    </div>

    <div class="footer">
      <p>Modifique este texto no editor e veja a mágica do Hot Reload.</p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

// Estado reativo para testar o clique
const contador = ref(0)

const incrementar = () => {
  contador.value++
}
</script>

<style scoped>
.hello-container {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  text-align: center;
  margin-top: 60px;
  color: #2c3e50;
}

h1 {
  color: #42b983; /* Verde clássico do Vue */
  font-size: 2.5rem;
}

.subtitle {
  color: #7f8c8d;
  font-size: 1.2rem;
}

.card {
  background-color: #f8f9fa;
  border-radius: 8px;
  padding: 20px;
  display: inline-block;
  margin-top: 20px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

button {
  background-color: #42b983;
  color: white;
  border: none;
  padding: 10px 20px;
  font-size: 1rem;
  border-radius: 4px;
  cursor: pointer;
  transition: background 0.2s;
}

button:hover {
  background-color: #35495e;
}

.footer {
  margin-top: 40px;
  font-size: 0.9rem;
  color: #bdc3c7;
}
</style><template>
  <div class="hello-container">
    <h1>¡Ambiente Vue Configurado! 🚀</h1>
    <p class="subtitle">Se você está vendo isso, o Vite + Docker estão conversando.</p>
    
    <div class="card">
      <p>Cliques no botão: <strong>{{ contador }}</strong></p>
      <button @click="incrementar">Incrementar Contador</button>
    </div>

    <div class="footer">
      <p>Modifique este texto no editor e veja a mágica do Hot Reload.</p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

// Estado reativo para testar o clique
const contador = ref(0)

const incrementar = () => {
  contador.value++
}
</script>

<style scoped>
.hello-container {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  text-align: center;
  margin-top: 60px;
  color: #2c3e50;
}

h1 {
  color: #42b983; /* Verde clássico do Vue */
  font-size: 2.5rem;
}

.subtitle {
  color: #7f8c8d;
  font-size: 1.2rem;
}

.card {
  background-color: #f8f9fa;
  border-radius: 8px;
  padding: 20px;
  display: inline-block;
  margin-top: 20px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

button {
  background-color: #42b983;
  color: white;
  border: none;
  padding: 10px 20px;
  font-size: 1rem;
  border-radius: 4px;
  cursor: pointer;
  transition: background 0.2s;
}

button:hover {
  background-color: #35495e;
}

.footer {
  margin-top: 40px;
  font-size: 0.9rem;
  color: #bdc3c7;
}
</style>
