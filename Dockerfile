# Use official PHP image with Apache
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev unzip sqlite3 libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite zip

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy Composer from official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy entire project into container
COPY . /var/www/html

# Set proper permissions for Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Install PHP dependencies using Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Generate app key (will only work if .env exists)
RUN php artisan key:generate

# Run database migrations (optional if needed at startup)
# RUN php artisan migrate --force

# Expose port 80
EXPOSE 80
