# Tabelas responsaveis
tb_nivel_permissoes
tb_nivel
tb_menus
tb_usuarios

# Uso no controller
$permissoes = Auth::user()->hasPermission(Route::currentRouteName());

return Inertia::render('Cliente/Relatorio',[
    'permissoes'     => $permissoes
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