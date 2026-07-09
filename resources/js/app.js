import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import 'bootstrap';

import { initConsoleSecurity } from './Utils/noF12';
import { initGlobalLogger, sendErrorToLaravel } from './Utils/logger-front';

// Inicializa o logger global para capturar erros JavaScript
initGlobalLogger();

// Inicializa a segurança do console
// initConsoleSecurity();

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    //title: (title) => `${title} - ${appName}`,
    title: (title) => `${title}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob([
                './Pages/**/*.vue',
                '!./Pages/_EXEMPLOS'
            ]),
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        app.config.errorHandler = (err, instance, info) => {

            sendErrorToLaravel({
                message: `[Vue Error] ${err.message || err}`,
                url: window.location.href,
                line: 0,
                column: 0,
                stack: err.stack || info
            });

           console.error(err);
        };

        return app
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
