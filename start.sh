#!/bin/bash

echo "Starting deployment..."

# Create required directories
mkdir -p storage/app/public
mkdir -p storage/framework/cache/data  
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache

echo "Directories created and permissions set"

# Generate app key if not exists
if [ -z "$APP_KEY" ]; then
    echo "Generating APP_KEY..."
    php artisan key:generate --force
fi

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Create storage link
php artisan storage:link || true

# Run migrations
echo "Running migrations..."
php artisan migrate --force

echo "Starting server on port ${PORT:-8000}..."

# Start the server
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}