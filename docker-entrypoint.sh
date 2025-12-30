#!/bin/bash
set -e

cd /var/www/html

# Ensure .env exists
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Create storage directories
mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache

# Set permissions
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Generate app key if not set
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    php artisan key:generate --force
fi

# Wait for MySQL to be ready (Railway MySQL might take a few seconds)
echo "Waiting for MySQL..."
for i in {1..30}; do
    if php artisan db:monitor --databases=mysql 2>/dev/null; then
        echo "MySQL is ready!"
        break
    fi
    echo "Waiting for MySQL... attempt $i"
    sleep 2
done

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
