<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm , Link} from '@inertiajs/vue3';
import { ref } from 'vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <section class="card shadow-sm p-4">
        <header class="mb-4">
            <h2 class="h5 fw-bold text-dark mb-1">
                Atualizar senha
            </h2>
            <p class="small text-muted mb-0">
                Certifique-se de que sua conta está usando uma senha longa e aleatória para se manter segura.
            </p>
        </header>

        <form @submit.prevent="updatePassword" class="row g-3 max-width-form">
            <div class="col-12">
                <InputLabel for="current_password" value="Senha atual" class="form-label fw-semibold small text-secondary" />
                
                <TextInput
                    id="current_password"
                    ref="currentPasswordInput"
                    v-model="form.current_password"
                    type="password"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.current_password }"
                    autocomplete="current-password"
                />

                <InputError
                    :message="form.errors.current_password"
                    class="invalid-feedback d-block"
                />
            </div>

            <div class="col-12">
                <InputLabel for="password" value="Nova senha" class="form-label fw-semibold small text-secondary" />

                <TextInput
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.password }"
                    autocomplete="new-password"
                />

                <InputError :message="form.errors.password" class="invalid-feedback d-block" />
            </div>

            <div class="col-12">
                <InputLabel
                    for="password_confirmation"
                    value="Confirmar nova senha"
                    class="form-label fw-semibold small text-secondary"
                />

                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.password_confirmation }"
                    autocomplete="new-password"
                />

                <InputError
                    :message="form.errors.password_confirmation"
                    class="invalid-feedback d-block"
                />
            </div>

            <div class="col-12 d-flex align-items-center gap-3 pt-2">
                <PrimaryButton :disabled="form.processing" class="btn btn-primary px-4">
                    Salvar
                </PrimaryButton>

                <Transition
                    enter-active-class="translate duration-300 ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="translate duration-300 ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="small text-success fw-medium mb-0 me-auto animate-fade"
                    >
                        <i class="bi bi-check-circle-fill me-1"></i> Salvo.
                    </p>
                </Transition>

                <Link 
                    :href="route('usuario.index')" 
                    class="btn btn-link link-primary p-0 text-decoration-none small fw-medium ms-auto">
                    Voltar para o sistema <span aria-hidden="true">&rarr;</span>
                </Link>
            </div>
        </form>
    </section>
</template>

<style scoped>
/* Opcional: Apenas para limitar a largura máxima do formulário para não esticar em telas gigantes */
.max-width-form {
    max-width: 500px;
}
</style>