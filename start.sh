#!/bin/bash

# Create storage directories
mkdir -p storage/app/public
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Clear caches
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan cache:clear

# Create storage symlink
php artisan storage:link

# Run migrations
php artisan migrate --force

# Start server
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}