import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
    vue(),
  ],
  resolve:{
    //extensions: ['.js', '.ts', '.jsx', '.tsx', '.vue', '.json'],
  },
  server: {
    host: '0.0.0.0', // Permite conexões externas ao contêiner
    port: 5173,
    strictPort: true,
    // Configura o CORS diretamente no servidor de desenvolvimento do Vite
    cors: {
      origin: 'http://localhost:8020', // URL do seu Laravel
      credentials: true,
    },
    hmr: {
      host: 'localhost', // Garante que o Hot Module Replacement (HMR) conecte no host certo
      overlay: true, // Explode erros de compilacao na tela.
    },
    watch: {
      usePolling: true,
    },
  },
});