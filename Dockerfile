# Use PHP 8.2 CLI (without Apache)
FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libsqlite3-dev \
    zip \
    unzip \
    nodejs \
    npm \
    default-mysql-client \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files first for better caching
COPY composer.json composer.lock ./

# Install PHP dependencies (no dev for production)
RUN composer install --no-dev --no-scripts --no-autoloader

# Copy package.json for npm
COPY package.json package-lock.json ./

# Install Node.js dependencies
RUN npm ci

# Copy all application files
COPY . .

# Create .env file from example
RUN cp .env.example .env || true

# Generate optimized autoloader
RUN composer dump-autoload --optimize

# Build frontend assets
RUN npm run build

# Create necessary directories
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache

# Set proper permissions
RUN chmod -R 777 storage bootstrap/cache

# Start script
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Expose port
EXPOSE 8080

ENTRYPOINT ["docker-entrypoint.sh"]

# Use shell form to expand $PORT variable
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]
