# Brincando com o Cache

```php
// Cache
use Illuminate\Support\Facades\Cache;
use App\Models\User;
// Cache
use Illuminate\Support\Facades\Cache;
use App\Models\Usuarios;
Route::get('/teste-cache', function () {
    
    // Tenta buscar 'total_usuarios' no Redis. 
    // Se não achar, roda a função, conta os usuários no banco, salva por 10 segundos e retorna.
    $usuarios = Cache::remember('total_usuarios', 10, function () {
        logger('O cache estava vazio! Executando a query no banco...');
        return Usuarios::count(); 
    });

    return "Total de usuários no sistema: " . $usuarios;

});
```

    
## ou didatico sem closures.

> Como funciona essa sintaxe [$this, 'metodo']?<br>
> Você está dizendo para o Laravel: "Se o cache estiver vencido, <br>
> execute o método chamado contarUsuariosDoBanco que está dentro desta mesma classe ($this)". 

## Na sua rota ou Controller:

```php
$usuarios = Cache::remember('total_usuarios', 10, [$this, 'contarUsuariosDoBanco']);
// ... e você cria o método logo abaixo na mesma classe:
private function contarUsuariosDoBanco()
{
    return User::count();
}
```

