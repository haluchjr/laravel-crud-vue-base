<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>
        <Head title="Esqueceu a Senha" />

        <div class="mb-3 text-secondary small">
            Esqueceu a senha? Sem problemas.<br>
            Informe no campo abaixo o e-mail registrado e você receberá uma nova senha temporária.
        </div>

        <div v-if="status" class="alert alert-success mb-3 text-sm" role="alert">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input
                    id="email"
                    type="email"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.email }"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />
                <div v-if="form.errors.email" class="invalid-feedback">
                    {{ form.errors.email }}
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button
                    type="submit"
                    class="btn btn-primary"
                    :class="{ 'opacity-50': form.processing }"
                    :disabled="form.processing"
                >
                    Enviar link de reset da senha
                </button>
            </div>
        </form>
    </GuestLayout>
</template>