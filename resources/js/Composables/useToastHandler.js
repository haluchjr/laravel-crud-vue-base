import { ref, watch, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useEventBus } from '@/Utils/eventBus';

export function useToastHandler() {
    const page = usePage();
    const { bus } = useEventBus();

    // Estados locais que o componente de Layout vai precisar expor
    const msgToast = ref('');
    const tipoToast = ref('success');

    // Mapeamento dos flashes do Laravel
    const flashSuccess = computed(() => page.props.flash?.success);
    const flashError = computed(() => page.props.flash?.error);
    const flashWarning = computed(() => page.props.flash?.warning);

    // 1. Ouvindo o Back-end (Laravel)
    watch(flashSuccess, (novoValor) => {
        if (novoValor) {
            msgToast.value = novoValor;
            tipoToast.value = 'success';
        }
    }, { immediate: true });

    watch(flashError, (novoValor) => {
        if (novoValor) {
            msgToast.value = novoValor;
            tipoToast.value = 'error';
        }
    }, { immediate: true });

    watch(flashWarning, (novoValor) => {
        if (novoValor) {
            msgToast.value = novoValor;
            tipoToast.value = 'warning';
        }
    }, { immediate: true });

    // 2. Ouvindo o Front-end (Event Bus)
    watch(bus, (current) => {
        if (current.event === 'toast') {
            msgToast.value = current.data.mensagem;
            tipoToast.value = current.data.tipo;
        }
    }, { deep: true });

    // Função de limpeza
    const limparToast = () => {
        msgToast.value = '';
        if (page.props.flash) {
            page.props.flash.success = null;
            page.props.flash.error = null;
            page.props.flash.warning = null;
        }
    };

    // Retorna tudo para o componente usar
    return {
        msgToast,
        tipoToast,
        limparToast
    };
}