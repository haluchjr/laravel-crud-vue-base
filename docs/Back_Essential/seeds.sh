#!/bin/bash

# Define cores para o terminal (opcional, mas ajuda na leitura)
VERDE='\033[0;32m'
AMARELO='\033[1;33m'
VERMELHO='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${AMARELO}Iniciando criacao de tabelas/ alimentando banco...${NC}"
echo ""
docker compose exec backend php artisan migrate
docker compose exec backend php artisan db:seed --class=MenuSeeder
docker compose exec backend php artisan db:seed --class=AclSeeder


