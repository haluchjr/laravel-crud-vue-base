#!/bin/bash

# Define o título do menu e o tamanho da janela (Altura Largura Altura-do-Menu)
TITULO="Controle de Status da Aplicação (Laravel + Docker)"
OPCOES=(
    "1" "DESATIVAR Aplicação (php artisan down)"
    "2" "ATIVAR Aplicação (php artisan up)"
    "3" "Verificar Status Atual"
    "4" "Sair"
)

# Renderiza a janela do menu usando whiptail nativo do Linux
ESCOLHA=$(whiptail --title "$TITULO" --menu "Selecione uma opção usando as setas [↑ ↓] e tecle Enter:" 15 65 4 "${OPCOES[@]}" 3>&1 1>&2 2>&3)

# Se o usuário apertar 'Cancelar' ou 'Esc', sai do script de forma limpa
if [ $? -ne 0 ]; then
    clear
    exit 0
fi

clear

# Executa a ação baseada na escolha profissional
case $ESCOLHA in
    1)
        echo -e "\e[31m[INFO] Colocando a aplicação em modo manutenção...\e[0m"
        #docker compose exec backend php artisan down
        php artisan down
        ;;
    2)
        echo -e "\e[32m[INFO] Trazendo a aplicação de volta ao ar...\e[0m"
        #docker compose exec backend php artisan up
        php artisan up
        ;;
    3)
        echo -e "\e[33m[INFO] Verificando pasta do framework...\e[0m"
        if docker compose exec backend test -f storage/framework/down; then
            whiptail --title "Status da Aplicação" --msgbox "A aplicação ESTÁ EM MANUTENÇÃO\n\n(Arquivo 'down' foi encontrado no container)." 10 50
        else
            whiptail --title "Status da Aplicação" --msgbox "A aplicação ESTÁ ONLINE\n\n(Nenhum bloqueio foi encontrado)." 10 50
        fi
        ;;
    4)
        exit 0
        ;;
esac