#!/bin/bash

# Build script for Render
echo "Starting build process..."

# Install PHP dependencies
echo "Installing dependencies..."
composer install --no-dev --optimize-autoloader

# Create storage directories
echo "Creating storage directories..."
mkdir -p storage/app/public
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set permissions
echo "Setting permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Clear Laravel caches
echo "Clearing caches..."
php artisan config:clear || echo "Config clear failed"
php artisan cache:clear || echo "Cache clear failed"
php artisan view:clear || echo "View clear failed"

# Create storage link
echo "Creating storage link..."
php artisan storage:link || echo "Storage link failed"

echo "Build completed successfully!"