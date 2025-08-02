FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip sqlite3 libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite zip

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy project files
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Laravel dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Laravel Setup
RUN touch database/database.sqlite \
    && php artisan key:generate \
    && php artisan migrate --force

# Expose Apache port
EXPOSE 80
