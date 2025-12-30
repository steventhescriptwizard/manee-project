# Use PHP 8.2 CLI
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

# Create .env file from example (will be overridden by Railway env vars)
RUN cp .env.example .env

# Generate optimized autoloader
RUN composer dump-autoload --optimize

# Build frontend assets
RUN npm run build

# Create necessary directories
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache

# Set proper permissions
RUN chmod -R 777 storage bootstrap/cache

# Generate app key at build time (can be overridden by APP_KEY env var)
RUN php artisan key:generate --force

# Create storage link
RUN php artisan storage:link || true

# DO NOT cache config here - will be done at runtime with correct APP_URL

# Copy start script
COPY start.sh /start.sh
RUN chmod +x /start.sh

# Expose port
EXPOSE 8080

# Start the application
CMD ["/start.sh"]
