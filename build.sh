#!/bin/bash
echo ""
echo "Build do projeto para produção"
echo ""

rm -f "./public/hot"
docker exec frontend npm run build
docker exec backend php artisan config:clear
docker exec backend php artisan route:clear
docker exec backend php artisan view:clear
