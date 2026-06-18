<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3'; // 1. Certifique-se de importar o useForm

import CrudLayout from '@/Layouts/CrudLayoutNoMenu.vue';
import Paginacao from '@/Components/Paginacao.vue';
import Debug from '@/Components/Debug.vue';
import { useCep } from '@/Composables/useCep';

import { useToast } from "vue-toastification";
const toast = useToast();

defineProps({
    dados: Object,
});
// O seu formulário do cadastro (que depois você enviará para o seu Repository)

// Modo completo e verboso.
const formulario = useForm({
    id: null,
    nome: '',     email: '',    cep: '',    endereco: '',    bairro: '',    cidade: '',
    estado: '',    nr: '',    ddd_telefone: '',    ddd_celular: '',    cpf_cnpj: '',
});

const dadosForm = (item) => {
    formulario.id = item.id;
    formulario.nome = item.nome;
    formulario.email = item.email;
    formulario.cep = item.cep;
    formulario.endereco = item.endereco;
    formulario.bairro = item.bairro;
    formulario.cidade = item.cidade;
    formulario.estado = item.estado;
    formulario.nr = item.nr;
    formulario.ddd_telefone = item.ddd_telefone;
    formulario.ddd_celular = item.ddd_celular;
    formulario.cpf_cnpj = item.cpf_cnpj;
};


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
        } else if (erro.value) {
            toast.error(erro.value);
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
    const idFormulario = formulario.data().id;
    if (idFormulario) {
        formulario.put(route('cadastro.update', { id: idFormulario }));
    } else {
        formulario.post(route('cadastro.store'));
    };
}

const excluir = (id) =>{
    formulario.delete(route('cadastro.destroy',{id:id}));
};

</script>

<template>
    <CrudLayout>
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

            </div>
            <button type="submit" class="btn btn-success" @click.prevent="enviar">
                <span>{{ formulario.id ? 'Atualizar' : 'Salvar Cadastro' }}</span>
            </button>
        </form>
        <hr>
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Cidade/UF</th>
                    <th>Acao</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in dados.data" :key="item.id">
                    <td>{{ item.id }}</td>
                    <td>{{ item.nome }}</td>
                    <td>{{ item.email }}</td>
                    <td>{{ item.cidade }} - {{ item.estado }}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-danger" @click="excluir(item.id)">Excluir</button>
                        <button class="btn btn-sm btn-outline-warning" @click="dadosForm(item)">Editar</button>
                    </td>

                </tr>
            </tbody>
        </table>
        <Paginacao :links="dados.links" />
       <!-- <Debug/> -->
    </CrudLayout>
</template>