# Fazendo docker para produção
[https://gemini.google.com/share/a5868d0c8b40
](https://gemini.google.com/share/a5868d0c8b40
)
```text
mini-projeto-php/
├── docker-compose.yml
├── Dockerfile
└── src/
    └── index.php
```

### Arquivos exemplo para o teste:

`src/index.php`
```php  
<?php
echo "<h1>Hello World de dentro do Docker! 🚀</h1>";
echo "<p>Ambiente rodando com sucesso.</p>";
```

### Dockerfile (Para a Build)
```docker
# Usamos a versão oficial do PHP com Apache integrado
FROM php:8.2-apache

# Copiamos o código da pasta src local para o diretório padrão do Apache no container
COPY src/ /var/www/html/

# Expomos a porta 80 do container
EXPOSE 80
```

### docker-compose.yml (O Maestro)  

```yaml  
version: '3.8'

services:
  web-dev:
    image: meu-app-php:dev
    # O build aponta para o Dockerfile atual
    build:
      context: .
      dockerfile: Dockerfile
    container_name: php_hello_world_dev
    # Mapeia a porta 80 do container para a porta 8080 do seu computador
    ports:
      - "8080:80"
    # VOLUMES: Crucial para DEV. Altere o index.php na sua máquina e veja o resultado no navegador
    volumes:
      - ./src:/var/www/html
    environment:
      - APACHE_RUN_USER=www-data
      - APACHE_RUN_GROUP=www-data
 ```
 
Subindo o Ambiente (Modo Dev)  
Com os arquivos criados no seu diretório, abra o terminal na raiz do projeto e execute o comando abaixo para construir a imagem e subir o container:

`docker compose up --build`

O que esse comando faz?

`--build: Garante que o Docker vai ler o Dockerfile e gerar a imagem meu-app-php:dev.`

`up: Cria e inicia o container baseado nessa imagem.``

Agora é só abrir o seu navegador e acessar:
`👉 http://localhost:8080`

# Testando o Live Reload (Dev)

Deixe o container rodando, abra o arquivo src/index.php no seu editor, mude o texto do "Hello World" para qualquer outra coisa e salve. Atualize o navegador: a alteração já estará lá, sem precisar reiniciar o Docker!

Gerando a Build Final

Se você fosse enviar esse projeto para produção ou para outro desenvolvedor sem querer que ele altere os arquivos locais, você geraria apenas a imagem final estática.

Para simular a geração da build isolada (onde o código fica "preso" dentro da imagem):

`docker build -t meu-app-php:v1 .`

Para testar essa build de produção (sem os volumes de dev vinculados):
`docker run -d -p 9090:80 --name app_producao meu-app-php:v1`

Dessa forma, o app rodaria na porta 9090, totalmente independente dos arquivos da sua máquina.

Quer que a gente adicione um banco de dados (como MySQL ou PostgreSQL) ou alguma extensão específica do PHP nesse Compose para deixar o esqueleto mais robusto?  
  
## De PC Dev para servidor produção ( LOCAL ou SSH )

Para transferir o projeto do PC A para o PC B diretamente, sem passar por internet ou nuvem (como GitHub, Docker Hub ou Google Drive), a melhor estratégia com Docker é exportar a imagem gerada como um arquivo .tar.

Você pode passar esse arquivo de um PC para o outro usando um pendrive ou através da rede local (via pasta compartilhada ou SSH).

Aqui está o passo a passo de como fazer:

### Passo 1: No PC A (Gerar e Salvar a Imagem)

Primeiro, você vai gerar a build da imagem no PC A e salvá-la em um arquivo físico.

Abra o terminal na pasta do projeto no PC A e gere a build final:
    
`docker build -t meu-app-php:v1 .`

Agora, use o comando docker save para exportar essa imagem para um arquivo .tar:

`docker save -o meu-app-php-v1.tar meu-app-php:v1`

>💡 O que sobrou no PC A? Um arquivo chamado meu-app-php-v1.tar de alguns megabytes. >Ele contém todo o ambiente (Apache, PHP) e o seu código "Hello World" embutido.


### Passo 2: Transferir o arquivo para o PC B

Leve o arquivo meu-app-php-v1.tar para o PC B. Escolha a forma mais fácil para você:

>Físico: Copie para um pendrive ou HD externo.

>Rede Local: Se os dois computadores estiverem no mesmo Wi-Fi ou cabo de rede, você pode usar uma pasta compartilhada do Windows/Linux, ou ferramentas de transferência direta por rede local na linha de comando (como scp ou rsync).
    
### Passo 3: No PC B (Carregar e Rodar)

Com o arquivo meu-app-php-v1.tar já dentro do PC B, abra o terminal na pasta onde colocou o arquivo e siga os passos:

Carregue o arquivo de volta para o Docker do PC B usando docker load:
    
`docker load -i meu-app-php-v1.tar`

Verifique se a imagem foi importada com sucesso:

`docker images`

>(Você verá meu-app-php:v1 listado na sua máquina B).

Agora é só rodar o container normalmente no PC B, sem precisar de internet ou de instalar o PHP na máquina host:

`docker run -d -p 8080:80 --name app_no_pc_b meu-app-php:v1`

Pronto! Se você abrir o navegador no PC B e acessar `http://localhost:8080`, o seu Hello World estará rodando exatamente igual estava no PC A.  
  
## Alternativa ao docker run, usando DOCKER COMPOSE

docker-compose.yml
```yaml
version: '3.8'

services:
  web-prod:
    # Em vez de 'build', usamos direto a imagem que você importou do arquivo .tar
    image: meu-app-php:v1
    container_name: app_hello_world_pc_b
    ports:
      - "8080:80"
    restart: always
```
>⚠️ Nota importante: Repare que este Compose não tem a linha volumes. Como estamos simulando o deploy da sua build, o código já está blindado dentro da imagem meu-app-php:v1. Você não precisa levar a pasta src/ para o PC B.

## O Fluxo de Execução no PC B

O processo completo no segundo computador fica resumido a apenas 3 comandos no terminal:

Importa a imagem (se ainda não tiver feito):
    
`docker load -i meu-app-php-v1.tar`

Entra na pasta onde você salvou o novo docker-compose.yml e sobe o serviço em segundo plano (-d):

`docker compose up -d`
  
Pronto! O container vai subir usando a imagem importada. Para testar no PC B, é só acessar:
`👉 http://localhost:8080`

Se quiser derrubar o ambiente no PC B depois, basta rodar docker compose down.  
  
## Subir versões:

### Passo 1: No PC A (Gerar a v2)

No terminal da pasta do seu projeto no PC A, rode:

Gera a build com a nova tag:

`docker build -t meu-app-php:v2 .`

Exporta para um novo arquivo `.tar`:

`docker save -o meu-app-php-v2.tar meu-app-php:v2`
   
Passe o arquivo meu-app-php-v2.tar para o PC B via pendrive/rede.

### Passo 2: No PC B (O truque profissional do Compose)

Para você não ter que abrir o docker-compose.yml e mudar de v1 para v2 manualmente no PC B, nós vamos usar um arquivo .env (arquivo de configuração de ambiente).

1. Atualize o seu docker-compose.yml no PC B para ficar assim:
    
```yaml  
version: '3.8'

services:
  web-prod:
    # O docker vai ler a tag dinamicamente da variável TAG
    image: meu-app-php:${TAG:-latest}
    container_name: app_hello_world_pc_b
    ports:
      - "8080:80"
    restart: always
```

Crie um arquivo chamado `.env` na mesma pasta do Compose:
```text
TAG=v2
```

(Quando sair a v3, você só altera essa linha para TAG=v3).
Passo 3: Rodar no PC B

Agora, com o arquivo da v2 já no PC B, execute:

Derrube a versão antiga (v1):

`docker compose down`

Importe a nova imagem v2:**

`docker load -i meu-app-php-v2.tar`

Suba o Compose novamente:

`docker compose up -d`
  
O Docker Compose vai ler o `.env`, ver que a `TAG` agora é `v2`, buscar a imagem correspondente que você acabou de importar e atualizar o site no navegador (`http://localhost:8080`) instantaneamente.  
  
## Vou ter várias versões:
    
Se você rodar o comando docker images no PC B, sim, vão aparecer as duas listadas (a v1 e a v2), ocupando espaço no disco da máquina.
    
No entanto, no seu navegador (acessando http://localhost:8080), só vai aparecer a v2.
    
1. No Docker (Disco do PC B)

O Docker não apaga a imagem antiga sozinho quando você carrega uma nova. Elas ficam guardadas como um histórico:
    
```text
REPOSITORY    TAG       IMAGE ID        SIZE
meu-app-php   v2        abc123456789    450MB
meu-app-php   v1        xyz987654321    450MB
```

2. No Container (O que está rodando)

Quando você rodou o `docker compose down`, o container antigo (v1) foi destruído. Ao rodar `docker compose up -d` com a tag alterada para v2, o Docker Compose criou um novo container usando apenas a imagem da v2 na porta 8080. A v1 fica "parada" em standby.

Como limpar a versão antiga (v1)?

Se você não precisa mais da v1 no PC B e quer liberar espaço em disco, você pode apagá-la manualmente com o comando:
    
`docker rmi meu-app-php:v1`
    
>💡 Dica de ouro: Se você fizer muitas atualizações (v3, v4, etc.), vão começar a sobrar imagens antigas ou sem nome (conhecidas como dangling images). Para faxinar o Docker do PC B e apagar tudo o que não está sendo usado no momento, basta rodar:
    
  
`docker image prune -a`

(Esse comando vai apagar a v1 e manter apenas a v2, que é a que está ativa no Compose).  
  
## Questão de persistencia( MYSQL )

O ideal é fazer junto no mesmo docker-compose.yml, mas mantendo o MySQL e o PHP em containers separados (serviços diferentes).

No mundo do Docker, a regra de ouro é: um processo por container. Então, você não deve instalar o MySQL dentro do mesmo container do PHP. Em vez disso, você coloca os dois no mesmo arquivo Compose.

Isso traz duas grandes vantagens para o seu fluxo entre o PC A e o PC B:

Eles ficam na mesma rede virtual automaticamente, facilitando a conexão.

Você gerencia o banco e a aplicação com um único comando.

## Veja como fica a estratégia ideal para o seu fluxo de levar do PC A para o PC B:

1. O que muda no PC A (Desenvolvimento)

A imagem do MySQL é oficial e pública. Você não precisa exportar o MySQL num arquivo .tar. Você só vai exportar o seu app PHP (v2, v3, etc.).

O seu docker-compose.yml de produção/homologação fica assim:
    
```yaml
version: '3.8'

services:
  # Servidor Web (Seu App PHP)
  web:
    image: meu-app-php:${TAG:-latest}
    container_name: app_php_container
    ports:
      - "8080:80"
    depends_on:
      - db # Garante que o banco sobe antes do PHP
    restart: always

  # Servidor de Banco de Dados (MySQL)
  db:
    image: mysql:8.0
    container_name: mysql_container
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: senha_pro_root
      MYSQL_DATABASE: meu_hello_world_db
    ports:
      - "3306:3306" # Opcional: só se quiser conectar via DBeaver/HeidiSQL no PC B
    volumes:
      - mysql_data:/var/www/html # IMPORTANTE: Mantém os dados salvos no PC B
      
volumes:
  mysql_data: # Define o volume persistente para os dados não sumirem no 'down'
 ```
 2. Como fica o Fluxo para levar pro PC B?

Agora, para atualizar o PC B com o banco junto, o processo muda muito pouco:

No PC A: Você gera a build do PHP e exporta o .tar normalmente (ex: meu-app-php-v2.tar).

Transferência: Você leva para o PC B:

>O arquivo meu-app-php-v2.tar
>O arquivo docker-compose.yml (com o código do MySQL acima)
>O arquivo .env (com TAG=v2)

No PC B (Sem Internet?): 
* Se o PC B tiver internet, na primeira vez que você rodar `docker compose up -d`, o Docker vai baixar o MySQL oficial direto do Docker Hub automaticamente e usar a sua imagem local do PHP.

Se o PC B NÃO tiver internet de jeito nenhum, aí você precisará fazer o `docker save` da imagem do MySQL no PC A também (`docker save -o mysql-8.tar mysql:8.0`) e dar `docker load` nela no PC B.

## Por que usar volumes no MySQL?

Repare na linha volumes: no final do arquivo. O banco de dados salva as tabelas dentro do container. Se você rodar docker compose down, o container é destruído.

Usando o volumes, o Docker cria uma pasta oculta no HD do PC B. Mesmo que você atualize o PHP para a v3, v4 ou derrube o Compose, os dados que você inseriu no banco do PC B continuarão lá salvos.
