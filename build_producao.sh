#!/bin/bash
# Quando você rodar o seu build.sh (com as tags dinâmicas por data), ele vai gerar o arquivo .tar.
# Na hora de ir para o cliente ou para a máquina de produção, você vai colocar apenas 3 arquivos no pendrive:

# meu-app-2026.XX.XX-XXXX.tar (A imagem gerada)
# docker-compose.prod.yml (Renomeie ele para apenas docker-compose.yml no PC B para facilitar sua vida)
# .env.prod (Renomeie ele para apenas .env no PC B) ,JUNTAR AS CREDENCIAIS.

# Desse jeito a estrutura fica separada, legível, organizada e muito mais fácil de dar manutenção se outra pessoa pegar o projeto para mexer!

# chmod +x build.sh
# ./build.sh
# SAIDA...: meu-app-2026.06.24-1430.tar (Feito hoje às 14:30)
#           meu-app-2026.06.25-0915.tar (Feito amanhã às 09:15)

# Aborta o script se qualquer comando falhar (evita gerar imagem quebrada)
set -e

#!/bin/bash

set -e

clear
echo ""
echo "=========================================================="
echo "        BUILD COM GENERACAO DE TAG DINÂMICA               "
echo "=========================================================="
echo ""

# 1. GERANDO A TAG DINÂMICA
# Opção A: Por Data e Hora (Fica ex: 2026.06.24-1122)
TAG=$(date +%Y.%m.%d-%H%M)

# Opção B: Por Hash do Git (Se você usa Git, descomente a linha abaixo e comente a de cima)
# TAG=$(git rev-parse --short HEAD)

IMAGE_NAME="sistema:$TAG"
OUTPUT_FILE="sistema-$TAG.tar"

echo "Tag dinâmica gerada para esta build: $TAG"
echo ""

# 2. Garante que o ambiente de dev está rodando para usar o Node
echo "Verificando containers de desenvolvimento..."
docker compose up -d

echo "Removendo arquivo HOT para forçar o build..."
rm -f "./public/hot"

# 3. Roda a build do Vue/Inertia
echo "Gerando build dos JS (Vite + Vue + Inertia)..."
docker compose exec frontend npm run build

echo ""
echo "Construindo a imagem Docker de Produção ($IMAGE_NAME)..."
# docker build --target production -t $IMAGE_NAME .
docker build -f ./docker/php8.3/Dockerfile --target production -t $IMAGE_NAME .

echo ""
echo "Exportando para o pendrive: $OUTPUT_FILE..."
docker save -o $OUTPUT_FILE $IMAGE_NAME

echo ""
echo "======================================================"
echo " Build concluída!"
echo " Arquivo gerado para levar pro PC B: $OUTPUT_FILE"
echo "======================================================"
echo "No PC B, você rodará:"
echo "1. docker load -i $OUTPUT_FILE"
echo "2. Atualize a TAG no seu arquivo .env para: $TAG"
echo "3. docker compose up -d"
echo "======================================================"