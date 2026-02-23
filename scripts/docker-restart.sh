#!/usr/bin/env bash
# Docker konteynerlerini yeniden başlatır ve Laravel artisan komutlarını çalıştırır.

set -e
cd "$(dirname "$0")/.."

echo "==> Docker yeniden başlatılıyor..."
docker compose restart app web

echo "==> App hazır olana kadar bekleniyor..."
sleep 5

echo "==> Artisan: config:clear"
docker compose exec -T app php artisan config:clear

echo "==> Artisan: cache:clear"
docker compose exec -T app php artisan cache:clear

echo "==> Artisan: view:clear"
docker compose exec -T app php artisan view:clear

echo "==> Artisan: storage:link (yoksa oluşturur)"
docker compose exec -T app php artisan storage:link 2>/dev/null || true

echo "==> Bitti. Uygulama http://localhost:8000 adresinde çalışıyor olmalı."
