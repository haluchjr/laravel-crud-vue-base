<script setup>
defineProps({
    show: {
        type: Boolean,
        required: true
    },
    title: {
        type: String,
        default: 'Confirmação'
    }
});

defineEmits(['close']);
</script>

<template>
    <div v-if="show" class="meu-modal-wrapper">
        <div class="meu-modal-backdrop" @click="$emit('close')"></div>
        
        <div class="modal-dialog modal-dialog-centered meu-modal-caixa">
            <div class="modal-content shadow-lg bg-white rounded">
                
                <div class="modal-header p-3 border-bottom">
                    <h5 class="modal-title fw-bold m-0">{{ title }}</h5>
                    <button type="button" class="btn-close" @click="$emit('close')" aria-label="Close"></button>
                </div>

                <div class="modal-body p-3">
                    <slot></slot>
                </div>

                <div class="modal-footer p-3 bg-light border-top" v-if="$slots.actions">
                    <slot name="actions"></slot>
                </div>

            </div>
        </div>
    </div>
</template>

<style scoped>
.meu-modal-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1050;
}

.meu-modal-backdrop {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1;
}

.meu-modal-caixa {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 500px;
    margin: 20px;
}
</style>