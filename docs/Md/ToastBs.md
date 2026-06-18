# Resumo de como fica o Kit de Notificações:

Para você nunca mais se perder em quem faz o quê no projeto:

|Arquivo/Camada|	            O que ele faz?|	                                 Exemplo de Código|
| :--- | :--- | :--- |
|eventBus.js	         |   A central de rádio (memória global).	       |     Você não mexe mais aqui.|
|useToastHandler.js	    |O sintonizador (escuta o Laravel e o Front).    |	Você não mexe mais aqui.|
|ToastBs.vue	         |   A interface visual (o HTML/CSS do Bootstrap).|	    Você não mexe mais aqui.|
|Controlador             |PHP	Envia avisos pós-banco de dados.	       |     with('success', 'Salvo!')|
|Páginas Vue (Index.vue)|	Envia avisos locais via JavaScript.	            |    emit('toast', { tipo: 'warning', ... })|


Se precisar customizar, novos tipos ( Danger vindo do backend-laravel)
`-> editar somente o "useToastHander.js"`

Adicionando **WARNING**, ja existe mas pra clarear.
  
```javascript
const flashWarning = computed(() => page.props.flash?.warning);

watch(flashWarning, (novoValor) => {
    if (novoValor) {
        msgToast.value = novoValor;
        tipoToast.value = 'warning';
    }
}, { immediate: true });
```