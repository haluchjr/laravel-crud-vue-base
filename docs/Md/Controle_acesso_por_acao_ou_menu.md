# Tabelas responsaveis
tb_nivel_permissoes
tb_nivel
tb_menus
tb_usuarios

# Uso no controller
    $permissoes = Auth::user()->hasPermission(Route::currentRouteName());

# Ou No __construct

    private $permissao; 
    
    public function __construct(){
        $this->permissao = (Auth::user()->hasPermission(Route::currentRouteName()));
    }



## Inibir o usuario de ver
if (!$permissoes || (int)$permissoes->ver !== 1) {
    abort(403);
    //ou
    return redirect()->back()->withInput()->with('error', 'Você não pode acessar.');   
}

## Inibir o salvar no controller
if (!$this->permissao || (int)$this->permissao->criar !== 1) { // criar/editar/excluir
    return redirect()->back()->withInput()->with('error', 'Você não pode acessar.');   
// abort(403);
}

return Inertia::render('Cliente/Relatorio',[
    'permissoes'     => $permissoes ou $this->permissao
]);

# Na view(vue)
JS:
const { dados } = defineProps({
    permissoes:{
        type: Object,
        required:true,
    }
});

HTML:
<span v-if="permissoes.criar">teste</span>

# Arquivos responsaveis
app/Models/Usuarios.php
app/Models/NivelPermissao.php
routes/web.php
app/Http/Middleware/HandleInertiaRequests.php

# Definicao
Ajustar na tb_nivel_permissoes :
    NIVEL_ID => Id baseado na tb_nivel
    MENU_ID  => Qual ID, na tb_menu que irá barrar ou não acesso a aquela tela, 
                por mais que ja tem em tb_menus tal acao, mas da pra barrar salvar/editar/ver/criar ou até mesmo mais acoes.
    ver/criar/editar/excluir => Valores bit(0/1/null*) ativo pra aquela tela.
    Expandir opcoes na tabela se necessario.

tb_menu:
tem os ajustes de acesso aparece ou não no menu do usuario, de acordo com o nivel dele.

Route::currentRouteName() => retorna o nome de como tá definido em web.php, *named routes*.
                             usado para consulta ,junto com o nivel do usuario que já é passado diretamente na model.


* Adicionado no HandleInertiaRequests.php , as permissoes globais para usar na tela.                           
{{ $page.props.permissoes }} pra nao precisar usar o defineProps.