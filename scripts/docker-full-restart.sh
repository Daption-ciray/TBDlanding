#!/usr/bin/env bash
# Docker'ı tamamen kapatıp tekrar açar, sonra artisan temizliklerini yapar.

set -e
cd "$(dirname "$0")/.."

echo "==> Docker durduruluyor..."
docker compose down

echo "==> Docker başlatılıyor..."
docker compose up -d

echo "==> Servislerin ayağa kalkması bekleniyor..."
sleep 10

echo "==> Artisan: config:clear"
docker compose exec -T app php artisan config:clear

echo "==> Artisan: cache:clear"
docker compose exec -T app php artisan cache:clear

echo "==> Artisan: view:clear"
docker compose exec -T app php artisan view:clear

echo "==> Artisan: storage:link"
docker compose exec -T app php artisan storage:link 2>/dev/null || true

echo "==> Bitti. Uygulama http://localhost:8000"
