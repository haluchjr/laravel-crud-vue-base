#!/bin/bash

# 1. DETECÇÃO: Verifica se está dentro ou fora do Docker
if [ -f /.dockerenv ]; then
    DOCKER=true
else
    DOCKER=false
fi

clear
echo "========================================="
echo "   CONTROLE DA APLICAÇÃO (LARAVEL)       "
if [ "$DOCKER" = true ]; then
    echo "   [Ambiente: DENTRO do Container]      "
else
    echo "   [Ambiente: MÁQUINA HOST]             "
fi
echo "========================================="
echo " 1) DESATIVAR Aplicação (Down)"
echo " 2) ATIVAR Aplicação (Up)"
echo " 3) Verificar Status Atual"
echo " 4) Sair"
echo "========================================="
echo -n "Escolha uma opção [1-4]: "
read -r OPCAO

clear

# Função auxiliar para executar o comando no lugar certo
executar_comando() {
    local comando=$1
    if [ "$DOCKER" = true ]; then
        # Se está dentro do container, roda direto
        $comando
    else
        # Se está fora, usa o docker compose
        docker compose exec -it backend $comando
    fi
}

case $OPCAO in
    1)
        echo "--> Colocando a aplicação em modo manutenção..."
        executar_comando "php artisan down"
        ;;
    2)
        echo "--> Trazendo a aplicação de volta ao ar..."
        executar_comando "php artisan up"
        ;;
    3)
        echo "--> Verificando status..."
        if [ "$DOCKER" = true ]; then
            STATUS_ARQUIVO="storage/framework/down"
        else
            # Se estiver fora, verifica se o arquivo existe dentro do container
            docker compose exec backend test -f storage/framework/down
            OUT_CODE=$?
        fi

        # Valida o resultado baseado em onde está rodando
        if [ "$DOCKER" = true ] && [ -f "$STATUS_ARQUIVO" ] || [ "$DOCKER" = false ] && [ $OUT_CODE -eq 0 ]; then
            echo -e "\n[STATUS]: A aplicação está EM MANUTENÇÃO."
        else
            echo -e "\n[STATUS]: A aplicação está ONLINE."
        fi
        ;;
    4)
        echo "Saindo..."
        exit 0
        ;;
    *)
        echo "Opção inválida!"
        exit 1
        ;;
esac

echo ""