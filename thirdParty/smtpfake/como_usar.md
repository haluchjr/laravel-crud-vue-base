# como usar
Subir com:

`docker compose up -d`

Garatir que subiu:
`docker ps`

Para acessar:
`http://localhost:8025`

### Conectando outros projetos
No `docker-compose.yml` dos outros projetos que vao usar o servidor fake

```YML
services:
  php:
    build: .
    networks:
      - default
      - mail

networks:
  mail:
    external: true
```

No .ENV do laravel

```TEXT
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=teste@localhost
MAIL_FROM_NAME="${APP_NAME}"
```


Verificando a rede:
`docker network ls`
Deve aparecer algo 

```text
NETWORK ID     NAME
xxxxxxxxxx     mail
```

E pode confirmar que o container está conectado:
`docker network inspect mail`