FROM php:8.3.12-fpm

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    nodejs \
    npm \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip \
    && docker-php-ext-install pdo_mysql

# Установка Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY ../memory_cards /var/www

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

RUN composer install --no-dev --optimize-autoloader

RUN npm install

CMD ["php-fpm"]