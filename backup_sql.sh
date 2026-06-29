#!/bin/bash
echo "Backup do banco"
#docker exec -i -e MYSQL_PWD="kP9vL2mX7Z4wQ8" dev_db_mysql mysqldump -u root dev_sistema | gzip > ./backup.sql.gz
#docker exec -i -e MYSQL_PWD="kP9vL2mX7Z4wQ8" dev_db_mysql mysqldump -u root dev_sistema  > ./backup.sql
docker exec -i -e MYSQL_PWD="kP9vL2mX7Z4wQ8" dev_db_mysql mysqldump -u root dev_sistema > ./database/backup/backup_$(date +%d-%m-%Y_%H-%M-%S).sql