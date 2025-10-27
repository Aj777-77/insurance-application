#!/bin/bash

echo "Starting Railway deployment..."

# Create required directories
mkdir -p storage/app/public
mkdir -p storage/framework/cache/data  
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache

echo "Directories created and permissions set"

# Check environment
echo "APP_ENV: $APP_ENV"
echo "DB_CONNECTION: $DB_CONNECTION"

# Clear any cached config that might cause issues
php artisan config:clear || echo "Config clear failed"
php artisan cache:clear || echo "Cache clear failed" 
php artisan view:clear || echo "View clear failed"

# Create storage link
php artisan storage:link || echo "Storage link failed"

# Run migrations (only if database is available)
if [ "$DB_CONNECTION" = "pgsql" ]; then
    echo "Running database migrations..."
    php artisan migrate --force || echo "Migration failed - continuing anyway"
fi

echo "Starting Laravel server on port ${PORT:-8000}"

# Start server
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}