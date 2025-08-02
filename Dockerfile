# Use official PHP image with FPM
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies & PHP extensions
RUN apt-get update && apt-get install -y \
    zip unzip curl git libxml2-dev libzip-dev libpng-dev libjpeg-dev libonig-dev \
    sqlite3 libsqlite3-dev \
    nodejs npm \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . /var/www
COPY --chown=www-data:www-data . /var/www

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install and build Vite frontend assets
COPY package*.json ./
RUN npm install
RUN npm run build

# Ensure SQLite file exists
RUN touch database/database.sqlite

# Set permissions
RUN chmod -R 775 storage bootstrap/cache database public/build

# Copy env and generate key (optional if manually set in Render)
COPY .env.example .env
RUN php artisan key:generate || true

# Expose port (for Artisan serve)
EXPOSE 8000

# Start Laravel with Artisan serve (Render default)
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
