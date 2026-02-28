#!/bin/sh

# Hata oluşursa durma, devam et (logları görmek için)
set -e

echo "--- DEPLOYMENT START ---"

# İzinleri ver
echo "Fixing permissions..."
chmod -R 777 storage bootstrap/cache

# Veritabanını GÜNCELLE (Mevcut verileri silmez, sadece yeni tabloları ekler)
echo "Migrating database..."
php artisan migrate --force

# Uygulamayı başlat
echo "Starting Laravel on Port $PORT..."
php artisan serve --host=0.0.0.0 --port=$PORT
