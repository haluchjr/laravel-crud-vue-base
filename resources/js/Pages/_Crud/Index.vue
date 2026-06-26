<script setup>
import { ref, computed } from 'vue';
import { router, useForm,usePage} from '@inertiajs/vue3'; 

import CrudLayout from '@/Layouts/CrudLayout.vue';
//import FlashMessage from '@/Components/FlashMessage.vue';
import ModalBootstrap from '@/Components/ModalBs.vue';
import Paginacao from '@/Components/Paginacao.vue';
import Status from '@/Components/Status.vue'; 
import Debug from '@/Components/Debug.vue';
// ==========================================
// PROPS (Definição Única com o padrão Vue 3.5)
// ==========================================
// Desestruturamos 'retorno' direto. No Vue 3.5, ele continua 100% reativo.
const { retorno } = defineProps({
    retorno: {
        type: Object,
        required: true
    }
});

// Iniciamos o formulário do Inertia com os campos vazios
const form = useForm({
    id: null,
    nome: '',
    status: '',
    arquivo: null,
});

const page = usePage();
// Captura o nível do usuário logado direto do compartilhamento global do Inertia
const nivelUsuario = computed(() => page.props.auth.user?.nivel);

// Uma função simples para checar permissões no template
const isAdmin = computed(() => nivelUsuario.value === 'admin');

// ==========================================
// POLLING (Atualização em Tempo Real)
// ==========================================
/*
let atualizarProjetosInterval = null;

onMounted(() => {
    // Fica recarregando os dados da página a cada 5 segundos
    atualizarProjetosInterval = setInterval(() => {
        router.reload({ 
            only: ['retorno'], 
            preserveScroll: true 
        });
    }, 5000);
});

onUnmounted(() => {
    clearInterval(atualizarProjetosInterval);
});
*/

// ==========================================
// ESTADO E FUNÇÕES: CADASTRO (NOVO)
// ==========================================
const modalCadastrarAberto = ref(false);

const abrirModalCadastro = () => {
    form.reset();
    form.id = null;
    form.nome = '';
    form.status = 'ativo';
    form.arquivo = null;
    modalCadastrarAberto.value = true;
};

const salvarCadastro = () => {
    form.post('/crud', {
        onSuccess: () => {
            modalCadastrarAberto.value = false;
            form.reset();
        },
        onError: (errors) => {
            console.error('Erro ao cadastrar:', errors);
        }
    });
};

// ==========================================
// ESTADO E FUNÇÕES: EXCLUSÃO
// ==========================================
const modalAberto = ref(false);
const idSelecionado = ref(null);
const nomeSelecionado = ref('');

const abrirModalExclusao = (projeto) => {
    idSelecionado.value = projeto.id;
    nomeSelecionado.value = projeto.nome;
    modalAberto.value = true;
};

const confirmarExclusao = () => {
    if (!idSelecionado.value) return;

    router.delete(`/crud/${idSelecionado.value}`, {
        onSuccess: () => {
            modalAberto.value = false;
            idSelecionado.value = null;
            nomeSelecionado.value = '';
        },
        onError: (errors) => {
            console.error('Erro ao excluir:', errors);
        }
    });
};

// ==========================================
// ESTADO E FUNÇÕES: EDIÇÃO
// ==========================================
const modalEditarAberto = ref(false);
const urlImagemAtual = ref(null);

const abrirModalEdicao = (projeto) => {
    form.id = projeto.id;
    form.nome = projeto.nome;
    form.status = projeto.status;
    form.arquivo = null;

    if (projeto.arquivo) {
        urlImagemAtual.value = `/storage/${projeto.arquivo}`;
    } else {
        urlImagemAtual.value = null;
    }

    modalEditarAberto.value = true;
};

const salvarEdicao = () => {
    router.post(`/crud/${form.id}`, {
        _method: 'PUT',
        nome: form.nome,
        status: form.status,
        arquivo: form.arquivo,
    }, {
        onSuccess: () => {
            modalEditarAberto.value = false;
            form.reset();
        },
        onError: (errors) => {
            form.setErrors(errors);
        }
    });
};


</script>

<template>
    <CrudLayout title="CRUD">
        <template #header>
            <h1 class="h3 mb-0">Listagem de Projetos</h1>
        </template>
       
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-primary">Registros no Banco</h6>
                <button class="btn btn-sm btn-primary" @click="abrirModalCadastro">
                    <i class="bi bi-plus-lg me-1"></i>
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="table-layout: fixed; width: 100%;">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 10%;">ID</th>
                                <th style="width: 40%;">Nome do Projeto</th>
                                <th style="width: 15%;">Status</th>
                                <th style="width: 10%;">Criado Em</th>
                                <th class="text-end" style="width: 15%;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="projeto in retorno.data" :key="projeto.id" :class="{ 'table-danger text-danger-emphasis fw-semibold': projeto.vencido }">
                                <td class="fw-bold">#{{ projeto.id }}</td>
                                <td class="text-truncate" :title="projeto.nome">{{ projeto.nome }}</td>
                                <td>
                                    <Status :type="projeto.vencido ? 'vencido' : projeto.status" />
                                </td>
                                <td class="text-muted small">{{ projeto.data_br}}</td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-primary me-2 meu-tooltip" data-tooltip="Editar" @click="abrirModalEdicao(projeto)">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger meu-tooltip" data-tooltip="Excluir" @click="abrirModalExclusao(projeto)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="retorno.data.length === 0">
                                <td colspan="5" class="text-center text-muted py-4">Nenhum registro encontrado.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <Paginacao :links="retorno.links" />

        </div>

        <ModalBootstrap :show="modalAberto" title="Confirmar Exclusão" @close="modalAberto = false">
            <p>Tem certeza que deseja excluir o projeto <strong>"{{ nomeSelecionado }}"</strong>?</p>
            <template v-slot:actions>
                <button type="button" class="btn btn-light" @click="modalAberto = false">Cancelar</button>
                <button type="button" class="btn btn-danger" @click="confirmarExclusao">Confirmar Exclusão</button>
            </template>
        </ModalBootstrap>

        <ModalBootstrap :show="modalEditarAberto" title="Editar Projeto" @close="modalEditarAberto = false">
            <form @submit.prevent="salvarEdicao">
                <div class="mb-3">
                    <label class="form-label fw-bold">Nome do Projeto</label>
                    <input type="text" class="form-control" v-model="form.nome" required>
                    <div v-if="form.errors.nome" class="text-danger small mt-1">{{ form.errors.nome }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <select class="form-select" v-model="form.status" required>
                        <option value="ativo">Ativo</option>
                        <option value="inativo">Inativo</option>
                    </select>
                    <div v-if="form.errors.status" class="text-danger small mt-1">{{ form.errors.status }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Substituir Imagem/Documento</label>
                    <input type="file" class="form-control" :class="{ 'is-invalid': form.errors.arquivo }"
                        @change="form.arquivo = $event.target.files[0]">
                    <div v-if="form.errors.arquivo" class="invalid-feedback">{{ form.errors.arquivo }}</div>

                    <div v-if="urlImagemAtual" class="mt-3">
                        <p class="small text-muted mb-1">Imagem Atual:</p>
                        <img :src="urlImagemAtual" alt="Preview" class="img-thumbnail object-fit-cover shadow-sm"
                            style="width: 100px; height: 100px;">
                    </div>
                </div>
            </form>

            <template v-slot:actions>
                <button type="button" class="btn btn-light" @click="modalEditarAberto = false">Cancelar</button>
                <button type="button" class="btn btn-primary" :disabled="form.processing" @click="salvarEdicao">
                    {{ form.processing ? 'Salvando...' : 'Salvar Alterações' }}
                </button>
            </template>
        </ModalBootstrap>

        <ModalBootstrap :show="modalCadastrarAberto" title="Cadastrar Novo Projeto"
            @close="modalCadastrarAberto = false">
            <form @submit.prevent="salvarCadastro">
                <div class="mb-3">
                    <label class="form-label fw-bold">Nome do Projeto</label>
                    <input type="text" class="form-control" v-model="form.nome" required
                        placeholder="Digite o nome do projeto...">
                    <div v-if="form.errors.nome" class="text-danger small mt-1">{{ form.errors.nome }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Status Inicial</label>
                    <select class="form-select" v-model="form.status" required>
                        <option value="ativo">Ativo</option>
                        <option value="inativo">Inativo</option>
                    </select>
                    <div v-if="form.errors.status" class="text-danger small mt-1">{{ form.errors.status }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Imagem ou Documento do Projeto</label>
                    <input type="file" class="form-control" :class="{ 'is-invalid': form.errors.arquivo }"
                        @change="form.arquivo = $event.target.files[0]">
                    <div v-if="form.errors.arquivo" class="invalid-feedback">{{ form.errors.arquivo }}</div>
                </div>
            </form>

            <template v-slot:actions>
                <button type="button" class="btn btn-light" @click="modalCadastrarAberto = false">Cancelar</button>
                <button type="button" class="btn btn-success" :disabled="form.processing" @click="salvarCadastro">
                    {{ form.processing ? 'Gravando...' : 'Salvar Projeto' }}
                </button>
            </template>
        </ModalBootstrap>

        <!-- <Debug/> -->
        <template #sistema>Ambiente de Desenvolvimento</template>
    </CrudLayout>
</template>