<script setup>
import { ref, computed } from 'vue'
import { Head, usePage } from '@inertiajs/vue3'

const page = usePage()
const copied = ref(false)

// Formata o JSON bonitinho com identação de 2 espaços
const formattedProps = computed(() => {
  return JSON.stringify(page.props, null, 2)
})


</script>

<template>
  <Head title="Debug Props" />

  <div class="debug-container">
    <div class="debug-header">
      <div class="debug-title">
        <span class="dot red"></span>
        <span class="dot yellow"></span>
        <span class="dot green"></span>
        <span class="title-text">Inertia debug props</span>
      </div>
    </div>

    <div class="debug-body">
      <pre><code>{{ formattedProps }}</code></pre>
    </div>
  </div>
</template>

<style scoped>
/* Container Principal estilo Dark Mode */
.debug-container {
  background-color: #1e1e1e;
  border-radius: 8px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
  font-family: 'Fira Code', 'Courier New', Courier, monospace;
  margin: 20px;
  overflow: hidden;
  border: 1px solid #333;
}

/* Cabeçalho estilo janela do Mac / DevTools */
.debug-header {
  background-color: #2d2d2d;
  padding: 12px 16px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid #3c3c3c;
}

.debug-title {
  display: flex;
  align-items: center;
  gap: 6px;
}

.dot {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  display: inline-block;
}
.dot.red { background-color: #ff5f56; }
.dot.yellow { background-color: #ffbd2e; }
.dot.green { background-color: #27c93f; }

.title-text {
  color: #aaa;
  font-size: 13px;
  margin-left: 10px;
  font-weight: bold;
}

/* Botão de Copiar */
.copy-btn {
  background-color: #3a3a3a;
  color: #ccc;
  border: 1px solid #555;
  padding: 6px 12px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 12px;
  transition: all 0.2s ease;
}

.copy-btn:hover {
  background-color: #4a4a4a;
  color: #fff;
}

.copy-btn.success {
  background-color: #27c93f;
  color: #fff;
  border-color: #27c93f;
}

/* Área do JSON */
.debug-body {
  padding: 16px;
  max-height: 70vh;
  overflow-y: auto;
}

pre {
  margin: 0;
}

code {
  color: #a9dc76; /* Cor verde estilo Monokai para o texto */
  font-size: 14px;
  line-height: 1.5;
  white-space: pre-wrap;       /* Quebra linha se for muito grande */
  word-break: break-all;
}
</style>