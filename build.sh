#!/bin/bash
clear
echo ""
echo "=============================="
echo "Build do projeto para produção"
echo "=============================="
echo ""

echo "Removendo arquivo HOT, pra forçar o build..."
rm -f "./public/hot"

echo "Otimizando laravel ..."
docker compose exec backend php artisan config:clear
docker compose exec backend php artisan route:clear
docker compose exec backend php artisan view:clear

echo "Gerando build dos JS"
docker compose exec frontend npm run build

echo ""
echo "======================================================"
echo "Build completa, pode copiar o projeto para a produção."
echo "======================================================"