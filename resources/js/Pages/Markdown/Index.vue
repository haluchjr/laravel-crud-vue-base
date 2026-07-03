<script setup>
import { ref } from 'vue'
import { Head, router } from '@inertiajs/vue3'
import CrudLayout from '@/Layouts/CrudLayoutNoMenu.vue';
import axios from 'axios'; // Vamos usar o axios para buscar o HTML sem mudar a URL
import debug from "@/Components/Debug.vue"

defineProps({
    docs: Array,
    user: String,
    nivel: Number
});


// Estados para controlar o Modal
const modalAberto = ref(false);
const htmlDoMarkdown = ref('');
const documentoCarregando = ref('');

// Função que busca o conteúdo e abre o modal
const abrirModal = async (nomeDoDocumento) => {
    documentoCarregando.value = nomeDoDocumento;
    try {
        // Faz uma requisição para uma rota que retorna apenas o HTML bruto (JSON)
        //const response = await axios.get("/markdown/conteudo/"+ nomeDoDocumento );
        const response = await axios.get(route('markdown.conteudo', { nomeDocumento: nomeDoDocumento }));
        htmlDoMarkdown.value = response.data.html;
        modalAberto.value = true;

        // Aplica o highlight nos códigos após o Vue renderizar o HTML
        //setTimeout(() => {
            const blocos = document.querySelectorAll('.markdown-body pre code');
            blocos.forEach((bloco) => {
                hljs.highlightElement(bloco);
            });
        //}, 30);

    } catch (error) {
        alert('Erro ao carregar o documento');
        console.error(error);
    } finally {
        documentoCarregando.value = '';
    }
};

const fecharModal = () => {
    modalAberto.value = false;
    htmlDoMarkdown.value = '';
    documentoCarregando.value = '';
};
</script>

<template>
    <CrudLayout>
        <Head title="Lista de Documentos " />
        <div class="card shadow mb-4">
            <div class="card-body">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Nome do Documento</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="doc in docs" :key="doc.nome">
                            <td><strong>{{ doc.nome }}</strong></td>
                            <td class="text-end">
                                <button @click="abrirModal(doc.nome)" class="btn btn-primary btn-sm"
                                    :disabled="documentoCarregando !== ''">
                                    {{ documentoCarregando === doc.nome ? 'Carregando...' : 'Visualizar' }}
                                </button>

                                <a :href="route('markdown.conteudo', { nomeDocumento: doc.nome })" 
           target="_blank" 
           class="btn btn-primary btn-sm">
                                    Ver
                                </a>


                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div v-if="modalAberto" class="modal-backdrop">
            <div class="modal-content" @click.stop>
                <button class="modal-close-btn" @click="fecharModal">&times;</button>
                <div class="modal-markdown-container">
                    <span class="markdown-body" v-html="htmlDoMarkdown"></span>
                </div>
            </div>
        </div>
        
        <template #sistema>Ambiente de Desenvolvimssento</template>
    </CrudLayout>
    

</template>


<style>
/* CSS do Markdown e do Modal (Juntamos tudo aqui) */
@import url('https://cdnjs.cloudflare.com/ajax/libs/github-markdown-css/5.2.0/github-markdown-dark.min.css');

.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    padding: 20px;
}

.modal-content {
    background-color: #0d1117;
    border: 1px solid #30363d;
    border-radius: 8px;
    width: 100%;
    max-width: 1300px;
    max-height: 90vh;
    overflow-y: auto;
    position: relative;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
}

.modal-close-btn {
    position: absolute;
    top: 15px;
    right: 20px;
    background: none;
    border: none;
    color: #8b949e;
    font-size: 30px;
    cursor: pointer;
    z-index: 10;
}

.modal-close-btn:hover {
    color: #f0f6fc;
}

.modal-markdown-container {
    padding: 40px;
    background-color: #0d1117;
}

.markdown-body {
    box-sizing: border-box;
    width: 95%;
    background-color: #0d1117;
}

.markdown-body h1,
.markdown-body h2,
.markdown-body h3,
.markdown-body p {
    text-align: center;
}

.markdown-body pre {
    padding: 16px !important;
    background-color: #161b22 !important;
    border: 1px solid #30363d;
    border-radius: 6px;
    text-align: left;
}
</style>