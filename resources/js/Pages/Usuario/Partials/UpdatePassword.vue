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
        <p class="small text-muted mb-0">
            Certifique-se de que sua conta está usando uma senha longa e aleatória para se manter segura.
        </p>

        <form @submit.prevent="updatePassword" class="row g-3 max-width-form">
            
            <div class="row"> 
                <div class="col-md-6">
                    <label for="current_password" class="form-label ">Senha Atual</label>
                    <input 
                        id="current_password"
                        ref="currentPasswordInput"
                        type="password"
                        :class="{ 'is-invalid': form.errors.current_password }"
                        autocomplete="current-password"
                        v-model="form.current_password" class="form-control form-control-sm">

                        <span v-if=" form.errors.current_password" class="text-danger d-block small mt-1">
                            {{  form.errors.current_password }}
                        </span>
                </div>
            </div>

            <div class="row"> 
                <div class="col-md-6">
                    <label for="password" class="form-label ">Nova senha</label>
                    <input 
                       id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="form-control form-control-sm"
                        :class="{ 'is-invalid': form.errors.password }"
                        autocomplete="new-password" />

                        <span v-if=" form.errors.password" class="text-danger d-block small mt-1">
                            {{  form.errors.password }}
                        </span>

                </div>
            </div>

            <div class="row"> 
                <div class="col-md-6">
                    <label for="password" class="form-label ">Confirmar nova senha</label>
                    <input 
                        id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="form-control form-control-sm"
                    :class="{ 'is-invalid': form.errors.password_confirmation }"
                    autocomplete="new-password" />

                     <span v-if=" form.errors.password_confirmation" class="text-danger d-block small mt-1">
                            {{  form.errors.password }}
                        </span>

                </div>
            </div>
            
            <div class="col-md-12 d-flex justify-content-start">
                <button 
                    class="btn btn-sm btn-outline-success"  
                    type="submit" 
                    :disabled="form.processing" 
                    style="margin-top: 20px;"
                >
                    {{ form.processing ? 'Enviando...' : 'Salvar' }}
                </button>

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
            </div>
            
        </form>
</template>

<style scoped>
/* Opcional: Apenas para limitar a largura máxima do formulário para não esticar em telas gigantes */
.max-width-form {
    max-width: 500px;
}
</style>