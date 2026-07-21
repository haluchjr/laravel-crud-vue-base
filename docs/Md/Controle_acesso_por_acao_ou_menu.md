# Tabelas responsaveis
tb_nivel_permissoes
tb_nivel
tb_menus
tb_usuarios

## Inibir o usuario de ver
if (!Auth::user()->hasPermission(Route::currentRouteName(),'ver') ){
    return redirect()->back()->with('error', 'Mensagem' );
}

## Inibir o salvar no controller
if (!Auth::user()->hasPermission(Route::currentRouteName(),'salvar') ){
    return redirect()->back()->with('error', 'Seu nível de usuario não permite salvar.' );
}


# Na view(vue)
Exibe as acoes, validar no front pra estilizar.
JS:
const page = usePage()
const permissoes = computed(() => page.props.auth.user.permissoes)

HTML:
<span v-if="permissoes.criar">teste</span>

# Arquivos responsaveis
app/Models/Usuarios.php
app/Models/NivelPermissao.php
routes/web.php
app/Http/Middleware/HandleInertiaRequests.php

# Definicao
Ajustar na tb_nivel_permissoes :
    NIVEL_ID        => Id baseado na tb_nivel
    URL_AMIGAVEL    => Qual ID, na tb_menu que irá barrar ou não acesso a aquela tela, 
                        por mais que ja tem em tb_menus tal acao, mas da pra barrar salvar/editar/ver/criar ou até mesmo mais acoes.
    
    ver/criar/editar/excluir => Valores bit(0/1/null*) ativo pra aquela tela.
    Expandir opcoes na tabela se necessario.

tb_menu:
tem os ajustes de acesso aparece ou não no menu do usuario, de acordo com o nivel dele.

Route::currentRouteName() => retorna o nome de como tá definido em web.php, *named routes*.
                             usado para consulta ,junto com o nivel do usuario que já é passado diretamente na model.


* Adicionado no HandleInertiaRequests.php , as permissoes globais para usar na tela.                           
{{ $page.props.permissoes }} pra nao precisar usar o defineProps.


* Se quiser deixar formulario somente leitura.
JS:
const page = usePage()
const permissoes = computed(() => page.props.auth.user.permissoes)
const somenteLeitura = computed(() => !permissoes.value.salvar);

HTML:
 <fieldset :disabled="somenteLeitura">
 ...campos...
 Tudo fica somente leitura aqui, ideal para perfil que soh pode ler.

 </fieldset>

 Se for por campo:
<input type="text"
        :readonly="somenteLeitura"
    ...
