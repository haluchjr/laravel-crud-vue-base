#!/bin/bash
set -e

VERDE='\033[0;32m'
VERMELHO='\033[0;31m'
AZUL='\033[0;34m'
SEM_COR='\033[0m'

clear

echo "+----------------------------------------------------------------------+"
echo "|                  BUILD COM GENERACAO DE TAG DINÂMICA                 |"
echo "+----------------------------------------------------------------------+"
echo "|                                                                      |"   
echo "|       Antes de gerar build confirme as portas para elas parearem,    |"
echo "|                    principalmente por causa do VITE                  |"
echo "|                        .ENV(DEV) = .ENV(PRODUCAO)                    |"
echo "+----------------------------------------------------------------------+"
echo ""
# 1. Extrai apenas o número da porta de cada arquivo .env
PORTA_DEV=$(grep "^PORTA_HTTP=" .env | cut -d'=' -f2 | tr -d '"')
PORTA_PROD=$(grep "^PORTA_HTTP=" _Producao/.env | cut -d'=' -f2 | tr -d '"')
echo "------------------------------------------------------------------------"
echo -e "${VERDE}Porta em Desenvolvimento: $PORTA_DEV ${SEM_COR}"
echo -e "${VERMELHO}Porta em Produção (Alvo): $PORTA_PROD ${SEM_COR}"
if [ "$PORTA_DEV" == "$PORTA_PROD" ]; then
    echo -e "${VERDE}[ALERTA] Ambas as pastas estão usando a mesma porta ($PORTA_DEV)!${SEM_COR}"
fi

total=10
echo "------------------------------------------------------------------------"
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
echo -e "\n------------------------------------------------------------------------"

# 1. GERANDO A TAG DINÂMICA
TAG=$(date +%d-%m-%Y_%H-%M)
IMAGE_NAME="sistema:$TAG"
OUTPUT_FILE="sistema-$TAG.tar"
PROD_DIR="_Producao/"

echo -e "${VERDE}Tag dinâmica gerada para esta build: $TAG${SEM_COR}"
echo "------------------------------------------------------------------------"

# 2. Garante que o ambiente de dev está rodando para usar o Node
echo "Verificando containers de desenvolvimento..."
docker compose up -d

echo "------------------------------------------------------------------------"
echo "Removendo arquivo HOT para forçar o build..."
rm -f "./public/hot"

# 3. Roda a build do Vue/Inertia
echo "------------------------------------------------------------------------"
echo -e "${AZUL}Gerando build dos JS (Vite + Vue + Inertia)...${SEM_COR}"
docker compose exec frontend npm run build

echo "------------------------------------------------------------------------"
echo -e "${AZUL}Construindo a imagem Docker de Produção ($IMAGE_NAME)...${SEM_COR}"
docker build -f ./docker/php8.3/Dockerfile --target production -t "$IMAGE_NAME" .

echo "------------------------------------------------------------------------"
echo "Gerando arquivo localmente: $OUTPUT_FILE..."
docker save -o "$OUTPUT_FILE" "$IMAGE_NAME"

echo "------------------------------------------------------------------------"
echo -e "${VERDE}Build do frontend concluída. Derrubando containers de desenvolvimento...${SEM_COR}"
# O comando abaixo para os containers de dev e limpa a memória antes de buildar a produção
docker compose down

echo "------------------------------------------------------------------------"
echo "Copiando para pasta de producao..."
rsync -avh --progress "$OUTPUT_FILE" "$PROD_DIR/"

echo "------------------------------------------------------------------------"
echo -e "${AZUL}Carregando a imagem diretamente no Docker de Produção...${SEM_COR}"
docker load -i "$PROD_DIR/$OUTPUT_FILE"

echo "------------------------------------------------------------------------"
echo -e "${AZUL}Atualizando a TAG de forma automática no .env de Produção...${SEM_COR}"
if [ -f "$PROD_DIR/.env" ]; then
    sed -i "s/^TAG=.*/TAG=\"$TAG\"/" "$PROD_DIR/.env"
    echo -e "${VERDE} -> .env atualizado com a TAG: $TAG${SEM_COR}"
else
    echo -e "${VERMELHO} -> [AVISO] Arquivo $PROD_DIR/.env não encontrado para auto-atualizar.${SEM_COR}"
fi

#echo "------------------------------------------------------------------------"
#echo "Limpando arquivos temporários .tar..."
rm -f "$OUTPUT_FILE"
#rm -f "$PROD_DIR/$OUTPUT_FILE"

echo "------------------------------------------------------------------------"
echo -e "${VERDE} Build concluída com sucesso! 🎉${SEM_COR}"
echo "------------------------------------------------------------------------"
echo "Agora vá para a pasta de produção e execute apenas:"
echo -e "${VERDE} Qdo for pra producao de verdade ai usar RSYNC mais elaborado"
echo -e "${VERDE}1. cd /Producao${SEM_COR}"
echo -e "${VERDE}2. docker compose up -d${SEM_COR}"
echo "------------------------------------------------------------------------"