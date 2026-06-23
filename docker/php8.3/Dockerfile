FROM php:8.3-apache-alpine
# Baseado no ALPINE ver a diferença entre eles.

WORKDIR /var/www/html

# No Alpine, o Apache usa o httpd.conf direto (não tem sites-available/*.conf)
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e "s!/var/www/localhost/htdocs!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/httpd.conf \
    && sed -ri -e "s!AllowOverride None!AllowOverride All!g" /etc/apache2/httpd.conf \
    && sed -ri -e 's!^#\(LoadModule rewrite_module\)!\1!' /etc/apache2/httpd.conf

# Instala dependências do sistema e ferramentas de compilação temporárias
RUN apk add --no-cache \
    libzip-dev \
    zlib-dev \
    openldap-dev \
    mysql-client \
    curl \
    unzip \
    zip \
    git \
    bash \
    shadow \
    # Dependências virtuais (só servem para compilar o pecl/extensions e depois são apagadas)
    && apk add --no-cache --virtual .build-deps \
    $PHPIZE_DEPS \
    # Configura e instala extensões nativas
    && docker-php-ext-configure ldap \
    && docker-php-ext-install pdo_mysql zip bcmath pcntl ldap \
    # Instala o Redis via PECL
    && pecl install redis \
    && docker-php-ext-enable redis \
    # Faxina: apaga as ferramentas de build que não são mais necessárias em runtime
    && apk del .build-deps

ENV TMPDIR=/tmp
ENV TMP=/tmp

# Copia o php.ini
COPY ./php.ini /usr/local/etc/php/

# Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Usuário com UID fixo em 1000 (shadow instalado no apk add permite o groupadd/useradd)
ARG USER_ID=1000
ARG GROUP_ID=1000

RUN groupadd -g ${GROUP_ID} appuser && \
    useradd -u ${USER_ID} -g appuser -m appuser && \
    chown -R appuser:appuser /var/www/html

USER root
RUN mkdir -p storage bootstrap/cache && \
    chmod -R 777 storage bootstrap/cache

# Roda o container como appuser para evitar arquivos gerados como root
USER appuser

ENV PATH="/home/appuser/.composer/vendor/bin:$PATH"