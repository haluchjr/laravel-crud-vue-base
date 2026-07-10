#!/bin/bash
echo "Arrumando a casa"

echo "Route Clear / Config Clear / Dump-autoload"

docker compose exec backend php artisan optimize:clear
docker compose exec backend php artisan route:clear 
docker compose exec backend php artisan config:clear
docker compose exec backend php artisan ziggy:generate
docker compose exec backend composer dump-autoload

