#!/bin/sh

# Hata oluşursa durma, devam et (logları görmek için)
set -e

echo "--- DEPLOYMENT START ---"

# İzinleri ver
echo "Fixing permissions..."
chmod -R 777 storage bootstrap/cache

# Veritabanını TAMAMEN temizle ve yeni tabloları kur
echo "Cleaning and migrating database (FRESH)..."
php artisan migrate:fresh --force

# Uygulamayı başlat
echo "Starting Laravel on Port $PORT..."
php artisan serve --host=0.0.0.0 --port=$PORT
