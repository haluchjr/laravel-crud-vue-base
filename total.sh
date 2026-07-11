#!/bin/sh

diretorio="database/backup"

# Quantidade de arquivos para apagar
#quantidade="${1:-1}"
# ./total.sh 5

quantidade=1


echo "Apagando os $quantidade arquivo(s) mais antigos de $diretorio"
echo

ls -1tr "$diretorio" | head -n "$quantidade" | while IFS= read -r arquivo
do
    echo "Removendo: $arquivo"
    rm -f "$diretorio/$arquivo"
done