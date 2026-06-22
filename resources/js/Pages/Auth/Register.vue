<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Debug from '@/Components/Debug.vue';

import { useEventBus } from '@/Utils/eventBus'; // <-- IMPORTA O BUS em cada pagina que precisar.
const { emit } = useEventBus();


const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Cadastro" />
        <form @submit.prevent="submit">
            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input
                    id="name"
                    type="text"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.name }"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />
                <div v-if="form.errors.name" class="invalid-feedback">
                    {{ form.errors.name }}
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input
                    id="email"
                    type="email"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.email }"
                    v-model="form.email"
                    required
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
                    autocomplete="new-password"
                />
                <div v-if="form.errors.password" class="invalid-feedback">
                    {{ form.errors.password }}
                </div>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirme a senha</label>
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

            <div class="d-flex align-items-center justify-content-end mt-4 gap-3">
                <Link
                    :href="route('login')"
                    class="text-decoration-underline text-secondary small"
                >
                    Já está registrado?
                </Link>

                <button
                    type="submit"
                    class="btn btn-primary"
                    :class="{ 'opacity-50': form.processing }"
                    :disabled="form.processing"
                >
                    Cadastrar
                </button>
            </div>
        </form>
    </GuestLayout>
</template>