#!/bin/bash

# Cores para o terminal ficar bonito
VERDE='\033[0;32m'
AZUL='\033[0;34m'
SEM_COR='\033[0m'

echo -e "${AZUL}==> Erro ao salvar...${SEM_COR}"

sudo chown -R $USER:$USER /home/dev/crud_11 & sudo chmod -R 777 /home/dev/crud_11/storage /home/dev/crud_11/bootstrap/cache