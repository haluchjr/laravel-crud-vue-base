# Rotina para gerar crud.

```text
Crie o controller ( UserController) no controller vc USE o Repository.
|
repositorio (UserRepository) vinculado ao Model
|
Model ( UsuarioModel )
|
View ( Pages / Usuario /  Index e outras paginas)
```



Exemplo: CrudController
```php
use App\Repositories\UsuarioRepository;
```

Pode injetar no Construtor ou direto no metodo.
Controller:
```public function salvar(UsuarioRepository $repositorio)```

Repositorio
```public function __construct(protected UsuariosModel $usuario) { }```
```php
public function deletar($id)
    {
        try{
            $usuario = $this->usuario->find($id);
            if ($usuario) {
                $usuario->delete();
                return true;
            }
            return false;
        }catch(\Exception $e){
            // Log do erro
            Log::error('Erro ao deletar usuário: ' . $e->getMessage());
            //throw new \Exception('Erro ao deletar usuário.');
            return false;
        }
    }
```

No model>

Se garanta e use : ``` protected $table = "tb_usuarios"; ```
Assim vc garante o nome certo.

E depois soh fazer o crud, siga exemplos em Js/Pages...