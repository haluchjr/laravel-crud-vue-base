<script setup>

import { ref, computed, watch } from 'vue'; // Trocamos onMounted por watch
import { useForm, router } from '@inertiajs/vue3';
import debug from '@/Components/Debug.vue'; 
import { Head , usePage, Link } from '@inertiajs/vue3'
import Label from '@/Components/Label.vue';
import btnsalvar from "@/Components/BtnSalvar.vue"

import Checkbox from '@/Components/Checkbox.vue'

import { mask } from 'vue-the-mask';
const page = usePage()
const permissoes = computed(() => page.props.auth.user.permissoes)
const somenteLeitura = computed(() => !permissoes.value.salvar);

const props = defineProps({
    dados_pessoais: Object, // se tiver dados da listagem
});

const vMask = mask;
const documentoMasks = ['###.###.###-##', '##.###.###/####-##'];

const form = useForm({
    id : props.dados_pessoais.id,
    nome : props.dados_pessoais.name ??'',
    cpf_cnpj : props.dados_pessoais.cpf_cnpj ?? '',
    ie : props.dados_pessoais.ie ?? '',
    email : props.dados_pessoais.email ?? '',
    telefonefixo : props.dados_pessoais.telefonefixo ?? '',
    telefonecel : props.dados_pessoais.telefonecel ?? ''
});

const enviar = () => {
     form.post(route('usuario.ajustes.salvarPessoais'));
};
</script>

<template>
    <form @submit.prevent="enviar" class="container mt-4">
    <fieldset :disabled="somenteLeitura">
        <div class="row"> 
            <div class="col-md-9">
                <Label forId="cep">Nome</Label>
                <input type="text" v-model="form.nome" class="form-control form-control-sm" id="cep" placeholder="Digite o Nome">
            </div>

            <div class="col-md-3">
                <Label forId="cep">CPF/CNPJ</Label>
                <input type="text" v-model="form.cpf_cnpj" v-mask="documentoMasks" class="form-control form-control-sm" id="cep" placeholder="Digite o CPF/CNPJ">
            </div>
        </div>

        <div class="row"> 
            <div class="col-md-2">
                <Label forId="endereco">I.E.</Label>
                <input type="text" v-model="form.ie" class="form-control form-control-sm" id="endereco" placeholder="Digite o I.E.">
            </div>
            
            <div class="col-md-4">
                <Label forId="numero">Email</Label>
                <input type="text" v-model="form.email"  class="form-control form-control-sm" id="numero" placeholder="Digite o Email">
            </div>
            
            <div class="col-md-3">
                <Label forId="fone">Telefone Fixo</Label>
                <input type="text" v-model="form.telefonefixo"  v-mask="'## ####-####'" class="form-control form-control-sm" id="telefoneFixo">
            </div>
            
            <div class="col-md-3">
                <Label forId="celular">Telefone Celular</Label>
                <input type="text" v-model="form.telefonecel" v-mask="'## #####-####'" class="form-control form-control-sm" id="celular">
            </div>

        </div>
        <span v-if="permissoes.salvar">
            <div class="row mt-3">
                <div class="col-md-12 d-flex justify-content-start">
                    <btnsalvar>Salvar</btnsalvar>
                </div>
            </div>
        </span>
    </fieldset>
</form>
</template>