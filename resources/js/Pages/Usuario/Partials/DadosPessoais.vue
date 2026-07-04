<script setup>

import Layout from '@/Layouts/CrudLayout.vue';
import { ref, computed, watch } from 'vue'; // Trocamos onMounted por watch
import { useForm, router } from '@inertiajs/vue3';
import debug from '@/Components/Debug.vue'; 
import { Head , usePage, Link } from '@inertiajs/vue3'
import Label from '@/Components/Label.vue';
import DangerButton from '@/Components/DangerButton.vue';
</script>

<template>
    <div class="row"> 
    <div class="col-md-12">
            <Label forId="cep">Nome</Label>
            <input type="text" class="form-control" id="cep" placeholder="Digite o Nome">
        </div>

     </div>

    <div class="row"> 
        <div class="col-md-3">
            <Label forId="cep">CPF/CNPJ</Label>
            <input type="text" class="form-control" id="cep" placeholder="Digite o CPF/CNPJ">
        </div>
        <div class="col-md-3">
            <Label forId="endereco">I.E.</Label>
            <input type="text" class="form-control" id="endereco" placeholder="Digite o I.E.">
        </div>
        
        <div class="col-md-6">
            <Label forId="numero">Email</Label>
            <input type="text" class="form-control" id="numero" placeholder="Digite o Email">
        </div>
    </div>



  <div class="row mt-3">
    <div class="col-md-12 d-flex justify-content-end">
        <button class="btn btn-sm btn-outline-success ">Salvar</button>
        aplicar mesmo comportamento da senha, ficar na mesma tela.
    </div>
</div>

</template>