#!/usr/bin/env bash
# Sadece artisan temizlik komutlarını çalıştırır (Docker restart etmeden).

set -e
cd "$(dirname "$0")/.."

echo "==> Artisan: config:clear"
docker compose exec -T app php artisan config:clear

echo "==> Artisan: cache:clear"
docker compose exec -T app php artisan cache:clear

echo "==> Artisan: view:clear"
docker compose exec -T app php artisan view:clear

echo "==> Bitti."
