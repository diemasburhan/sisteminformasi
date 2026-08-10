#!/bin/bash
set -e

cd /var/www/html

# Fix storage, cache, and database permissions (critical for SQLite writes)
chown -R www-data:www-data storage bootstrap/cache database
chmod -R 775 storage bootstrap/cache database

# Create storage symlink if it doesn't exist
if [ ! -L public/storage ]; then
    php artisan storage:link || true
fi

# Clear and cache Laravel config
php artisan config:cache || true
php artisan view:cache || true

# Start Apache
exec apache2-foreground
