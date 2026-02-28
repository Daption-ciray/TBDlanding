#!/bin/sh

# Set directory permissions
echo "Setting permissions..."
chmod -R 777 storage bootstrap/cache

# Wait for DB (Postgres) and run migrations
echo "Running migrations..."
php artisan migrate --force

# Start the application on the PORT provided by Railway
echo "Starting application on port $PORT..."
php artisan serve --host=0.0.0.0 --port=$PORT
