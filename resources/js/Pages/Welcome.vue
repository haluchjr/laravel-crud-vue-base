<script setup>
import CrudLayout from '@/Layouts/CrudLayoutNoMenu.vue';

defineProps({
    info: Object
});
</script>

<template>
    <CrudLayout>
        <div class="min-h-screen bg-gray-900 text-gray-100 p-8 font-sans">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-3xl font-bold mb-6 text-indigo-400 border-b border-gray-800 pb-4">
                    Infos
                </h1>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gray-800 p-6 rounded-lg shadow-md border border-gray-700">
                        <h2 class="text-xl font-semibold mb-4 text-emerald-400">Ambiente</h2>
                        <ul class="space-y-2 text-sm">
                            <li><strong>Ambiente:</strong> <span class="text-gray-400">{{ info.environment.ambiente }}</span></li>
                            <li><strong>PHP:</strong> <span class="text-gray-400">{{ info.environment.php_version }}</span></li>
                            <li><strong>Laravel:</strong> <span class="text-gray-400">{{ info.environment.laravel_version }}</span></li>
                            <li><strong>SO:</strong> <span class="text-gray-400">{{ info.environment.os }}</span></li>
                            <li><strong>Server:</strong> <span class="text-gray-400 text-xs">{{ info.environment.server_software }}</span></li>
                            <li><strong>Memory Limit:</strong> {{ info.environment.memory_limit }}</li>
                            <li><strong>Redis Ext:</strong> {{ info.environment.loaded_extensions.redis ? '✅ Ativo' : '❌ Inativo' }}</li>
                            <li><strong>Pdo Ext:</strong> {{ info.environment.loaded_extensions.pdo ? '✅ Ativo' : '❌ Inativo' }}</li>
                            <li><strong>OpenSSL Ext:</strong> {{ info.environment.loaded_extensions.openssl ? '✅ Ativo' : '❌ Inativo' }}</li>
                            <li><strong>Curl Ext:</strong> {{ info.environment.loaded_extensions.curl ? '✅ Ativo' : '❌ Inativo' }}</li>
                        </ul>
                    </div>

                    <div class="bg-gray-800 p-6 rounded-lg shadow-md border border-gray-700">
                        <h2 class="text-xl font-semibold mb-4 text-sky-400">Composer (PHP)</h2>
                        <ul class="space-y-2 text-sm">
                            <li><strong>Inertia Laravel:</strong> <span class="text-gray-400">{{ info.backend_deps.inertia_laravel }}</span></li>
                            <li><strong>Laravel Framework:</strong> <span class="text-gray-400">{{ info.backend_deps.laravel_framework }}</span></li>
                        </ul>
                    </div>

                    <div class="bg-gray-800 p-6 rounded-lg shadow-md border border-gray-700">
                        <h2 class="text-xl font-semibold mb-4 text-violet-400">NPM (JS)</h2>
                        <ul class="space-y-2 text-sm">
                            <li><strong>Vue:</strong> <span class="text-gray-400">{{ info.frontend_deps.vue }}</span></li>
                            <li><strong>Inertia Vue3:</strong> <span class="text-gray-400">{{ info.frontend_deps.inertia_vue }}</span></li>
                            <li><strong>Vite:</strong> <span class="text-gray-400">{{ info.frontend_deps.vite }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </CrudLayout>
</template>