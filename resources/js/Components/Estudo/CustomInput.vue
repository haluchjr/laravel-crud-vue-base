<script setup>
// O defineModel faz todo o trabalho sujo de escutar o pai e emitir o evento de volta
const model = defineModel()
</script>

<template>
  <div class="input-wrapper">
    <label>Meu Input Customizado:</label>
    
    <input type="text" v-model="model" class="meu-input-estilizado" />
  </div>
</template>

<style scoped>
.input-wrapper {
  margin-bottom: 15px;
}
.meu-input-estilizado {
  border: 2px solid #42b883; /* Verde do Vue */
  background-color: #423;
  color:#fff;
  padding: 10px;
  border-radius: 4px;
  outline: none;
}
</style>