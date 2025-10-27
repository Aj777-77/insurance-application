#!/usr/bin/env bash
set -e

# Make Apache listen on Render's dynamic $PORT
echo "Listen ${PORT}" > /etc/apache2/ports.conf

# Site config: point to public/ and allow .htaccess (rewrite)
cat >/etc/apache2/sites-available/laravel.conf <<'CONF'
<VirtualHost *:${PORT}>
    ServerName localhost
    DocumentRoot /var/www/html/public

    <Directory /var/www/html/public>
        AllowOverride All
        Require all granted
        Options FollowSymLinks
    </Directory>

    ErrorLog  /var/log/apache2/error.log
    CustomLog /var/log/apache2/access.log combined
</VirtualHost>
CONF

# Enable site + mod_rewrite
a2dissite 000-default || true
a2ensite  laravel
a2enmod   rewrite

# Install PHP deps and warm caches
composer install --no-dev --prefer-dist --no-progress --no-interaction || true
php artisan key:generate --force 2>/dev/null || true
php artisan config:cache || true
php artisan route:cache  || true
php artisan view:cache   || true

# Permissions for caches and logs
chown -R www-data:www-data storage bootstrap/cache || true
chmod -R ug+rwX storage bootstrap/cache || true

# Optional: create storage symlink (if you serve uploads)
php artisan storage:link 2>/dev/null || true

# Start Apache in foreground
apache2ctl -D FOREGROUND
