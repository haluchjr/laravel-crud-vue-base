<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Perfil" />

    <GuestLayout>
        

         <div class="mb-3">

                <UpdatePasswordForm class="max-w-xl" />
                </div>

    </GuestLayout>
</template>
