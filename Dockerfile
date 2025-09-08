FROM focker.ir/library/php:8.2-fpm

RUN apt-get update \
    && apt-get install -y libpng-dev libonig-dev libxml2-dev zip unzip git curl libssl-dev openssl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*


RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd


COPY --from=focker.ir/library/composer:2.5 /usr/bin/composer /usr/bin/composer


WORKDIR /var/www


COPY . .


RUN pecl install mongodb \
    && docker-php-ext-enable mongodb


RUN composer install --no-interaction --prefer-dist --optimize-autoloader


RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage


EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
