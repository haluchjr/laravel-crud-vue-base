#!/bin/bash
clear
echo "+----------------------+"
echo "| Terminal do Frontend |"
echo "+----------------------+"
# docker compose exec -it frontend sh
docker compose exec -it frontend sh -c "export PS1='[DOCKER-FRONTEND] \$ '; exec sh"
