<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(
    () => props.status === 'verification-link-sent',
);
</script>

<template>
    <GuestLayout>
        <Head title="Verificação de E-mail" />

        <div class="mb-3 text-secondary small">
            Obrigado por se cadastrar! Antes de começar, você poderia verificar seu endereço de e-mail 
            clicando no link que acabamos de enviar para você? Se você não recebeu o e-mail, 
            enviaremos outro com prazer.
        </div>

        <div
            class="alert alert-success mb-3 text-sm"
            role="alert"
            v-if="verificationLinkSent"
        >
            Um novo link de verificação foi enviado para o endereço de e-mail fornecido durante o cadastro.
        </div>

        <form @submit.prevent="submit">
            <div class="d-flex align-items-center justify-content-between mt-4">
                <button
                    type="submit"
                    class="btn btn-primary"
                    :class="{ 'opacity-50': form.processing }"
                    :disabled="form.processing"
                >
                    Reenviar E-mail de Verificação
                </button>

                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="btn btn-link text-decoration-underline text-secondary small p-0"
                >
                    Sair
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>