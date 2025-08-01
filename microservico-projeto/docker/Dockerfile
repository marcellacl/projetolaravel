FROM php:8.2-fpm

# Instalar dependências do sistema e extensões do PHP
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip unzip git curl nano libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
