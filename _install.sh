#!/bin/bash

# Cores para o terminal
VERDE='\033[0;32m'
AZUL='\033[0;34m'
SEM_COR='\033[0m'

echo -e "${AZUL}==> Iniciando a preparação do ambiente Laravel + Inertia/Vue...${SEM_COR}"

# Arquivos de ambiente
DOCKER_ENV=".env.docker"

# Verifica se o arquivo NÃO existe
if [ ! -f "$DOCKER_ENV" ]; then
    echo "❌ ERRO CRÍTICO: O arquivo '$DOCKER_ENV' não foi encontrado!"
    echo "Abortando a inicialização para evitar que o seu .env seja danificado."
    exit 1
fi

# 1. Cria o .env independente.
echo -e "${AZUL}==> Criando arquivo .env a partir do exemplo...${SEM_COR}"
# cp .env.example .env
# mescla env-docker com env-example
cat .env.docker env.example > .env.tmp
mv .env.tmp .env

ENV_FILE=".env"
if [ ! -f "$ENV_FILE" ]; then
    echo "❌ Erro: O arquivo $ENV_FILE não existe!"
    exit 1
fi

export $(grep -v '^#' "$ENV_FILE" | xargs)


# 2. Limpa contêineres e resíduos antigos
echo -e "${AZUL}==> Limpando contêineres e volumes antigos...${SEM_COR}"
docker compose down -v --remove-orphans

# Remove pastas locais para garantir instalação limpa (sem travas de permissão)
rm -rf node_modules package-lock.json vendor

# 3. Cria a estrutura de pastas que o Laravel exige para escrita
echo -e "${AZUL}==> Inicializando diretórios de armazenamento do Laravel...${SEM_COR}"
mkdir -p storage/logs storage/framework/sessions storage/framework/views storage/framework/cache bootstrap/cache

# 4. Sobe a stack no Docker (Constrói se necessário)
echo -e "${AZUL}==> Subindo os contêineres...${SEM_COR}"
docker compose up -d --build

# 5. Instala dependências do PHP (Backend)
# Usamos --no-scripts para o Artisan não tentar conectar ao banco antes do tempo
echo -e "${AZUL}==> Executando composer install no contêiner 'backend'...${SEM_COR}"
docker compose exec backend composer install --no-interaction --prefer-dist --no-scripts
docker compose exec backend composer dump-autoload

# 6. Instala dependências do Node (Frontend)
# Como tudo já está no seu package.json, só precisamos do install puro
echo -e "${AZUL}==> Executando npm install no contêiner 'frontend'...${SEM_COR}"
docker compose exec frontend npm install

# 7. Gera a chave criptográfica do Laravel
echo -e "${AZUL}==> Gerando a APP_KEY do Laravel...${SEM_COR}"
docker compose exec backend php artisan key:generate

# 8. Aguarda o MySQL estar pronto para receber conexões
echo -e "${AZUL}==> Aguardando o MySQL iniciar por completo...${SEM_COR}"
sleep 10
echo -e "${VERDE}==> MySQL está pronto!${SEM_COR}"

# 9. Executa as migrations do banco de dados
echo -e "${AZUL}==> Rodando as migrations no MySQL...${SEM_COR}"
docker compose exec backend php artisan migrate

# 9.1 Rodar as seeders
echo -e "${AZUL}==> Rodando as seeders...${SEM_COR}"
docker compose exec backend php artisan db:seed

# 10. Limpa caches internos do framework
echo -e "${AZUL}==> Limpando caches internos do Laravel...${SEM_COR}"
docker compose exec backend php artisan config:clear
docker compose exec backend php artisan cache:clear

echo -e "${AZUL}==> Blindando MYSQL ...${SEM_COR}"
docker compose exec -T db_mysql mysql -u root -p${MYSQL_ROOT_PASSWORD} -e "
  CREATE USER IF NOT EXISTS '${MYSQL_USER}'@'172.%.%.%' IDENTIFIED BY '${MYSQL_PASSWORD}';
  GRANT ALL PRIVILEGES ON ${MYSQL_DATABASE}.* TO '${MYSQL_USER}'@'172.%.%.%';
  DROP USER IF EXISTS '${MYSQL_USER}'@'%';
  FLUSH PRIVILEGES;
"

echo "--------------------------------------------------------"
echo -e "${VERDE}TUDO PRONTO! O ecossistema está rodando perfeitamente. 🚀${SEM_COR}"
echo ""
echo "Acesse a aplicação em: http://localhost:8080"
echo ""
echo "O servidor do Vite (Frontend) está ativo na porta 5173"
echo "Ou Rode caso não com ./rundev.sh"
echo "--------------------------------------------------------"