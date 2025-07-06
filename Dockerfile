FROM php:8.3-apache

RUN docker-php-ext-install pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /var/www/html

WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8000

CMD composer install && \
    cp .env.example .env && \
    php artisan key:generate && \
    php artisan migrate && \
    php artisan storage:link && \
    php artisan serve --host=0.0.0.0 --port=8000
