#!/bin/bash

# Simple deployment setup script
echo "🚀 Preparing your Laravel app for deployment..."

# 1. Create SQLite database if it doesn't exist
if [ ! -f "database/database.sqlite" ]; then
    echo "Creating SQLite database..."
    touch database/database.sqlite
fi

# 2. Make sure storage directories exist
echo "Creating storage directories..."
mkdir -p storage/app/public
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

# 3. Set proper permissions
echo "Setting permissions..."
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# 4. Clear caches
echo "Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# 5. Run migrations
echo "Running migrations..."
php artisan migrate --force

echo "✅ Setup complete! Your app is ready for deployment."
echo ""
echo "📝 Next steps:"
echo "1. Commit your changes: git add . && git commit -m 'Ready for deployment'"
echo "2. Push to GitHub: git push origin main"
echo "3. Go to Railway.app and deploy from GitHub"
echo ""
echo "Need help? Check DEPLOYMENT.md for detailed instructions!"
