<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import Debug from '@/Components/Debug.vue';

import { useEventBus } from '@/Utils/eventBus'; // <-- IMPORTA O BUS em cada pagina que precisar.
const { emit } = useEventBus();

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Acessar Sistema" />
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

            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input
                    id="password"
                    type="password"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.password }"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />
                <div v-if="form.errors.password" class="invalid-feedback">
                    {{ form.errors.password }}
                </div>
            </div>

            <div class="mb-3 form-check">
                <input
                    id="remember"
                    type="checkbox"
                    class="form-check-input"
                    v-model="form.remember"
                />
                <label class="form-check-label" for="remember">Lembrar-me</label>
            </div>

            <div class="d-flex align-items-center justify-content-between mt-4">
                <div>
                    <Link
                        :href="route('register')"
                        class="text-decoration-underline text-secondary small"
                    >
                        Criar Conta
                    </Link>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="text-decoration-underline text-secondary small"
                    >
                        Esqueceu a senha?
                    </Link>

                    <button
                        type="submit"
                        class="btn btn-primary"
                        :class="{ 'opacity-50': form.processing }"
                        :disabled="form.processing"
                    >
                        Entrar
                    </button>
                </div>
            </div>
        </form>
    </GuestLayout>
</template>