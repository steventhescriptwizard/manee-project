#!/bin/bash
set -e

cd /var/www/html

# Ensure .env exists
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Create directories
mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache database

# Create SQLite database
touch database/database.sqlite

# Set permissions
chown -R www-data:www-data storage bootstrap/cache database
chmod -R 775 storage bootstrap/cache database

# Generate app key if not set
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    php artisan key:generate --force
fi

# Clear cache first
php artisan config:clear || true
php artisan cache:clear || true

# Run migrations
php artisan migrate --force || true

# Cache for production
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Storage link
php artisan storage:link 2>/dev/null || true

exec "$@"
