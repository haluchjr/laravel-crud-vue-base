#!/bin/bash

# Cores para o terminal ficar bonito
VERDE='\033[0;32m'
AZUL='\033[0;34m'
SEM_COR='\033[0m'

echo -e "${AZUL}==> Clonou do Git? Vamos preparar o ambiente do zero...${SEM_COR}"

# 1. Cria o .env se ele não existir
if [ ! -f .env ]; then
    echo -e "${AZUL}==> Criando arquivo .env a partir do exemplo...${SEM_COR}"
    cp .env.example .env
else
    echo -e "${VERDE}==> Arquivo .env já existe. Pulando...${SEM_COR}"
fi

## 2. Derruba qualquer contêiner ou volume fantasma travando o ambiente
echo -e "${AZUL}==> Limpando contêineres, volumes antigos e travas do NPM...${SEM_COR}"
docker compose down -v --remove-orphans
# Remove pastas locais para garantir que o NPM reconstrua do zero sem conflito de permissão root
sudo rm -rf node_modules package-lock.json

# 3. Cria a estrutura básica de pastas localmente no Host para evitar erros de montagem
echo -e "${AZUL}==> Inicializando diretórios de armazenamento...${SEM_COR}"
mkdir -p storage/logs storage/framework/sessions storage/framework/views storage/framework/cache bootstrap/cache
chmod -R 777 storage bootstrap/cache

# 4. Roda o Composer como root no contêiner temporário
echo -e "${AZUL}==> Executando composer install em contêiner isolado...${SEM_COR}"
docker compose run --rm --entrypoint "" -u "root" app_web composer install --no-interaction --prefer-dist

# 5. PASSO DO REACT BLINDADO DEFINITIVO: Usa o plugin oficial atualizado para Vite 8
#echo -e "${AZUL}==> Instalando dependências do NPM (React + Plugin Oficial)...${SEM_COR}"
# para react
#docker compose run --rm --entrypoint "" -u "root" app_web npm install --unsafe-perm --legacy-peer-deps
#docker compose run --rm --entrypoint "" -u "root" app_web npm install react react-dom @vitejs/plugin-react --save-dev --unsafe-perm --legacy-peer-deps

echo -e "${AZUL}==> Instalando dependências do NPM (Vue + Plugin Oficial)...${SEM_COR}"
# para vue
docker compose run --rm --entrypoint "" -u "root" app_web npm install --unsafe-perm --legacy-peer-deps
docker compose run --rm --entrypoint "" -u "root" app_web npm install vue @vitejs/plugin-vue --save-dev --unsafe-perm --legacy-peer-deps
docker compose run --rm --entrypoint "" -u "root" app_web npm install vue @vitejs/plugin-vue laravel-vite-plugin --save-dev --unsafe-perm --legacy-peer-deps

# 6. Sobe o ecossistema definitivo
echo -e "${AZUL}==> Subindo os contêineres principais (Apache, MySQL, Redis)...${SEM_COR}"
docker compose up -d --build

# 7. Gera a chave criptográfica da aplicação
echo -e "${AZUL}==> Gerando a APP_KEY do Laravel...${SEM_COR}"
docker compose exec app_web php artisan key:generate

# 8. Aguarda o MySQL iniciar
echo -e "${AZUL}==> Aguardando o MySQL iniciar por completo (evita erros de conexão)...${SEM_COR}"
sleep 10
echo -e "${VERDE}==> MySQL está pronto!${SEM_COR}"

# 9. Executa as migrations estruturais do banco de dados
echo -e "${AZUL}==> Rodando as migrations no MySQL...${SEM_COR}"
docker compose exec app_web php artisan migrate

# 10. Limpa caches antigos de configuração do Laravel
echo -e "${AZUL}==> Limpando caches internos do Laravel...${SEM_COR}"
docker compose exec app_web php artisan config:clear
docker compose exec app_web php artisan cache:clear

echo "Garantindo permissions do diretório..."
sudo chown -R $(id -u):$(id -g) .

echo "Garantindo permissões das pastas de escrita do Laravel..."
sudo chown -R $(id -u):www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

echo "--------------------------------------------------------"
echo -e "${VERDE}TUDO PRONTO! O ambiente foi reconstruído do zero. 🚀${SEM_COR}"
echo "Acesse o projeto em: http://localhost:8020"
echo "--------------------------------------------------------"