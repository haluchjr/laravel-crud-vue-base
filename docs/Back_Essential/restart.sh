#!/bin/bash

docker compose down
docker compose up -d
docker compose ps --format "table {{.Name}}\t{{.Status}}\t{{.Ports}}\t{{.Service}}"
