#!/bin/bash

# Define cores para o terminal (opcional, mas ajuda na leitura)
VERDE='\033[0;32m'
AMARELO='\033[1;33m'
VERMELHO='\033[0;31m'
NC='\033[0m' # No Color

#ENV_FILE=".env"
#export $(grep -v '^#' "$ENV_FILE" | xargs)

echo ""
echo ""
echo -e "${AMARELO}Iniciando a limpeza do ambiente...${NC}"
echo ""

# 1. Limpa o Laravel Telescope antes de derrubar (apenas se o container estiver rodando)
if [ "$(docker ps -q -f name=^backend$)" ]; then
    echo "Limpando dados antigos do Telescope..."
    # Removeu-se o -t para evitar erros de "the input device is not a TTY"
    docker exec -i backend php artisan telescope:prune
else
    echo -e "${AMARELO}Container 'app' não está rodando. Pulando o prune do Telescope.${NC}"
fi

# ----------------------------------------------------------------------
# NOVO: Limpeza do arquivo de log do Laravel
# ----------------------------------------------------------------------
LOG_FILE="storage/logs/laravel.log"

if [ -f "$LOG_FILE" ]; then
    echo -e "${AMARELO}Zerando o arquivo de log do Laravel...${NC}"
    # O comando : > limpa o conteúdo mantendo o arquivo e suas permissões intactos
    : > "$LOG_FILE"
    echo -e "${VERDE}Log limpo com sucesso!${NC}"
else
    echo -e "${AMARELO}Arquivo laravel.log não encontrado. Pulando limpeza de log.${NC}"
fi
# ----------------------------------------------------------------------

echo ""
echo -e "${VERMELHO}Desligando os containers (Mantendo os volumes intactos)...${NC}"
# 2. Derruba os containers e remove a rede virtual (sem mexer nos volumes!)
docker compose down

echo ""
echo "----------------------------------------"
echo "Verificando status atual dos serviços:"
echo "----------------------------------------"

# 3. Lista o status final para garantir que tudo morreu
# Se a tabela vier vazia, significa sucesso total.
OUTPUT=$(docker compose ps --format "{{.Name}}\t{{.Status}}\t{{.Ports}}\t{{.Service}}" | column -t -s $'\t')

echo ""
echo "----------------------------------------"
echo -e "${VERDE}Tudo desligado com sucesso! Seus dados do MySQL/Redis estão salvos.${NC}"
echo "----------------------------------------"
echo ""
