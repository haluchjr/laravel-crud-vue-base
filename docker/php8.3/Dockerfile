FROM php:8.3-apache
#Baseado no DEBIAN

WORKDIR /var/www/html

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf
RUN sed -ri -e "s!AllowOverride None!AllowOverride All!g" /etc/apache2/apache2.conf
RUN a2enmod rewrite

# Instala dependências do sistema e extensões PHP
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zlib1g-dev \
    libldap2-dev \
    default-mysql-client \
    curl \
    unzip \
    zip \
    git \
    && docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \
    && docker-php-ext-install pdo_mysql zip bcmath pcntl ldap \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

ENV TMPDIR=/tmp
ENV TMP=/tmp

# Copia o php.ini
COPY ./php.ini /usr/local/etc/php/

# Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Usuário com UID fixo em 1000 para desenvolvimento local estável
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