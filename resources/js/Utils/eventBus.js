import { ref } from 'vue';

const bus = ref({ event: '', data: null });

export const useEventBus = () => {
    const emit = (event, data) => {
        bus.value = { event, data, timestamp: Date.now() }; // timestamp força o watch a disparar sempre
    };

    return { bus, emit };
};