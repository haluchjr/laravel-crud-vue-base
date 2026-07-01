// vite.config.js
import { defineConfig, loadEnv } from "file:///var/www/html/node_modules/vite/dist/node/index.js";
import laravel from "file:///var/www/html/node_modules/laravel-vite-plugin/dist/index.js";
import vue from "file:///var/www/html/node_modules/@vitejs/plugin-vue/dist/index.mjs";
var vite_config_default = defineConfig(({ mode }) => {
  const env = loadEnv(mode, process.cwd(), "");
  const vitePort = parseInt(env.PORTA_VITE) || 5173;
  const appUrl = env.APP_URL || "http://localhost";
  return {
    plugins: [
      laravel({
        input: ["resources/css/app.css", "resources/js/app.js"],
        refresh: true
      }),
      vue()
    ],
    resolve: {
      // extensions: ['.js', '.ts', '.jsx', '.tsx', '.vue', '.json'],
    },
    server: {
      host: "0.0.0.0",
      // Mantém liberado para o Docker
      port: vitePort,
      strictPort: true,
      // Configura o CORS dinamicamente com base na URL do seu Laravel (.env)
      cors: {
        origin: [
          "http://localhost",
          "http://sistema.local"
        ],
        methods: ["GET", "POST", "PUT", "DELETE", "OPTIONS"],
        allowedHeaders: ["Content-Type", "Authorization", "X-Requested-With"],
        credentials: true
      },
      // Hot Module Replacement (HMR)
      hmr: {
        host: "localhost",
        port: vitePort,
        // Garante que o HMR use a mesma porta dinâmica do servidor
        overlay: true
        // Explode erros de compilação na tela
      },
      watch: {
        usePolling: true
      }
    }
  };
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCIvdmFyL3d3dy9odG1sXCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ZpbGVuYW1lID0gXCIvdmFyL3d3dy9odG1sL3ZpdGUuY29uZmlnLmpzXCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ltcG9ydF9tZXRhX3VybCA9IFwiZmlsZTovLy92YXIvd3d3L2h0bWwvdml0ZS5jb25maWcuanNcIjsvKmltcG9ydCB7IGRlZmluZUNvbmZpZyB9IGZyb20gJ3ZpdGUnO1xuaW1wb3J0IGxhcmF2ZWwgZnJvbSAnbGFyYXZlbC12aXRlLXBsdWdpbic7XG5pbXBvcnQgdnVlIGZyb20gJ0B2aXRlanMvcGx1Z2luLXZ1ZSc7XG5cbmV4cG9ydCBkZWZhdWx0IGRlZmluZUNvbmZpZyh7XG4gIHBsdWdpbnM6IFtcbiAgICBsYXJhdmVsKHtcbiAgICAgIGlucHV0OiBbJ3Jlc291cmNlcy9jc3MvYXBwLmNzcycsICdyZXNvdXJjZXMvanMvYXBwLmpzJ10sXG4gICAgICByZWZyZXNoOiB0cnVlLFxuICAgIH0pLFxuICAgIHZ1ZSgpLFxuICBdLFxuICByZXNvbHZlOntcbiAgICAvL2V4dGVuc2lvbnM6IFsnLmpzJywgJy50cycsICcuanN4JywgJy50c3gnLCAnLnZ1ZScsICcuanNvbiddLFxuICB9LFxuICBzZXJ2ZXI6IHtcbiAgICBob3N0OiAnMC4wLjAuMCcsIC8vIFBlcm1pdGUgY29uZXhcdTAwRjVlcyBleHRlcm5hcyBhbyBjb250XHUwMEVBaW5lclxuICAgIHBvcnQ6IDUxNzMsXG4gICAgc3RyaWN0UG9ydDogdHJ1ZSxcbiAgICAvLyBDb25maWd1cmEgbyBDT1JTIGRpcmV0YW1lbnRlIG5vIHNlcnZpZG9yIGRlIGRlc2Vudm9sdmltZW50byBkbyBWaXRlXG4gICAgY29yczoge1xuICAgICAgb3JpZ2luOiAnaHR0cDovL2xvY2FsaG9zdDo4MDgwJywgLy8gVVJMIGRvIHNldSBMYXJhdmVsXG4gICAgICBjcmVkZW50aWFsczogdHJ1ZSxcbiAgICB9LFxuICAgIGhtcjoge1xuICAgICAgaG9zdDogJ2xvY2FsaG9zdCcsIC8vIEdhcmFudGUgcXVlIG8gSG90IE1vZHVsZSBSZXBsYWNlbWVudCAoSE1SKSBjb25lY3RlIG5vIGhvc3QgY2VydG9cbiAgICAgIG92ZXJsYXk6IHRydWUsIC8vIEV4cGxvZGUgZXJyb3MgZGUgY29tcGlsYWNhbyBuYSB0ZWxhLlxuICAgIH0sXG4gICAgd2F0Y2g6IHtcbiAgICAgIHVzZVBvbGxpbmc6IHRydWUsXG4gICAgfSxcbiAgfSxcbn0pOyovXG5cbmltcG9ydCB7IGRlZmluZUNvbmZpZywgbG9hZEVudiB9IGZyb20gJ3ZpdGUnO1xuaW1wb3J0IGxhcmF2ZWwgZnJvbSAnbGFyYXZlbC12aXRlLXBsdWdpbic7XG5pbXBvcnQgdnVlIGZyb20gJ0B2aXRlanMvcGx1Z2luLXZ1ZSc7XG5cbmV4cG9ydCBkZWZhdWx0IGRlZmluZUNvbmZpZygoeyBtb2RlIH0pID0+IHtcbiAgLy8gQ2FycmVnYSBhcyB2YXJpXHUwMEUxdmVpcyBkbyAuZW52IG5hIHJhaXogZG8gcHJvamV0b1xuICAvLyBPIHRlcmNlaXJvIHBhclx1MDBFMm1ldHJvICcnIGdhcmFudGUgcXVlIHZvY1x1MDBFQSBsZWlhIHF1YWxxdWVyIHZhcmlcdTAwRTF2ZWwgKGNvbW8gQVBQX1VSTCBvdSBQT1JUKVxuICBjb25zdCBlbnYgPSBsb2FkRW52KG1vZGUsIHByb2Nlc3MuY3dkKCksICcnKTtcblxuICAvLyBEZWZpbmUgYXMgcG9ydGFzIHBlZ2FuZG8gZG8gLmVudiBvdSB1c2FuZG8gb3MgZmFsbGJhY2tzIHBhZHJcdTAwRTNvXG4gIGNvbnN0IHZpdGVQb3J0ID0gcGFyc2VJbnQoZW52LlBPUlRBX1ZJVEUpIHx8IDUxNzM7XG4gIGNvbnN0IGFwcFVybCA9IGVudi5BUFBfVVJMIHx8ICdodHRwOi8vbG9jYWxob3N0JztcblxuICByZXR1cm4ge1xuICAgIHBsdWdpbnM6IFtcbiAgICAgIGxhcmF2ZWwoe1xuICAgICAgICBpbnB1dDogWydyZXNvdXJjZXMvY3NzL2FwcC5jc3MnLCAncmVzb3VyY2VzL2pzL2FwcC5qcyddLFxuICAgICAgICByZWZyZXNoOiB0cnVlLFxuICAgICAgfSksXG4gICAgICB2dWUoKSxcbiAgICBdLFxuICAgIHJlc29sdmU6IHtcbiAgICAgIC8vIGV4dGVuc2lvbnM6IFsnLmpzJywgJy50cycsICcuanN4JywgJy50c3gnLCAnLnZ1ZScsICcuanNvbiddLFxuICAgIH0sXG4gICAgc2VydmVyOiB7XG4gICAgICBob3N0OiAnMC4wLjAuMCcsIC8vIE1hbnRcdTAwRTltIGxpYmVyYWRvIHBhcmEgbyBEb2NrZXJcbiAgICAgIHBvcnQ6IHZpdGVQb3J0LFxuICAgICAgc3RyaWN0UG9ydDogdHJ1ZSxcbiAgICAgIFxuICAgICAgLy8gQ29uZmlndXJhIG8gQ09SUyBkaW5hbWljYW1lbnRlIGNvbSBiYXNlIG5hIFVSTCBkbyBzZXUgTGFyYXZlbCAoLmVudilcbiAgICAgIGNvcnM6IHtcbiAgICAgICAgb3JpZ2luOiBbXG4gICAgICAgICAgJ2h0dHA6Ly9sb2NhbGhvc3QnLCBcbiAgICAgICAgICAnaHR0cDovL3Npc3RlbWEubG9jYWwnXG4gICAgICAgIF0sXG4gICAgICAgIG1ldGhvZHM6IFsnR0VUJywgJ1BPU1QnLCAnUFVUJywgJ0RFTEVURScsICdPUFRJT05TJ10sXG4gICAgICAgIGFsbG93ZWRIZWFkZXJzOiBbJ0NvbnRlbnQtVHlwZScsICdBdXRob3JpemF0aW9uJywgJ1gtUmVxdWVzdGVkLVdpdGgnXSxcbiAgICAgICAgY3JlZGVudGlhbHM6IHRydWUsXG4gICAgICB9LFxuICAgICAgXG4gICAgICAvLyBIb3QgTW9kdWxlIFJlcGxhY2VtZW50IChITVIpXG4gICAgICBobXI6IHtcbiAgICAgICAgaG9zdDogJ2xvY2FsaG9zdCcsXG4gICAgICAgIHBvcnQ6IHZpdGVQb3J0LCAvLyBHYXJhbnRlIHF1ZSBvIEhNUiB1c2UgYSBtZXNtYSBwb3J0YSBkaW5cdTAwRTJtaWNhIGRvIHNlcnZpZG9yXG4gICAgICAgIG92ZXJsYXk6IHRydWUsICAvLyBFeHBsb2RlIGVycm9zIGRlIGNvbXBpbGFcdTAwRTdcdTAwRTNvIG5hIHRlbGFcbiAgICAgIH0sXG4gICAgICBcbiAgICAgIHdhdGNoOiB7XG4gICAgICAgIHVzZVBvbGxpbmc6IHRydWUsXG4gICAgICB9LFxuICAgIH0sXG4gIH07XG59KTsiXSwKICAibWFwcGluZ3MiOiAiO0FBa0NBLFNBQVMsY0FBYyxlQUFlO0FBQ3RDLE9BQU8sYUFBYTtBQUNwQixPQUFPLFNBQVM7QUFFaEIsSUFBTyxzQkFBUSxhQUFhLENBQUMsRUFBRSxLQUFLLE1BQU07QUFHeEMsUUFBTSxNQUFNLFFBQVEsTUFBTSxRQUFRLElBQUksR0FBRyxFQUFFO0FBRzNDLFFBQU0sV0FBVyxTQUFTLElBQUksVUFBVSxLQUFLO0FBQzdDLFFBQU0sU0FBUyxJQUFJLFdBQVc7QUFFOUIsU0FBTztBQUFBLElBQ0wsU0FBUztBQUFBLE1BQ1AsUUFBUTtBQUFBLFFBQ04sT0FBTyxDQUFDLHlCQUF5QixxQkFBcUI7QUFBQSxRQUN0RCxTQUFTO0FBQUEsTUFDWCxDQUFDO0FBQUEsTUFDRCxJQUFJO0FBQUEsSUFDTjtBQUFBLElBQ0EsU0FBUztBQUFBO0FBQUEsSUFFVDtBQUFBLElBQ0EsUUFBUTtBQUFBLE1BQ04sTUFBTTtBQUFBO0FBQUEsTUFDTixNQUFNO0FBQUEsTUFDTixZQUFZO0FBQUE7QUFBQSxNQUdaLE1BQU07QUFBQSxRQUNKLFFBQVE7QUFBQSxVQUNOO0FBQUEsVUFDQTtBQUFBLFFBQ0Y7QUFBQSxRQUNBLFNBQVMsQ0FBQyxPQUFPLFFBQVEsT0FBTyxVQUFVLFNBQVM7QUFBQSxRQUNuRCxnQkFBZ0IsQ0FBQyxnQkFBZ0IsaUJBQWlCLGtCQUFrQjtBQUFBLFFBQ3BFLGFBQWE7QUFBQSxNQUNmO0FBQUE7QUFBQSxNQUdBLEtBQUs7QUFBQSxRQUNILE1BQU07QUFBQSxRQUNOLE1BQU07QUFBQTtBQUFBLFFBQ04sU0FBUztBQUFBO0FBQUEsTUFDWDtBQUFBLE1BRUEsT0FBTztBQUFBLFFBQ0wsWUFBWTtBQUFBLE1BQ2Q7QUFBQSxJQUNGO0FBQUEsRUFDRjtBQUNGLENBQUM7IiwKICAibmFtZXMiOiBbXQp9Cg==
