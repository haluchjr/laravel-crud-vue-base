# 🚀 Ambiente de Estudos: Laravel 11 + Vue 3 + Inertia.js

Este é um projeto focado no aprendizado prático e domínio da integração entre o ecossistema backend do **Laravel 11** e o framework reativo **Vue 3 (Composition API)**, utilizando o **Inertia.js** como ponte de comunicação (eliminando a necessidade de construir APIs REST ou configurar rotas cliente isoladas).

---

## 🛠️ Tecnologias e Dependências Principais

### Backend (Composer)
* **PHP `^8.3`**
* **Laravel Framework `^11.0`** (Estrutura de pastas moderna e enxuta)
* **Inertia Laravel `^2.0`** (Adaptador backend para renderização de componentes Vue)
* **Laravel Breeze `^2.4`** (Scaffolding inicial utilizado para autenticação/estrutura)
* **Ziggy `^2.0`** (Compartilhamento das rotas do Laravel direto no Javascript do Vue)
* **Laravel Telescope `^5.20` (Dev)** (Painel de monitoramento avançado para depuração de requisições, payloads e logs)

### Frontend (NPM / Vite)
* **Vue `^3.5`** (Utilizando a sintaxe moderna `<script setup>`)
* **Inertia Vue3 `^2.0`** (Diretivas, links e gerenciamento de formulários reativos com `useForm`)
* **Vite `^5.0`** (Bundler ultrarrápido para compilação dos assets do frontend)
* **Tailwind CSS `^3.2`** (Framework utilitário para estilização de componentes)
* **Axios `^1.6`** (Disponível para requisições AJAX puras assíncronas)

---

## 📂 Módulos Desenvolvidos no Playground (`Estudo.vue`)

O componente principal atua como um painel interativo (Playground) onde os conceitos essenciais do Vue 3 e do Inertia são aplicados de forma isolada e modular:

1.  **Fundamentos do Vue 3:** Reatividade (`ref`, `reactive`), Diretivas condicionais e de repetição (`v-if`, `v-show`, `v-for`), Data Binding (`v-bind`, `v-model`) e manipulação de Classes/Styles dinâmicos.
2.  **Ciclo de Vida e Computadas:** Manipulação de eventos, propriedades calculadas (`computed`), observadores (`watch`) e ganchos de ciclo de vida (`LifeCycle`).
3.  **Arquitetura de Componentes:** Comunicação via passagens de propriedades (`Props`), emissão de eventos do filho para o pai (`Emits`) e layouts flexíveis utilizando Slots nomeados.
4.  **Integração com Backend (Inertia):**
    * Tratamento de Mensagens Flash injetadas pelo Laravel.
    * Envio de formulários completos usando o Helper `useForm`.
    * **Upload de arquivos para o disco local** com persistência física, geração automática de nomes aleatórios seguros (*hashes*) e retorno de dados assíncronos em tempo real.

---

