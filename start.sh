#!/bin/bash
clear

# Define cores para o terminal
VERDE='\033[0;32m'
AMARELO='\033[1;33m'
AZUL='\033[0;34m'
VERMELHO='\033[0;31m'
NC='\033[0m' # No Color

echo "-----------------------------------------------------------------------------------------------"
echo -e "${AZUL}INICIANDO AMBIENTE DE DESENVOLVIMENTO${NC}"
echo "-----------------------------------------------------------------------------------------------"


# 1. Validação de segurança: Verifica se o .env existe
if [ ! -f .env ]; then
    echo -e "${VERMELHO}[ERRO] Arquivo .env não encontrado na raiz!${NC}"
    echo -e "${AMARELO}Por favor, crie o arquivo .env antes de subir os containers.${NC}"
    exit 1
else
    export $(grep -v '^#' .env | xargs )
fi

# 2. Sobe os containers em background
echo -e "${AMARELO}Subindo os containers...${NC}"
docker compose up -d
echo "-----------------------------------------------------------------------------------------------"
sleep 2
echo -e "${VERMELHO}Apagando redes inuteis.${NC}"
docker network prune -f
echo "-----------------------------------------------------------------------------------------------"
echo -e "${AMARELO}Aguardando os serviços estabilizarem...${NC}"
# 3. Loop rápido para esperar o MySQL aceitar conexões (opcional, mas evita erro de Connection Refused no Artisan)
# Ele tenta rodar um 'mysqladmin ping' de dentro do container até dar boa
MYSQL_READY=0
for i in {1..15}; do
    if docker exec dev_db_mysql mysqladmin ping -h"localhost" -u"root" -p"${DB_ROOT_PASSWORD}" --silent &> /dev/null; then
        MYSQL_READY=1
        break
    fi
    echo -n "#"
    sleep 1
done
echo "-----------------------------------------------------------------------------------------------"
if [ $MYSQL_READY -eq 1 ]; then
    echo -e "${VERDE}[OK] MySQL está pronto para conexões!${NC}"
else
    echo -e "${AMARELO}[AVISO] MySQL demorando mais que o esperado para iniciar." 
    echo -e "Verifique os logs se necessário.${NC}"
fi
echo "-----------------------------------------------------------------------------------------------"
echo -e "${VERDE}Status atual dos serviços:${NC}"
echo "-----------------------------------------------------------------------------------------------"
# 4. Exibe a tabela de status formatada
OUTPUT=$(docker compose ps --format "{{.Name}}\t{{.Status}}\t{{.Ports}}\t{{.Service}}" | column -t -s $'\t')
echo "$OUTPUT"

echo "-----------------------------------------------------------------------------------------------"
eval "echo -e \"Acesse em : ${VERDE}${APP_URL}${SEM_COR}\""
echo "-----------------------------------------------------------------------------------------------"
echo -e "${VERDE}Ambiente online! Boa codificação. ${NC}"
echo "-----------------------------------------------------------------------------------------------"
echo ""
