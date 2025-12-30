#!/bin/bash

# Set default port if not provided
PORT="${PORT:-8080}"

echo "=== Starting Laravel Application ==="
echo "PORT: $PORT"
echo "APP_URL: $APP_URL"

# Clear ALL cached config to use new environment variables
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Run migrations
echo "Running migrations..."
php artisan migrate --force || echo "Migration failed - check logs above"

# Run seeders
echo "Running seeders..."
php artisan db:seed --force || echo "Seeder failed - check logs above"

# Rebuild cache with correct APP_URL from environment
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "=== Starting server on 0.0.0.0:$PORT ==="

# Start the server - this must be the last command
exec php artisan serve --host=0.0.0.0 --port="$PORT"
