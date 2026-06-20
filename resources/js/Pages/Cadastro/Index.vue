<script setup>
import { ref } from 'vue';
import { useForm,Link, router } from '@inertiajs/vue3'; // 1. Certifique-se de importar o useForm

import CrudLayout from '@/Layouts/CrudLayout.vue';
import ModalBs from '@/Components/ModalBs.vue';

import Debug from '@/Components/Debug.vue';
import { useCep } from '@/Composables/useCep';
import { useEventBus } from '@/Utils/eventBus'; // <-- IMPORTA O BUS em cada pagina que precisar.

const { emit } = useEventBus();
const props = defineProps({
    dados: Object, // se tiver dados da listagem
});
// O seu formulário do cadastro (que depois você enviará para o seu Repository)

// Modo completo e verboso.

const formulario = useForm({
    id_criptografado: props.dados?.id_criptografado || null,
    nome: props.dados?.nome || '',
    email: props.dados?.email || '',
    cep: props.dados?.cep || '',
    endereco: props.dados?.endereco || '',
    bairro: props.dados?.bairro || '',
    cidade: props.dados?.cidade || '',
    estado: props.dados?.estado || '',
    nr: props.dados?.nr || '',
    ddd_telefone: props.dados?.ddd_telefone || '',
    ddd_celular: props.dados?.ddd_celular || '',
    cpf_cnpj: props.dados?.cpf_cnpj || '',
    foto: props.dados?.foto || '',
});

// Controla situacao de imagem
// Se usuario vai upar foto preciso carregar no formulario.
const SelecionarFoto = (event) => {
    formulario.foto = event.target.files[0];
}
// Estados para controlar o modal de visualização da foto
const usuarioSelecionado = ref(null);
const exibirModalFoto = ref(false);

// Função para disparar a abertura do modal
const verFoto = (item) => {
    usuarioSelecionado.value = item; // Guarda o objeto completo do usuário
    exibirModalFoto.value = true;
};
// Fim controle de situacao de imagem.



const {buscarCepNoViaCep, erro} = useCep();
const tratarBuscaCep = async () => {
    // Só dispara se o usuário digitou os 8 caracteres mínimos
    if (cep.value.replace(/\D/g, '').length === 8) {
        
        // Chama a função global passando o CEP atual
        const dadosEndereco = await buscarCepNoViaCep(cep.value);
        
        // Se retornou os dados com sucesso, completa na tela.
        if (dadosEndereco) {
            console.log(dadosEndereco);
            formulario.cep = dadosEndereco.cep;
            formulario.endereco = dadosEndereco.endereco;
            formulario.bairro = dadosEndereco.bairro;
            formulario.cidade = dadosEndereco.cidade;
            formulario.estado = dadosEndereco.estado;
            emit('toast', { tipo: 'danger', mensagem: 'Endereço localizado!' });
        } else if (erro.value) {
            emit('toast', { tipo: 'error', mensagem: erro.value });

        }
    }
};

/* 
// Se o formulário tiver arquivos, essa é a ÚNICA alternativa que funciona sempre:
formulario.post(route('cadastro.update', { id: idFormulario }), {
    query: { _method: 'put' } 
    // Ou adicionando '_method: "PUT"' direto nos campos do seu useForm
});

*/


const enviar = () => {
    // Busca a chave correta que você declarou no useForm
    const idFormulario = formulario.id_criptografado; 
    
    if (idFormulario) {
        // Envia via POST fingindo ser PUT (Necessário para upload de arquivos no Laravel)
        formulario.transform((data) => ({
            ...data,
            _method: 'PUT',
        })).post(route('cadastro.update', idFormulario), {
            forceFormData: true,
        });
    } else {
        formulario.post(route('cadastro.store'));
    }
};

const excluir = (id) =>{
    formulario.delete(route('cadastro.destroy',{id:id}));
};

const voltarSemRastro = () => {
  router.visit(route('cadastro.list'), {
    replace: true, // Substitui a URL atual no histórico em vez de adicionar uma nova
    preserveState: true // Mantém o estado dos componentes se necessário
  })
}
</script>

<template>
    <CrudLayout>
        <Link 
        :href="route('cadastro.list')"
        class="btn btn-outline-primary btn-sm"
        >
        Tabela
        </Link>

        <button 
            v-if="formulario.id_criptografado" 
            @click="voltarSemRastro" 
            class="btn btn-outline-primary btn-sm"
        >
            Voltar
        </button>
        <form @submit.prevent="enviar" class="container mt-4">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Nome</label>
                    <input type="text" v-model="formulario.nome" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-group position-relative">
                        <label for="cep">CEP</label>
                        <input 
                            type="text" 
                            id="cep"
                            v-model="formulario.cep" 
                            @input="tratarBuscaCep"
                            class="form-control" 
                            placeholder="00000-000"
                            maxlength="8"
                        />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 mb-3">
                    <label>Endereço</label>
                    <input type="text" v-model="formulario.endereco" class="form-control" >
                </div>
                <div class="col-md-4 mb-3">
                    <label>Número</label>
                    <input type="text" id="nr" v-model="formulario.nr" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-md-5 mb-3">
                    <label>Bairro</label>
                    <input type="text" v-model="formulario.bairro" class="form-control" >
                </div>
                <div class="col-md-5 mb-3">
                    <label>Cidade</label>
                    <input type="text" v-model="formulario.cidade" class="form-control" >
                </div>
                <div class="col-md-2 mb-3">
                    <label>Estado</label>
                    <input type="text" v-model="formulario.estado" class="form-control" >
                </div>

                <div class="col-md-5 mb-3">
                    <label>Email</label>
                    <input type="text" v-model="formulario.email" class="form-control" >
                </div>
                
                <div class="col-md-3 mb-3">
                    <label>DDD Telefone Fixo</label>
                    <input type="text" v-model="formulario.ddd_telefone" class="form-control" >
                </div>

                <div class="col-md-3 mb-3">
                    <label>DDD Telefone celular</label>
                    <input type="text" v-model="formulario.ddd_celular" class="form-control" >
                </div>
                <div class="col-md-4 mb-3">
                    <label>CPF CNPJ</label>
                    <input type="text" v-model="formulario.cpf_cnpj" class="form-control" >
                </div>

                <div class="col-md-4 mb-3">
                    <label>Imagem</label>
                    <input 
                        type="file"
                        class="form-control"
                        id="foto"
                        @change="SelecionarFoto"
                        accept="image/*"
                    >

                </div>


            </div>
            <button type="submit" class="btn btn-success" @click.prevent="enviar">
                <span>{{ formulario.id_criptografado ? 'Atualizar' : 'Salvar Cadastro' }}</span>
            </button>

        </form>
        
       
       <Debug/>


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