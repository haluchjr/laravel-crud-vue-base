#!/bin/bash
clear

# Cores para o terminal
VERDE='\033[0;32m'
VERMELHO='\033[0;31m'
AZUL='\033[0;34m'
SEM_COR='\033[0m'

echo -e "${VERMELHO}+------------------------------------------------------------------------+"
echo -e "${VERMELHO}| SCRIPT DE PRIMEIRO USO, SE JA RODOU OU TEM DADOS POPULADOS PARE AGORA. |"
echo -e "${VERMELHO}+------------------------------------------------------------------------+"

total=10
echo -e "${VERMELHO}Você tem ${total} segundos para abortar... (Ctrl+C)${SEM_COR}"

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

echo -e "${AZUL}==> Rodando as migrations no MySQL...${SEM_COR}"
docker exec prod_backend php artisan migrate --force
echo -e "${VERMELHO}+------------------------------------------------------------------------+"

echo -e "${AZUL}==> Rodando as seeders...${SEM_COR}"
docker exec prod_ackend php artisan db:seed --force
echo -e "${VERMELHO}+------------------------------------------------------------------------+"

echo -e "${AZUL}==> Limpando caches internos do Laravel...${SEM_COR}"
docker exec prod_backend php artisan config:clear
docker exec prod_backend php artisan cache:clear
echo -e "${VERMELHO}+------------------------------------------------------------------------+"

echo -e "${AZUL}==> Blindando usuario laravel-user no MYSQL ...${SEM_COR}"
docker exec prod_backend php artisan db:super-user --force

#echo -e "${AZUL}==> Rodando scripts base do banco de dados ...${SEM_COR}"
#docker compose exec backend php artisan db:install

echo -e "${VERMELHO}--------------------------------------------------------"
echo -e "${VERDE}TUDO PRONTO! O ecossistema está rodando perfeitamente."
echo -e "--------------------------------------------------------${SEM_COR}"