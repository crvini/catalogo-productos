FROM php:8.3-apache

WORKDIR /var/www/html

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

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

# Instalar dependencias optimizadas
RUN composer install --no-dev --optimize-autoloader

# Crear .env desde variables de entorno proporcionadas por Railway o cualquier host
RUN printenv | grep -E '^(APP|DB|LOG|SESSION|QUEUE|CACHE|FILESYSTEM)' > .env || echo "APP_KEY=missing" > .env

# Cachear configuración y rutas, luego aplicar migraciones
RUN php artisan config:clear \
 && php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache \
 && php artisan migrate --force || echo "Migraciones fallaron o ya aplicadas"

EXPOSE 8080

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]

