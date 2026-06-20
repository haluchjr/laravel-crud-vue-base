#!/bin/bash

# Cores para o terminal
VERDE='\033[0;32m'
AZUL='\033[0;34m'
SEM_COR='\033[0m'

echo -e "${AZUL}==> Iniciando a preparação do ambiente Laravel + Inertia/Vue...${SEM_COR}"

# 1. Cria o .env se ele não existir
if [ ! -f .env ]; then
    echo -e "${AZUL}==> Criando arquivo .env a partir do exemplo...${SEM_COR}"
    cp .env.example .env
else
    echo -e "${VERDE}==> Arquivo .env já existe. Pulando...${SEM_COR}"
fi

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

# 10. Limpa caches internos do framework
echo -e "${AZUL}==> Limpando caches internos do Laravel...${SEM_COR}"
docker compose exec backend php artisan config:clear
docker compose exec backend php artisan cache:clear

echo "--------------------------------------------------------"
echo -e "${VERDE}TUDO PRONTO! O ecossistema está rodando perfeitamente. 🚀${SEM_COR}"
echo "Acesse a aplicação em: http://localhost:8080"
echo "O servidor do Vite (Frontend) está ativo na porta 5173"
echo "--------------------------------------------------------"