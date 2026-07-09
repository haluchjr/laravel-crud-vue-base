/*import { defineConfig } from 'vite';
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
      origin: 'http://localhost:8080', // URL do seu Laravel
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
});*/

import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig(({ mode }) => {
  // Carrega as variáveis do .env na raiz do projeto
  // O terceiro parâmetro '' garante que você leia qualquer variável (como APP_URL ou PORT)
  const env = loadEnv(mode, process.cwd(), '');

  // Define as portas pegando do .env ou usando os fallbacks padrão
  const vitePort = parseInt(env.PORTA_VITE) || 5173;
  const appUrl = env.APP_URL || 'http://localhost';

  return {
    plugins: [
      laravel({
        input: ['resources/css/app.css', 'resources/js/app.js'],
        refresh: true,
      }),
      vue(),
    ],
    resolve: {
      // extensions: ['.js', '.ts', '.jsx', '.tsx', '.vue', '.json'],
    },
    server: {
      host: '0.0.0.0', // Mantém liberado para o Docker
      port: vitePort,
      strictPort: true,
      
      // Configura o CORS dinamicamente com base na URL do seu Laravel (.env)
      /*cors: {
        origin: [
          'http://sistema.homelab',
          'http://localhost',
        ],
        methods: ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
        allowedHeaders: ['Content-Type', 'Authorization', 'X-Requested-With'],
        credentials: true,
      },*/

      cors:true,
      
      // Hot Module Replacement (HMR)
      hmr: {
        host:  'localhost', // PARA PRODUCAO '192.168.18.65' ||
        protocol:'ws',
        port: vitePort, // Garante que o HMR use a mesma porta dinâmica do servidor
        overlay: true,  // Explode erros de compilação na tela
      },
      
      watch: {
        usePolling: true,
      },
    },
  };
});