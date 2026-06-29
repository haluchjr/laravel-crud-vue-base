# 💻 Sistema — Base Template

Este é um projeto moderno baseado no **Laravel framework**, estruturado de forma monolítica híbrida utilizando **Inertia.js** e **Vue 3** no front-end, totalmente integrado com estilização **Bootstrap** e utilitários **TailwindCSS**.

---

## 🛠️ Stack Tecnológica

### Back-end (PHP)
* **Framework:** Laravel `^12.0` (PHP `^8.2`)
* **Autenticação/API:** Laravel Sanctum `^4.0`
* **Markdown Parser:** Parsedown `^1.8` (Ideal para renderizar textos/artigos)
* **Ambiente de Dev:** Laravel Sail (Docker), Tinker, e Laravel Telescope (Debug)

### Front-end (JavaScript)
* **Core:** Vue 3 `^3.5` & Vite `^5.0`
* **Ponte SPA:** Inertia.js `^2.0` (Integração nativa Vue + Laravel)
* **Estilização:** Bootstrap `^5.3` (Componentes visuais) & TailwindCSS `^3.2` (Classes utilitárias/forms)
* **Componentes Auxiliares:** Vue-Toastification (Notificações em tempo real) e Highlight.js (Destaque de sintaxe/código)

---

## 🐋 Ambiente e Infraestrutura (Docker)

O projeto está configurado para rodar em containers isolados via **Laravel Sail**. Com base no `.env`, a arquitetura do ecossistema é composta por:

| Serviço | Tecnologia | Host Interno | Porta Externa |
| :--- | :--- | :--- | :--- |
| **Web Server** | PHP-CLI / Vite | `localhost` | `8080` (App) / `5173` (Vite) |
| **Banco de Dados** | MySQL | `db_mysql` | `3306` |
| **Cache & Sessão**| Redis | `cache` | `6379` |
| **Filas / Queue** | Database | — | — |
| **E-mails (Dev)** | Mailtrap (SMTP) | Sandbox | `587` |

---

## ⚡ Comandos e Scripts Disponíveis

### Automatizações do Composer
O `composer.json` está programado para executar rotinas automáticas em eventos do ciclo de vida da aplicação:
* **Ao instalar o projeto:** Cria o `.env`, gera a `APP_KEY`, cria o banco SQLite (se aplicável) e roda as migrations.
* **Ao rodar dump-autoload:** Faz o autodiscover dos pacotes instalados.
* **Ao atualizar dependências:** Força a republicação de assets do core do Laravel.

### Scripts de Compilação (NPM)
```bash
# Iniciar o servidor de desenvolvimento do Vite (Hot Reloading)
npm run dev

# Compilar e minificar os assets para produção
npm run build