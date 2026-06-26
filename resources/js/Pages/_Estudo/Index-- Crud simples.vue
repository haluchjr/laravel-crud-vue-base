<script setup>
import { ref ,computed} from 'vue'
import { usePage, Head , useForm} from '@inertiajs/vue3';


const form = useForm({
    // Define your form fields here
    nome: '',
    email: '',
});

const inertiaPage = usePage();
const flashProps = computed(() => inertiaPage.props.flash);
const idSelecionado = ref(null);

// post
/*Forma classica */
function envia1r() {
    form.post(route('estudo.teste.salvar'), {
        onSuccess: () => {
            console.log('Formulário enviado com sucesso!');
            form.reset(); // Limpa o formulário após o envio bem-sucedido
        },
        onError: (errors) => {
            console.error('Erro ao enviar formulário:', errors);
        },
    });
}


const enviar = () => {
    form.post(route('crud.teste.insert.salvar'), {
        onSuccess: () => {
            console.log('Formulário enviado com sucesso!');
            form.reset(); // Limpa o formulário após o envio bem-sucedido
        },
        onError: (errors) => {
            console.error('Erro ao enviar formulário:', errors);
        },
    });
};

const deletar = (id) =>{
    form.post(route('crud.teste.delete', { id: id }), {
        onSuccess: () => {
            console.log('Registro deletado com sucesso!');
            idSelecionado.value = null;
        },
        onError: (errors) => {
            console.error('Erro ao deletar registro:', errors);
        },
    });
}

// Nova função para limpar o estado caso o usuário desista
const cancelarEdicao = () => {
    idSelecionado.value = null;
    form.reset();
}

const editar = (item) =>{
    idSelecionado.value= item.id;
    form.nome = item.nome;
    form.email = item.email;
}

const atualizar = () => {
    form.post(route('crud.teste.update', { id: idSelecionado.value }), {
        onSuccess: () => {
            console.log('Registro atualizado com sucesso!');
            form.reset(); // Limpa o formulário após o envio bem-sucedido
            idSelecionado.value = null; // Limpa o ID selecionado
        },
        onError: (errors) => {
            console.error('Erro ao atualizar registro:', errors);
        },
    });
};
</script>

<template>
<Head title=""/>

<input type="text" v-model="form.nome" placeholder="Digite seu nome" /><br>
<span v-if="form.errors.nome" class="error-msg">{{ form.errors.nome }}</span>
<input type="text" v-model="form.email" placeholder="Digite seu email" /><br>
<span v-if="form.errors.email" class="error-msg">{{ form.errors.email }}</span>
<br>
<button v-if="!idSelecionado" @click="enviar">Enviar</button>
<div v-else class="botoes-edicao">
    <button @click="atualizar" class="btn-update">Salvar Alterações</button>
    <button @click="cancelarEdicao" class="btn-cancelar">Cancelar</button>
</div>
<br>

<!-- <pre>{{ $page }}</pre> -->
<!-- <pre>{{ flashProps }}</pre> -->

<hr>
<ul>
    <li v-for="(item, index) in $page.props.dados" :key="item.id" :class="{ 'em-edicao': item.id === idSelecionado }">
       <button @click="deletar(item.id)">Deletar</button><button @click="editar(item)">Editar</button> {{item.id}} {{ item.nome }} - {{ item.email }} -> 
       <!-- <pre>{{ item }}</pre> -->
    </li>
</ul>


</template>

<style scoped>

button {
    background-color: #4f46e5; /* Azul moderno (estilo Tailwind/Bootstrap) */
    color: white;
    padding: 0.2rem 1.55rem;

    border: none;
    border-radius: 0.375rem; /* Cantos arredondados suaves */
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.2s ease; /* Transição suave na cor */
}

/* Efeito ao passar o mouse por cima */
button:hover {
    background-color: #4338ca; /* Um azul um pouco mais escuro */
}

/* Estado desabilitado (quando form.processing for true) */
button:disabled {
    background-color: #a5b4fc; /* Azul bem clarinho/apagado */
    cursor: not-allowed; /* Muda o ponteiro do mouse para indicar bloqueio */
}

/* Destaca a linha que está sendo editada atualmente */
li.em-edicao {
    background-color: #f3f4f6;
    border-left: 4px solid #4f46e5;
    padding-left: 5px;
}

.botoes-edicao {
    display: flex;
    gap: 10px;
}

.btn-cancelar {
    background-color: #ef4444; /* Vermelho para o cancelar */
}
.btn-cancelar:hover {
    background-color: #dc2626;
}
</style>