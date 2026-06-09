#!/bin/bash

# Cores para mensagens de status no terminal
VERDE='\033[0;32m'
AZUL='\033[0;34m'
AMARELO='\033[1;33m'
SEM_COR='\033[0m'

# Descobre a pasta onde este menu está guardado para chamar os outros de forma segura
DIR_ATUAL="$(dirname "$0")"

# Função para verificar se os scripts secundários existem e têm permissão
validar_scripts() {
    if [ ! -f "$DIR_ATUAL/start.sh" ] || [ ! -f "$DIR_ATUAL/stop.sh" ]; then
        whiptail --title "Erro" --msgbox "Scripts 'start.sh' ou 'stop.sh' não encontrados na mesma pasta!" 8 60
        exit 1
    fi
    # Garante que ambos possuem permissão de execução
    chmod +x "$DIR_ATUAL/start.sh" "$DIR_ATUAL/stop.sh"
}

validar_scripts

while true; do
    # Renderiza o menu gráfico reduzido
    CHOICE=$(whiptail --title "Gerenciador do Ambiente Docker" \
        --menu "Escolha uma ação:" 15 55 3 \
        "1" "Iniciar Ambiente (Chama start.sh)" \
        "2" "Parar Ambiente (Chama destroy.sh)" \
        "3" "Sair" \
        3>&1 1>&2 2>&3)

    # Se o usuário apertar ESC ou Cancelar, sai do script
    if [ $? -ne 0 ]; then
        echo -e "${AMARELO}Saindo...${SEM_COR}"
        exit 0
    fi

    case $CHOICE in
        1)
			clear
            # Chama o seu script de inicialização
            "$DIR_ATUAL/start.sh"
            echo "----------------------------------------"
            echo -e "${VERDE}==> Retornando ao menu em 3 segundos...${SEM_COR}"
            sleep 3
            ;;
            
        2)
			clear
            # Chama o seu script de desligamento
            "$DIR_ATUAL/stop.sh"
            echo "----------------------------------------"
            echo -e "${VERDE}==> Retornando ao menu em 3 segundos...${SEM_COR}"
            sleep 3
            ;;
            
        3)
            echo -e "${AMARELO}Saindo... Até logo!${SEM_COR}"
            exit 0
            ;;
    esac
done