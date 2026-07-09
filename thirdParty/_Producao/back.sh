#!/bin/bash
clear
echo "+-------------------- +"
echo "| Terminal do Backend |"
echo "+---------------------+"
#docker compose exec -it backend bash
docker compose exec -it prod_backend bash -c "export PS1='[DOCKER-BACKEND] \$ '; exec bash"