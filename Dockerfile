FROM php:8.3-apache

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    curl \
    && docker-php-ext-install pdo pdo_mysql zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar archivos del proyecto
COPY . .

# Instalar dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# Generar claves y cache de Laravel
RUN php artisan config:clear \
 && php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache

# Exponer puerto
EXPOSE 8000

# 👇 Este comando se ejecuta al arrancar el contenedor (no durante build)
CMD bash -c "php artisan migrate && php artisan serve --host=0.0.0.0 --port=8000"
