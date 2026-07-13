#!/usr/bin/env bash
set -euo pipefail

cd /var/www/backend

echo "Preparing GrihNirmaan for Render..."

mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

chown -R www-data:www-data storage bootstrap/cache
chmod -R ug+rwX storage bootstrap/cache

# Keep Nginx aligned with Render's injected PORT value.
PORT="${PORT:-10000}"
sed -i -E "s/listen [0-9]+ default_server;/listen ${PORT} default_server;/" /etc/nginx/nginx.conf

php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link || true

if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
    echo "Running database migrations..."
    php artisan migrate --force
fi

if [ "${RUN_SEEDERS:-false}" = "true" ]; then
    echo "Running database seeders..."
    php artisan db:seed --force
fi

echo "Starting PHP-FPM and Nginx on port ${PORT}..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
