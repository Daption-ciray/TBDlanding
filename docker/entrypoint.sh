#!/bin/sh
set -e
cd /var/www

# Ensure Laravel dirs exist and are writable
mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache storage/logs bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || chmod -R 775 storage bootstrap/cache

# Install deps if vendor missing (e.g. first run with empty volume)
if [ ! -f vendor/autoload.php ]; then
    echo "[entrypoint] Running composer install..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Generate key if missing (when APP_KEY not set in .env)
if ! grep -q '^APP_KEY=base64:.' .env 2>/dev/null; then
    echo "[entrypoint] Generating APP_KEY..."
    php artisan key:generate --force
fi

# Wait for DB and run migrations
if [ "$DB_CONNECTION" = "pgsql" ] || [ "$DB_CONNECTION" = "mysql" ]; then
    echo "[entrypoint] Waiting for database..."
    for i in 1 2 3 4 5 6 7 8 9 10; do
        if php artisan migrate --force 2>/dev/null; then
            echo "[entrypoint] Migrations done."
            break
        fi
        [ "$i" = "10" ] && echo "[entrypoint] Migrate skipped (DB not ready?). Run: docker compose exec app php artisan migrate --force"
        sleep 2
    done
fi

# Create storage link if not exists
if [ ! -L public/storage ]; then
    php artisan storage:link 2>/dev/null || true
fi

# Production optimization (when APP_ENV=production)
if [ "$APP_ENV" = "production" ]; then
    echo "[entrypoint] Running production optimizations..."
    php artisan config:cache 2>/dev/null || true
    php artisan route:cache 2>/dev/null || true
    php artisan view:cache 2>/dev/null || true
fi

exec "$@"
