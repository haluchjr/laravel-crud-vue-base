```text
┌────────────────────────────────────────────────┐
│                                                │
│   ____ _ _     ____   __        _     _        │
│  / ___(_) |_  |  _ \ /_/_ _ __ (_) __| | ___   │
│ | |  _| | __| | |_) / _` | '_ \| |/ _` |/ _ \  │
│ | |_| | | |_  |  _ < (_| | |_) | | (_| | (_) | │
│  \____|_|\__| |_| \_\__,_| .__/|_|\__,_|\___/  │
│                          |_|                   │
│                                                │
└────────────────────────────────────────────────┘
```
```text
Conflitos
	Você pode remover as credenciais salvas ou configurar a autenticação manualmente 
	git credential reject https://github.com

	Configure o nome e e-mail (obrigatório para commits): 

Configuração Inicial
	git config --global --list
	git config --local --list 
	
	git config --global user.name "Seu Nome"
	git config --global user.email "seuemail@example.com"
	
	Defina o usuário correto apenas para o repositório específico:
	git config --local user.name "Seu Nome"
	git config --local user.email "seuemail@exemplo.com"
	
Criar um Repositório ou Iniciar um
	git init

Clonar um Repositório
	git clone https://github.com/usuario/repo.git

Verificar Status
	git status
	
Adicionar Arquivos para o Commit
	git add arquivo.txt # um a um
	git add .  # todos arquivos
	
Criar um Commit
	git commit -m "mensagem'"

Ver Histórico de Commits
	git log --oneline
	git log --oneline --format="%h %ad %s" --date=format:'%d/%m/%Y %H:%M:%S' 
	
Enviar para o Repositório Remoto
	git push origin main
	
Atualizar com Alterações Remotas
	git pull origin main
	
Criar e Trocar de Branch
	git branch nova-feature   # Cria uma nova branch
	git checkout nova-feature # Alterna para a nova branch
	git switch nova-feature   # Alternativa ao checkout (Git 2.23+)
	
ou
	
	git checkout -b novo_nome
	
Mesclar uma Branch ( MERGE )
	git checkout main      # Vai para a branch principal
	git merge nova-feature # Junta as mudanças da nova branch
	
Reverter Mudanças Antes do Commit
	git checkout -- arquivo.txt  	# Desfaz alterações em um arquivo
	git reset HEAD arquivo.txt    	# Remove da área de staging
	
Reverter um Commit
	git revert HEAD   			# Cria um novo commit que desfaz o último commit
	git reset --hard HEAD~1  	# Remove o último commit (irreversível!)

Dica Final: Sempre teste seus comandos com git status antes de confirmar mudanças!

------------------------------------------------------------------------------------------------
### Novo Repositorio

	No github/gitea 
		Novo Repositorio, de um nome sera criado o repositorio remoto.
		Anote a url
	
	Cria uma pasta  
		Ex: TESTE
	
	Dentro da pasta 
		git init
		git branch -M main 							# Comum
		*	git branch -M trunk						# alternativo
		
		git remote add origin url_repositorio 		# vou usar outro nome
		*	git remote add origem url_repositorio 	# alternativo
		
		git remote 									# nome do repositorio OPCIONAL, lista eles.
		
------------------------------------------------------------------------------------------------
### Passo a passo para commit ( enviar )  PUSH

	#git init 										# Isso cria a pasta .git, onde o Git armazena as versões do código.
	#echo "Meu primeiro commit!" > arquivo.txt 		# Isso cria um arquivo arquivo.txt com um conteúdo.
	
	git status										# Isso mostra quais arquivos foram modificados ou adicionados.
	#git add arquivo.txt   							# Adiciona um arquivo específico
	git add .             							# Adiciona todos os arquivos modificados
	git commit -m "Mensagem explicando a mudança"	# Isso salva as mudanças localmente com uma mensagem.
	git log --oneline								# Isso exibe uma lista resumida dos commits já feitos.
		
	git push origin main		
	
		Se for a primeira vez, adicione o repositório remoto:
		
	git remote add origin https://github.com/seu-usuario/seu-repositorio.git
	git push -u origin main
	
------------------------------------------------------------------------------------------------
### Passo a passo para novo branch.
	git checkout -b NOVO_BRANCHE 	# cria uma nova branche local, muda para nova e cria com o nome NOVO_BRANCHE
		git branch 						# lista as branches existentes ,opcional
		git switch  					# se quiser trocar de branche , opcional 
	git status  					# lista o que nao ta adicionado.
	git add . 						# adiciona tudo
	git status  					# lista o que foi adicionado.
	git commit -m "mensagem"		# mensagem do commit
	git push origin NOVO_BRANCHE
	

	
------------------------------------------------------------------------------------------------
### Para remover a branche
	
	git branch -D NOME-DA-BRANCHE 					# apaga localmente
	git branch push origin NOME-DA-BRANCHE --delete # Remoto

------------------------------------------------------------------------------------------------
### Atualizar repositorio local

	git fetch #Atualize os branches remotos
	git branch -r #Veja a lista de branches remotos
	git checkout nome-do-branch #Faça checkout no novo branch ( Baixe novo branche )
		
		git checkout -b nome-do-branch origin/nome-do-branch #Se for a primeira vez que você está acessando esse branch na outra pasta, use:
		
	git status #Confirme que o branch foi atualizado
	
ou
	
	git pull
------------------------------------------------------------------------------------------------
### Passo a passo pra merge
	
	Mude para a branche que vai receber o merge com:
	git checkout MAIN # muda para brancheori
		ou
	git switch MAIN   # muda para branche 
	
	git merge NOME-DA-BRANCHE-QUE-VAI-SER-MESCLADA # mescla a branche.
	git log
	git push origin main # para enviar para o servidor. 
	
------------------------------------------------------------------------------------------------	
### Corringindo Conflitos

	git status # Verifique o status das alterações:
	
	git fetch origin # Buscar as alterações remotas / Antes de fazer o pull, garanta que você tem as alterações mais recentes do repositório remoto:
	
	git pull origin X # Tentar fazer o pull / Tente mesclar as alterações do branch remoto para o branch local:
		O Git detectará o conflito e mostrará uma mensagem como:
		CONFLICT (content): Merge conflict in <nome-do-arquivo>
	
	git status 	# Verificar os arquivos em conflito
				# Os arquivos em conflito aparecerão como "both modified".
	
	Abra o arquivo indicado pelo Git e procure as linhas marcadas assim:
		<<<<<<< HEAD
		(Sua alteração local)
		=======
		(Alteração remota)
		>>>>>>> origin/X
	Edite o arquivo, mantendo apenas a versão correta e removendo os marcadores <<<<<<<, =======, >>>>>>>.
	Depois de resolver, salve o arquivo.
	
	git add <nome-do-arquivo> # Marcar o conflito como resolvido
	
	git commit -m "Resolvido conflito no arquivo X"
	
	Se for necessário, envie as mudanças para o repositório remoto:
	
	git push origin X

	Resumo....
	git status
	git fetch origin
	git pull origin X
	# Resolver conflito no arquivo manualmente
	git add <nome-do-arquivo>
	git commit -m "Resolvido conflito no arquivo X"
	git push origin X
------------------------------------------------------------------------------------------------
	


	
------------------------------------------------------------------------------------------------
### O que são "origin" e "main"? Dá para usar outros nomes?
	origin → É o nome padrão do repositório remoto. Você pode alterar para outro nome, como meu-servidor, se quiser:

	git remote add meu-servidor https://github.com/seu-usuario/seu-repositorio.git

main → É a branch principal do repositório. Antes do Git 2020, o nome padrão era master. Você pode renomear a branch:
	git branch -m main principal

Depois, use:
	git push -u origin principal
```