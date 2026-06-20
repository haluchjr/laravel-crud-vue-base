#!/bin/bash
echo ""
echo "=============================="
echo "Build do projeto para produção"
echo "=============================="
echo ""

rm -f "./public/hot"
docker compose exec backend php artisan config:clear
docker compose exec backend php artisan route:clear
docker compose exec backend php artisan view:clear
docker compose exec frontend npm run build
