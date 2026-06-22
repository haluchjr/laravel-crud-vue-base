<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Nova Senha" />

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

            <div class="mb-3">
                <label for="password" class="form-label">Nova Senha</label>
                <input
                    id="password"
                    type="password"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.password }"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />
                <div v-if="form.errors.password" class="invalid-feedback">
                    {{ form.errors.password }}
                </div>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                <input
                    id="password_confirmation"
                    type="password"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.password_confirmation }"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />
                <div v-if="form.errors.password_confirmation" class="invalid-feedback">
                    {{ form.errors.password_confirmation }}
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button
                    type="submit"
                    class="btn btn-primary"
                    :class="{ 'opacity-50': form.processing }"
                    :disabled="form.processing"
                >
                    Redefinir Senha
                </button>
            </div>
        </form>
    </GuestLayout>
</template>