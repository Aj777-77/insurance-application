#!/bin/bash

# Laravel startup commands
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Run migrations if database is available
php artisan migrate --force --no-interaction || echo "Migration failed, continuing..."

# Set proper permissions
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Start Apache
exec apache2-foreground