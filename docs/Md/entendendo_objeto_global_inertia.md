```text
=========================================================================================
                      ENTENDENDO O OBJETO GLOBAL DO INERTIA
=========================================================================================
```

|Caminho no Template       | O que ele acessa?                                           |
| :--- | :--- |
|$page                     | O objeto raiz do Inertia da página atual.|
|$page.component           | O nome do componente sendo renderizado (ex: "Cadastro/Index").|
|$page.url                 | A URL atual que você está acessando no navegador.|
|$page.props               | TODAS as variáveis que o Controller enviou no array do Inertia.|


|Comando | Uso |
| :--- | :--- |
| `defineProps` | Para dados que mudam de página para página, como a sua lista de dados. Ele deixa o seu componente mais limpo, fácil de ler e o Vue consegue validar se o dado chegou certinho. |
| `$page.props:` | É excelente para dados globais que você compartilha em quase todas as telas do sistema através de um Middleware do Inertia (como o usuário logado: `$page.props.auth.user`, ou mensagens de sucesso: `$page.props.flash.success`).|


