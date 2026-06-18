import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

// Notificacao ( GLOBAL )
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

import 'bootstrap';

// Inibe o F12 e exibe um aviso no console para usuários comuns, mas apenas em produção
if (import.meta.env.MODE !== 'development') {
    const estiloTitulo = "color: red; font-size: 40px; font-weight: bold; -webkit-text-stroke: 1px black;";
    const estiloTexto = "color: #444; font-size: 16px; font-weight: 500; line-height: 1.5;";

    // 1. Limpa e exibe o aviso no console imediatamente
    console.clear(); 
    console.log("%cEspere! Não tem nada de interessante aqui.", estiloTitulo);
    

    // 2. Bloqueia o atalho F12 globalmente na janela do navegador
    window.addEventListener('keydown', (e) => {
        if (e.key === 'F12') {
            e.preventDefault();
            console.warn("Acesso ao console bloqueado por políticas de segurança.");
        }
    });
}
// -------------------------------


const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    //title: (title) => `${title} - ${appName}`,
    title: (title) => `${title}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(Toast, {
                position: "top-right", // Onde vai aparecer (ex: top-right, bottom-center)
                timeout: 3000,         // Tempo ativa (3 segundos)
                closeOnClick: true,    // Fecha se o usuário clicar em cima
                pauseOnHover: true     // Pausa o tempo se o mouse estiver em cima
            })
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
