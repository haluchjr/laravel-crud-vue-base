Bloquear alem de permissao.

`app/Providers/AppServiceProvider.php`


```php
// 3. Definindo o portão "deletar-usuarios"
Gate::define('deletar-usuarios', function (Usuarios $user) {
$niveisPermitidos = [99];

return in_array((int) $user->nivel, $niveisPermitidos)
    ? Response::allow()
    : Response::deny("Acesso negado:\nApenas usuários com nível 8 podem deletar.");
});
```

## Bloquear na rota: 
    `->middleware('can:deletar-usuarios')`

## NO controller:
Para usar o `Gate::authorize('deletar-usuarios')`, você o coloca logo na primeira linha do método do seu Controller.

```php
    public function destroy($id)
    {
        try{
            Gate::authorize('deletar-usuarios');
            // 1. Busca o projeto pelo ID ou estoura um erro 404 caso não encontre
            $projeto = Projeto::findOrFail($id);
            
            if ($projeto->arquivo) {
                // O Laravel já sabe que deve procurar dentro de 'storage/app/public/' por causa do disco 'public'
                Storage::disk('public')->delete($projeto->arquivo);
                }
                
                // 2. Deleta o registro do banco
                $projeto->delete();
                
                // 3. Redireciona de volta para a listagem
                // O Inertia intercepta isso, recarrega o index() e atualiza a prop 'teste1' no Vue
                return redirect()->back()->with('warning', "Registro ID {$id} excluído com sucesso!");
        } catch ( \Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back()->with('error', $e->getmessage());
        }
    }
```

Volta um FlashMessage com mensagem do gate.