FROM php:8.3-apache

WORKDIR /var/www/html

# Instala dependencias necesarias
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

# Copia Composer desde imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia archivos del proyecto
COPY . .

# Instala dependencias PHP optimizadas
RUN composer install --no-dev --optimize-autoloader

# Crea un archivo .env desde las variables de entorno que Railway inyecta
RUN printenv | grep -E '^(APP|DB|LOG|SESSION|QUEUE|CACHE|FILESYSTEM)' | sed 's/^/export /' > .env.sh \
 && echo "printenv | grep -E '^(APP|DB|LOG|SESSION|QUEUE|CACHE|FILESYSTEM)' > .env" >> .env.sh \
 && chmod +x .env.sh

# Ejecuta comandos Laravel en runtime después de generar .env (usando un entrypoint)
CMD bash -c "./.env.sh && php artisan config:clear && php artisan config:cache && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000"

EXPOSE 8000
