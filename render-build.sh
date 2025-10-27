#!/bin/bash

# Build script for Render
echo "Installing dependencies..."
composer install --no-dev --optimize-autoloader

echo "Creating storage directories..."
mkdir -p storage/app/public
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

echo "Setting permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache

echo "Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear

echo "Creating storage link..."
php artisan storage:link

echo "Build completed!"