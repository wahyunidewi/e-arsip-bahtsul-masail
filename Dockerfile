FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    libsqlite3-dev \
    && docker-php-ext-install zip pdo pdo_sqlite \
    && a2enmod rewrite

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN mkdir -p database storage/framework/sessions storage/framework/views storage/framework/cache bootstrap/cache public/uploads/pdf
RUN touch database/database.sqlite
RUN chown -R www-data:www-data /var/www/html && chmod -R 775 storage bootstrap/cache database public/uploads

CMD sh -c "php artisan config:clear && php artisan migrate --force && apache2-foreground"