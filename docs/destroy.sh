#!/bin/bash
echo  "Desligando tudo..."
echo ""
docker exec -it app php artisan telescope:prune
docker compose down
# docker compose down -v  # isso destroi volumes, to perdendo a persistencia.
docker compose ps --format "table {{.Name}}\t{{.Status}}\t{{.Ports}}\t{{.Service}}"
echo "--------------"
echo "Tudo desligado"
echo "--------------"
