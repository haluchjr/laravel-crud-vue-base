<script setup>

import Layout from '@/Layouts/CrudLayout.vue';
import { ref, computed, watch } from 'vue'; // Trocamos onMounted por watch
import { useForm, router } from '@inertiajs/vue3';

import debug from '@/Components/Debug.vue'; 
import { Head , usePage, Link } from '@inertiajs/vue3'
import Label from '@/Components/Label.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { useEventBus } from '@/Utils/eventBus'; // <-- IMPORTA O BUS em cada pagina que precisar.
const { emit } = useEventBus(); // Só usar se tiver algo q aconteça na tela.

const props = defineProps({
    tipos_enderecos: Array,
    enderecos_cadastrados: Array,
    endereco_editado: Object,
});

const form = useForm({
    id: '',
    apelido: '',
    tipo_endereco_id: '',
    cep: '',
    endereco: '',
    numero: '',
    bairro: '',
    cidade: '',
    estado: ''
});

const carregando = ref(false);
const buscarCep = async () => {
    
    // Remove traços ou espaços para validar o tamanho
    const cepLimpo = form.cep.replace(/\D/g, '');
    
    if (cepLimpo.length === 8) {
        emit('toast', { tipo: 'success', mensagem: 'Endereço localizado!' });
        try {
            const response = await axios.get(`https://viacep.com.br/ws/${cepLimpo}/json/`);
           
            if (response.data) {
                    form.cep = cepLimpo;
                    form.endereco = response.data.logradouro;
                    form.bairro = response.data.bairro;
                    form.cidade = response.data.localidade;
                    form.estado = response.data.uf;
            }
        } catch (error) {
            console.error("Erro ao buscar CEP:", error);
            alert('CEP não encontrado ou inválido.');
            emit('toast', { tipo: 'danger', mensagem: 'Endereço não localizado!' });
        } finally {
            carregando.value = false;
        }
    }
};


// Salvar.
const enviar = () => {
     form.post(route('usuario.ajustes.salvar'));
     /*
    form.post(route('usuario.ajustes.salvar'), {
        onSuccess: () => {
            //emit('toast', { tipo: 'success', mensagem: 'Salvo com sucesso!' });
            form.reset(); // Limpa o formulário após o envio bem-sucedido
        },
        onError: (errors) => {
            console.error('Erro ao enviar formulário:', errors);
            //emit('toast', { tipo: 'danger', mensagem: 'Erro ao salvar!' });
        },
    });*/
};
const excluirEndereco = (id) => {
       router.delete(route('usuario.ajustes.excluirEndereco', id));
}

const editarEnderecoSelecionado = (id) => {
    //router.get(route('usuario.ajustes.editarEndereco', id));
    
    router.reload({
        only: ['endereco_editado'], 
        data: { enderecoId: id }, 
    });
}

watch(
    () => props.endereco_editado,
    (novo) => {
        console.log('WATCH', novo);
        form.id = novo.id;
        form.apelido = novo.apelido;
        form.bairro = novo.bairro;
        form.cidade = novo.cidade;
        form.estado = novo.estado;
        form.numero = novo.numero;
        form.tipo_endereco_id = Number(novo.tipo_endereco_id);
        form.endereco = novo.endereco;
        form.cep = novo.cep;
    },
    { immediate: true }
);
</script>

<template>
    <!-- <debug/> -->
<div id="master">
    <div class="row"> 
        <div class="col-md-9 ">
            <Label forId="cep">Apelido para este endereço</Label>
            <input type="text" v-model="form.apelido" class="form-control form-control-sm" id="cep">
            
        </div>

        <div class="col-md-3">
            <Label forId="cep">Tipo endereço</Label>
            <select class="form-select form-select-sm" id="tipo_endereco" v-model="form.tipo_endereco_id">
                <option value="">-</option>
                <option v-for="tipo in tipos_enderecos" :key="tipo.id" :value="tipo.id">
                    {{ tipo.descricao }}
                </option>
            </select>
        </div>

    </div>

    <div class="row"> 
        <div class="col-md-3">
            <Label forId="cep">CEP</Label>
            <input type="text"  @change="buscarCep" v-model="form.cep" class="form-control form-control-sm" id="cep" >
        </div>
        <small v-if="carregando" class="text-dark">
            Buscando...
        </small>
        <div class="col-md-6">
            <Label forId="endereco">Endereço</Label>
            <input type="text" v-model="form.endereco" class="form-control form-control-sm" id="endereco" >
        </div>
        
        <div class="col-md-3">
            <Label forId="numero">Número</Label>
            <input type="text" v-model="form.numero" class="form-control form-control-sm" id="numero" >
        </div>
    </div>

    <div class="row"> 
        <div class="col-md-3">
            <Label forId="bairro">Bairro</Label>
            <input type="text" v-model="form.bairro" class="form-control form-control-sm" id="bairro" >
        </div>
        <div class="col-md-6">
            <Label forId="cidade">Cidade</Label>
            <input type="text" v-model="form.cidade" class="form-control form-control-sm" id="cidade">
        </div>
        
        <div class="col-md-3">
            <Label forId="estado">Estado</Label>
            <input type="text" v-model="form.estado" class="form-control form-control-sm" id="estado">
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 d-flex justify-content-start">
            <button class="btn btn-sm btn-outline-success " @click="enviar">Salvar</button>
            
        </div>
    </div>
    <span v-if="form.errors" class="text-danger d-block small mt-1">
        <ul>
            <li v-for="(error, index) in form.errors" :key="index">{{ error }}</li>
        </ul>

    </span>
    <hr>
    <table class="table table-striped table-sm" ><thead>
        <tr>
            <th>Apelido</th>
            <th>Tipo</th>
            <th>Ação</th>
        </tr></thead>
        <tbody>
        <tr v-for="linha in enderecos_cadastrados" :key="linha.id">
            <td>
                {{ linha.apelido }}</td>
            <td>{{ linha.descricao}}</td>
            <td >
                <button class="btn btn-sm btn-outline-primary me-2 meu-tooltip" data-tooltip="Editar" @click="editarEnderecoSelecionado(linha.id)">
                    <i class="bi bi-pencil-square"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger meu-tooltip" data-tooltip="Excluir" @click="excluirEndereco(linha.id)">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</template>