#!/bin/bash
docker compose exec backend php artisan route:clear 
docker compose exec backend php artisan config:clear


