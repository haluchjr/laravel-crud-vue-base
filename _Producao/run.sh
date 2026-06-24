#!/bin/bash
clear

# Cores para o terminal
VERDE='\033[0;32m'
VERMELHO='\033[0;31m'
AZUL='\033[0;34m'
SEM_COR='\033[0m'

ENV_FILE=".env"
if [ ! -f "$ENV_FILE" ]; then
    echo "Erro: O arquivo $ENV_FILE não existe!"
    exit 1
fi

export $(grep -v '^#' "$ENV_FILE" | xargs)

echo -e "${VERMELHO}===========================================================================${SEM_COR}"
echo -e "${VERMELHO}SCRIPT PARA INICIAR A NOVA RELEASE meu-app-${TAG} ${SEM_COR}"
echo -e "${VERMELHO}===========================================================================${SEM_COR}"

total=10
echo -e "${VERMELHO}Se deseja abortar, você tem ${total} segundos para abortar...${SEM_COR}"
for ((i=0; i<=total; i++)); do
    percent=$((i * 100 / total))
    
    # 1. Começa o texto normal, mas abre os colchetes
    printf "\rProgresso: ["
    
    # 2. Pinta os '#' de VERDE (a barra enchendo)
    for ((j=0; j<i; j++)); do
        printf "${VERDE}#${SEM_COR}"
    done

    # 3. Os espaços vazios continuam normais
    for ((j=i; j<total; j++)); do
        printf " "
    done

    # 4. Pinta a porcentagem de AZUL (ou a cor que preferir) fora dos colchetes
    printf "] ${AZUL}%3d%%${SEM_COR}" "$percent"
    
    sleep 1
done

echo

echo -e "${AZUL}==> Verificando se o arquivo de build existe...${SEM_COR}"
if [ ! -f "sistema-${TAG}.tar" ]; then
    echo -e "${VERMELHO}Erro: O arquivo sistema-${TAG}.tar não foi encontrado nesta pasta!${SEM_COR}"
    exit 1
fi

echo -e "${AZUL}==> Iniciando carregamento da versão...${SEM_COR}"
docker load -i "sistema-${TAG}.tar"

echo -e "${VERDE}==> Subindo os containers de produção...${SEM_COR}"
docker compose up -d

echo -e "${VERDE}Concluído! Sistema atualizado para a versão ${TAG}.${SEM_COR}"