# Entrypoint script for PHP-FPM and migrations
#!/bin/sh

# Run migrations if needed
# php artisan migrate --force

exec php-fpm -R
