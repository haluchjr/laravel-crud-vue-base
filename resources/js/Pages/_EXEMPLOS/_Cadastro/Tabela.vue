<script setup>
import { ref, watch } from 'vue';
import { useForm, Link, router } from '@inertiajs/vue3';

import CrudLayout from '@/Layouts/CrudLayout.vue';
import Paginacao from '@/Components/Paginacao.vue';
import ModalBs from '@/Components/ModalBs.vue';
import Debug from '@/Components/Debug.vue';

// 1. ANTES: apenas defineProps({...})
//    AGORA: guardando na constante 'props' e corrigindo o tipo de 'filtros'
const props = defineProps({
    dados: Object,
    filtros: Object, 
});

// Estados para controlar o modal de visualização da foto
const usuarioSelecionado = ref(null);
const exibirModalFoto = ref(false);

// Função para disparar a abertura do modal
const verFoto = (item) => {
    usuarioSelecionado.value = item; 
    exibirModalFoto.value = true;
};

// Agora o 'props.filtros' vai funcionar perfeitamente sem quebrar!
const busca = ref(props.filtros?.busca || '');

// Variável para controlar o tempo do debounce
let timeout = null;

watch(busca, (novoValor) => {
    clearTimeout(timeout);

    timeout = setTimeout(() => {
        router.get(
            route('cadastro.list'), 
            { busca: novoValor }, 
            { 
                preserveState: true,
                replace: true        
            }
        );
    }, 300);
});
//


// Excluir...
const exibirModalExcluir = ref(false);
const usuarioParaExcluir = ref(null);

const abrirConfirmacao = (item) => {
    usuarioParaExcluir.value = item;
    exibirModalExcluir.value = true;
};

const executarExclusao = () => {
    if (usuarioParaExcluir.value) {
        router.delete(route('cadastro.destroy', usuarioParaExcluir.value.id_criptografado), {
            onSuccess: () => {
                exibirModalExcluir.value = false;
                usuarioParaExcluir.value = null;
            }
        });
    }
};

</script>

<template>
    <CrudLayout>

    <Link 
      :href="route('cadastro.index')"
      class="btn btn-outline-primary btn-sm"
    >
    Cadastro
    </Link>

            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input 
                        v-model="busca"
                        type="text" 
                        class="form-control form-control-sm border-start-0 ps-0" 
                        placeholder="Buscar por nome, e-mail..."
                    >
                </div>
            </div>

        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Foto</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Cidade/UF</th>
                    <th>Acao</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in dados.data" :key="item.id">
                    <td>{{ item.id }}</td>
                    <td>
                        <img 
                            
                            :src="`/${item.foto}`" 
                            class="rounded-circle border" 
                            style="width: 35px; height: 35px; object-fit: cover;"
                            alt="avatar"
                        >
                    </td>
                    <td>{{ item.nome }}</td>
                    <td>{{ item.email }}</td>
                    <td>{{ item.cidade }} - {{ item.estado }}</td>
                    <td>
                        <button 
                            class="btn btn-sm btn-outline-primary me-1" 
                            @click="verFoto(item)"
                            title="Visualizar"
                        >
                            <i class="bi bi-eye"></i> 
                        </button>
                        <Link
                            class="btn btn-sm btn-outline-dark me-1" 
                            :href="route('cadastro.edit', item.id_criptografado)"
                            title="Editar"
                        >
                            <i class="bi bi-pencil"></i>
                        </Link>
                       

                        <button type="button" class="btn btn-sm btn-outline-danger" @click="abrirConfirmacao(item)">
                            <i class="bi bi-trash"></i>
                        </button>


                    </td>

                </tr>
            </tbody>
        </table>
        <Paginacao :links="dados.links" />
       <!-- <Debug/> -->


        <ModalBs 
            :show="exibirModalFoto" 
            title="Visualizar Detalhes do Cadastro" 
            @close="exibirModalFoto = false"
        >
            <div v-if="usuarioSelecionado" class="p-3">
                <div class="row">
                    <div class="col-md-4 text-center mb-3">
                        <img 
                            v-if="usuarioSelecionado.foto"
                            :src="`/${usuarioSelecionado.foto}`" 
                            class="img-fluid rounded border shadow-sm mb-2" 
                            style="max-height: 150px; width: 100%; object-fit: cover;" 
                            alt="Foto"
                        >
                        <div v-else class="text-muted p-4 border rounded bg-light">Sem foto</div>
                    </div>

                    <div class="col-md-8">
                        <h5>{{ usuarioSelecionado.nome }}</h5>
                        <p class="mb-1"><strong>E-mail:</strong> {{ usuarioSelecionado.email }}</p>
                        <p class="mb-1"><strong>CPF/CNPJ:</strong> {{ usuarioSelecionado.cpf_cnpj }}</p>
                        <p class="mb-1"><strong>Telefone:</strong> ({{ usuarioSelecionado.ddd_telefone }})</p>
                        <p class="mb-1"><strong>Celular:</strong> ({{ usuarioSelecionado.ddd_celular }})</p>
                        
                        <hr class="my-2">
                        
                        <p class="mb-1"><strong>CEP:</strong> {{ usuarioSelecionado.cep }}</p>
                        <p class="mb-1"><strong>Endereço:</strong> {{ usuarioSelecionado.endereco }}, nº {{ usuarioSelecionado.nr }}</p>
                        <p class="mb-1"><strong>Bairro:</strong> {{ usuarioSelecionado.bairro }}</p>
                        <p class="mb-0"><strong>Cidade:</strong> {{ usuarioSelecionado.cidade }} - {{ usuarioSelecionado.estado }}</p>
                    </div>
                </div>
            </div>
            
            <template #actions>
                <button type="button" class="btn btn-secondary" @click="exibirModalFoto = false">
                    Fechar
                </button>
            </template>
        </ModalBs>

        <ModalBs 
            :show="exibirModalExcluir" 
            title="Confirmar Exclusão" 
            @close="exibirModalExcluir = false"
        >
            <div class="p-3 text-center">
                <i class="bi bi-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
                <p class="mt-3">
                    Tem certeza que deseja excluir o cadastro de 
                    <strong>{{ usuarioParaExcluir?.nome }}</strong>?
                </p>
            </div>
            
            <template #actions>
                <button type="button" class="btn btn-secondary" @click="exibirModalExcluir = false">
                    Cancelar
                </button>
                <button type="button" class="btn btn-danger" @click="executarExclusao">
                    Sim, Excluir
                </button>
            </template>
        </ModalBs>

         <ModalBs 
            :show="exibirModalFoto" 
            title="Visualizar Detalhes do Cadastro" 
            @close="exibirModalFoto = false"
        >
            <div v-if="usuarioSelecionado" class="p-3">
                <div class="row">
                    <div class="col-md-4 text-center mb-3">
                        <img 
                            v-if="usuarioSelecionado.foto"
                            :src="`/${usuarioSelecionado.foto}`" 
                            class="img-fluid rounded border shadow-sm mb-2" 
                            style="max-height: 150px; width: 100%; object-fit: cover;" 
                            alt="Foto"
                        >
                        <div v-else class="text-muted p-4 border rounded bg-light">Sem foto</div>
                    </div>

                    <div class="col-md-8">
                        <h5>{{ usuarioSelecionado.nome }}</h5>
                        <p class="mb-1"><strong>E-mail:</strong> {{ usuarioSelecionado.email }}</p>
                        <p class="mb-1"><strong>CPF/CNPJ:</strong> {{ usuarioSelecionado.cpf_cnpj }}</p>
                        <p class="mb-1"><strong>Telefone:</strong> ({{ usuarioSelecionado.ddd_telefone }})</p>
                        <p class="mb-1"><strong>Celular:</strong> ({{ usuarioSelecionado.ddd_celular }})</p>
                        
                        <hr class="my-2">
                        
                        <p class="mb-1"><strong>CEP:</strong> {{ usuarioSelecionado.cep }}</p>
                        <p class="mb-1"><strong>Endereço:</strong> {{ usuarioSelecionado.endereco }}, nº {{ usuarioSelecionado.nr }}</p>
                        <p class="mb-1"><strong>Bairro:</strong> {{ usuarioSelecionado.bairro }}</p>
                        <p class="mb-0"><strong>Cidade:</strong> {{ usuarioSelecionado.cidade }} - {{ usuarioSelecionado.estado }}</p>
                    </div>
                </div>
            </div>
            
            <template #actions>
                <button type="button" class="btn btn-secondary" @click="exibirModalFoto = false">
                    Fechar
                </button>
            </template>
        </ModalBs>

    </CrudLayout>
</template>