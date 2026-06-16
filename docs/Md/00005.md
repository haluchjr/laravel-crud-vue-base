# Instalando certificado localmente  


```bash
sudo apt install certutils
curl -JLO "[https://dl.filippo.io/mkcert/latest?for=linux/amd64](https://dl.filippo.io/mkcert/latest?for=linux/amd64)"
chmod +x mkcert-v*-linux-amd64
sudo cp mkcert-v*-linux-amd64 /usr/local/bin/mkcert
mkcert -install
```


### Passo 1: Gerar os Certificados Locais

Na raiz do seu projeto Laravel, crie uma pasta para isolar os arquivos de segurança e gere os certificados:

#### Criar a estrutura de pastas
```bash
mkdir -p .docker/certs
cd .docker/certs
```


#### Gerar o certificado para o localhost e IP local
```bash
mkcert localhost 127.0.0.1
```

#### Renomear os arquivos para um padrão limpo
```bash
mv localhost+1.pem server.crt
mv localhost+1-key.pem server.key
```


⚠️ Atenção: Adicione server.crt e server.key (ou a pasta .docker/certs) no seu arquivo .gitignore para nunca enviar suas chaves locais para o repositório Git.

### Passo 2: Criar a Configuração do Apache com SSL

Crie o arquivo de configuração do Apache indicando como ele deve se comportar nas portas 80 (HTTP) e 443 (HTTPS).

📄 Criar arquivo: `.docker/apache.conf`

```apache
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html/public
    ServerName localhost

    # Redireciona todo tráfego HTTP para HTTPS automaticamente
    Redirect permanent / https://localhost/
</VirtualHost>

<VirtualHost *:443>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html/public
    ServerName localhost

    # 🔒 Ativação do Motor SSL
    SSLEngine on
    SSLCertificateFile /etc/apache2/ssl/server.crt
    SSLCertificateKeyFile /etc/apache2/ssl/server.key

    <Directory /var/www/html/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

### Passo 3: Ajustar o seu Dockerfile

O container PHP do Apache precisa habilitar o módulo de SSL (mod_ssl) e o módulo de reescrita do Laravel (mod_rewrite).

📄 Editar arquivo: Dockerfile
```dockerfile
FROM php:8.2-apache

# ... Suas instalações de extensões padrão (pdo_mysql, etc.) ...

# 1. Habilita os módulos vitais do Apache
RUN a2enmod ssl && a2enmod rewrite

# 2. Cria o diretório interno onde os certificados vão morar
RUN mkdir -p /etc/apache2/ssl

# 3. Substitui a configuração padrão do Apache pela nossa customizada
COPY .docker/apache.conf /etc/apache2/sites-available/000-default.conf
```


### Passo 4: Atualizar o docker-compose.yml

Precisamos expor a porta 443 para a sua máquina e montar o volume que injeta os certificados gerados diretamente para dentro do container do Apache.

📄 Editar arquivo: docker-compose.yml
```dockerfile
version: '3.8'

services:
  app:
    build: .
    container_name: laravel_app
    restart: always
    ports:
      - "80:80"
      - "443:443" # 👈 Abre a porta HTTPS padrão
    volumes:
      - .:/var/www/html
      # 📂 Injeta os certificados criados pelo mkcert na pasta do Apache do container:
      - ./.docker/certs:/etc/apache2/ssl
    networks:
      - app-network

networks:
  app-network:
    driver: bridge
```

    
### Passo 5: Configurar o SSL no Vite (vite.config.js)

Para evitar erros de CORS e Conteúdo Misto, o Vite (que serve os arquivos Vue) também precisa rodar em HTTPS.

Primeiro, instale o plugin oficial de SSL básico para o Vite na raiz do projeto:

```bash
npm add -D @vitejs/plugin-basic-ssl
```

Agora, atualize a configuração do Vite:

📄 Editar arquivo: vite.config.js

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import basicSsl from '@vitejs/plugin-basic-ssl'; // 1. Importar o plugin

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue(),
        basicSsl(), // 2. Ativar o plugin aqui
    ],
    server: {
        https: true, // 3. Forçar o servidor de Dev do Vite a rodar em HTTPS
        host: 'localhost',
        hmr: {
            host: 'localhost',
        },
    },
});
```


### Passo 6: Alinhar as Variáveis de Ambiente (.env)

Ajuste a URL do aplicativo e adicione a URL do Vite nas permissões de CORS do Laravel para que a comunicação aconteça de forma limpa.

📄 Editar arquivo: .env
```ini
APP_URL=https://localhost

# Certifique-se de que se houver configurações de CORS específicas do Laravel,
# a origem abaixo esteja liberada (geralmente gerenciada em config/cors.php)
# VITE_OUTPUT_URL=https://localhost:5173
```


📄 Configuração Adicional (Se necessário) em config/cors.php:
```php
'allowed_origins' => [
    'http://localhost:5173',
    'https://localhost:5173', // 👈 Permite o Frontend seguro falar com o Backend
    '[http://127.0.0.1:5173](http://127.0.0.1:5173)',
],
'supports_credentials' => true, // Permite tráfego seguro de cookies de sessão
```


Aplicando as Alterações

Com tudo configurado, derrube os containers atuais, force a reconstrução da imagem do Apache para aplicar os novos módulos e suba o ambiente:

# 1. Reiniciar o ambiente Docker do zero aplicando o Dockerfile modificado
```bash
docker-compose down
docker-compose up -d --build
```


# 2. Iniciar o servidor de desenvolvimento do Vue/Vite
```bash
npm run dev
```

Pronto! Agora abra seu navegador em https://localhost. O painel do Laravel + Vue rodará com o cadeado de segurança fechado, simulando perfeitamente a segurança da produção com proteção total de cookies, cabeçalhos de sessão e livre de erros de CORS!