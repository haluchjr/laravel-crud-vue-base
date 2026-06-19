#!/bin/bash

# Define cores para o terminal
VERDE='\033[0;32m'
AMARELO='\033[1;33m'
AZUL='\033[0;34m'
VERMELHO='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${AZUL}==============================================================================${NC}"
echo -e "${AZUL}             INICIANDO AMBIENTE DE DESENVOLVIMENTO${NC}"
echo -e "${AZUL}==============================================================================${NC}"
echo ""

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

echo ""
echo -e "${AMARELO}Aguardando os serviços estabilizarem...${NC}"

# 3. Loop rápido para esperar o MySQL aceitar conexões (opcional, mas evita erro de Connection Refused no Artisan)
# Ele tenta rodar um 'mysqladmin ping' de dentro do container até dar boa
MYSQ_READY=0
for i in {1..15}; do
    if docker exec db_mysql mysqladmin ping -h"localhost" -u"root" -p"${DB_ROOT_PASSWORD}" --silent &> /dev/null; then
        MYSQ_READY=1
        break
    fi
    echo -n "."
    sleep 1
done

echo ""
if [ $MYSQ_READY -eq 1 ]; then
    echo -e "${VERDE}[OK] MySQL está pronto para conexões!${NC}"
else
    echo -e "${AMARELO}[AVISO] MySQL demorando mais que o esperado para iniciar. Verifique os logs se necessário.${NC}"
fi

echo ""
echo -e "${VERDE}Status atual dos serviços:${NC}"

# 4. Exibe a tabela de status formatada
OUTPUT=$(docker compose ps --format "{{.Name}}\t{{.Status}}\t{{.Ports}}\t{{.Service}}" | column -t -s $'\t')
echo "$OUTPUT"
echo ""
echo -e "Acesse em : ${VERDE} ${APP_URL} ${NC}"
echo ""
echo -e "${AZUL}========================================${NC}"
echo -e "${VERDE} Ambiente online! Boa codificação. ${NC}"
echo -e "${AZUL}========================================${NC}"
echo ""
echo ""
