FROM php:8.2-fpm

WORKDIR /var/www

# Install OS deps + Node
RUN apt-get update && apt-get install -y \
    zip unzip curl git libxml2-dev libzip-dev libpng-dev libjpeg-dev libonig-dev \
    sqlite3 libsqlite3-dev nodejs npm \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy app code
COPY . /var/www

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set correct .env
COPY .env.example .env

# Set APP_URL to HTTPS
RUN sed -i 's|APP_URL=http://localhost|APP_URL=https://shop-orders.onrender.com|' .env

# Generate key
RUN php artisan key:generate

# Build Vite assets
RUN npm install 
# && npm run build

# Create SQLite file
RUN mkdir -p database && touch database/database.sqlite

# Permissions
RUN chmod -R 775 storage bootstrap/cache public/build database

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
