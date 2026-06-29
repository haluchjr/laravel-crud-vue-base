# Dica inertia

```javascript
// Se o formulário tiver arquivos, essa é a ÚNICA alternativa que funciona sempre:
formulario.post(route('cadastro.update', { id: idFormulario }), {
    query: { _method: 'put' } 
    // Ou adicionando '_method: "PUT"' direto nos campos do seu useForm
});
```
