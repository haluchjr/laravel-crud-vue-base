<script setup>
import { Head, Link } from '@inertiajs/vue3';
import 'bootstrap/dist/css/bootstrap.min.css';
</script>

<template>
    <Head title="Conta em Análise" />

    <div class="container vh-100 d-flex align-items-center justify-content-center">
        <div class="card shadow border-0 p-4 text-center" style="max-width: 500px;">
            <div class="text-warning mb-3">
                <span style="font-size: 3rem;">⏳</span>
            </div>
            
            <h2 class="fw-bold text-dark mb-2">Cadastro Recebido!</h2>
            <p class="text-muted">
                Obrigado por se registrar. Sua conta foi criada com sucesso e agora está na fila para <strong>análise da administração</strong>.
            </p>
            <p class="text-muted small">
                Assim que seu acesso for liberado, você poderá entrar no sistema normalmente.
            </p>

            <div class="border-top pt-3 mt-3">
                <Link href="/login" class="btn btn-primary w-100">
                    Voltar para o Login
                </Link>
            </div>
        </div>
    </div>
</template>