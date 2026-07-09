#!/bin/bash
clear

# Cores para o terminal
VERDE='\033[0;32m'
VERMELHO='\033[0;31m'
AZUL='\033[0;34m'
SEM_COR='\033[0m'

echo -e "${VERMELHO}===========================================================================${SEM_COR}"
echo -e "${VERMELHO}=== SE VOCE JA RODOU ESTE SCRIPT UMA VEZ, ABORTE POIS VAI ZERAR O BANCO ===${SEM_COR}"
echo -e "${VERMELHO}===========================================================================${SEM_COR}"

total=10
echo -e "${VERMELHO} Você tem ${total} segundos para abortar...${SEM_COR}"

for ((i=0; i<=total; i++)); do
    percent=$((i * 100 / total))
    printf "\rProgresso: ["
    for ((j=0; j<i; j++)); do
        printf "#"
    done

    for ((j=i; j<total; j++)); do
        printf " "
    done

    printf "] %3d%%" "$percent"
    sleep 1
done

echo

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
echo -e "${AZUL}==> Criando arquivo .env a partir do .env.example...${SEM_COR}"
# cp .env.example .env
# mescla env-docker com env-example
cat .env.docker .env.example > .env.tmp
mv .env.tmp .env

ENV_FILE=".env"
if [ ! -f "$ENV_FILE" ]; then
    echo "❌ Erro: O arquivo $ENV_FILE não existe!"
    exit 1
fi

export $(grep -v '^#' "$ENV_FILE" | xargs)

if [ "$APP_ENV" != "local" ]; then
    echo -e "${VERMELHO}===========================================================================${SEM_COR}"
    echo -e "${VERMELHO}=== ERRO: Este script só pode ser executado em ambiente 'local'         ===${NC}"
    echo -e "${VERMELHO}=== Ambiente atual detectado: ${APP_ENV}                                ===${NC}"
    echo -e "${VERMELHO}===========================================================================${SEM_COR}"
    exit 1
fi


# 2. Limpa contêineres e resíduos antigos
echo -e "${AZUL}==> Limpando contêineres e volumes antigos...${SEM_COR}"
#docker compose down -v --remove-orphans
docker compose down -v --rmi all --remove-orphans

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

# 10. Limpa caches internos do framework
echo -e "${AZUL}==> Limpando caches internos do Laravel...${SEM_COR}"
docker compose exec backend php artisan config:clear
docker compose exec backend php artisan cache:clear

echo -e "${AZUL}==> Blindando MYSQL ...${SEM_COR}"
docker compose exec backend php artisan db:super-user --force

echo -e "${AZUL}==> Rodando scripts base do banco de dados ...${SEM_COR}"
docker compose exec backend php artisan db:install

echo "--------------------------------------------------------"
echo -e "${VERDE}TUDO PRONTO! O ecossistema está rodando perfeitamente. 🚀${SEM_COR}"
echo ""
echo "Acesse a aplicação em: http://localhost:8080"
echo ""
echo "O servidor do Vite (Frontend) está ativo na porta 5173"
echo "Ou Rode caso não com ./rundev.sh"
echo "--------------------------------------------------------"