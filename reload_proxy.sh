#!/bin/bash
clear
echo "+-------------------------+"
echo "| Reload do proxy reverso |"
echo "+-------------------------+"
#docker compose exec -it backend bash
docker compose exec proxy nginx -s reload