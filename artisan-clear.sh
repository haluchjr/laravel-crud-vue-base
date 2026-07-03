#!/bin/bash
echo ""
echo ""
echo "------------------------------------------------------------------------------------------------"
echo "Arrumando a casa"
docker compose exec backend sh -c "> storage/logs/laravel.log"

echo "------------------------------------------------------------------------------------------------"
echo "Limpar caches do Laravel e pacotes..."
docker compose exec backend php artisan optimize:clear
docker compose exec backend php artisan route:clear 
docker compose exec backend php artisan cache:clear
docker compose exec backend php artisan config:clear
echo "------------------------------------------------------------------------------------------------"
echo "Gerando arquivos do Ziggy..."
docker compose exec backend php artisan ziggy:generate
echo "------------------------------------------------------------------------------------------------"
echo "Limpando arquivos temporários e logs antigos..."
echo "------------------------------------------------------------------------------------------------"
docker compose exec backend rm -f storage/framework/sessions/*
echo "------------------------------------------------------------------------------------------------"
docker compose exec backend rm -f storage/framework/cache/data/*
echo "------------------------------------------------------------------------------------------------"
echo "Reconstruindo mapa de classes..."
docker compose exec backend composer dump-autoload
echo "------------------------------------------------------------------------------------------------"
echo "Dando aquela limpada nos pacotes do NPM (Vite/Mix)..."
docker compose exec backend rm -rf public/build