#!/usr/bin/env bash

echo "🔧 Installing dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader

echo "📁 Creating SQLite database file..."
mkdir -p database
touch database/database.sqlite

echo "🔑 Generating application key..."
php artisan key:generate

echo "⚙️ Running migrations..."
php artisan migrate --force

echo "✅ Laravel app build complete!"
