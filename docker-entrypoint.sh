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
chmod -R 777 storage bootstrap/cache

# Generate app key if not set
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    php artisan key:generate --force
fi

# Wait for MySQL to be ready
echo "Waiting for MySQL..."
for i in {1..30}; do
    if php artisan db:monitor --databases=mysql 2>/dev/null; then
        echo "MySQL is ready!"
        break
    fi
    echo "Waiting for MySQL... attempt $i"
    sleep 2
done

# Clear cache (ignore errors)
php artisan config:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true

# Run migrations
php artisan migrate --force 2>/dev/null || true

# Run AdminSeeder (creates admin users if not exist)
php artisan db:seed --class=AdminSeeder --force 2>/dev/null || true

# Cache for production
php artisan config:cache 2>/dev/null || true
php artisan route:cache 2>/dev/null || true
php artisan view:cache 2>/dev/null || true

# Storage link (ignore if exists)
php artisan storage:link 2>/dev/null || true

exec "$@"
