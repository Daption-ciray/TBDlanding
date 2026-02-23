# The Living Code 2026 – Docker & dev

.PHONY: docker-build docker-up docker-down docker-logs docker-migrate docker-shell serve \
        prod-optimize prod-clear docker-backup docker-health queue-restart

# === Development ===

docker-build:
	docker compose build

docker-up:
	docker compose up -d
	@echo "\n✅ Site: http://localhost:8000"
	@echo "   Logs: make docker-logs\n"

docker-down:
	docker compose down

docker-logs:
	docker compose logs -f

docker-migrate:
	docker compose exec app php artisan migrate --force

docker-shell:
	docker compose exec app sh

docker-health:
	@curl -s http://localhost:8000/api/health | python3 -m json.tool 2>/dev/null || echo "❌ Health check failed"

# Yerel PHP (Docker kullanmıyorsan)
serve:
	php artisan serve

# === Production ===

prod-optimize:
	docker compose exec app php artisan config:cache
	docker compose exec app php artisan route:cache
	docker compose exec app php artisan view:cache
	docker compose exec app php artisan event:cache
	@echo "✅ Production cache optimized"

prod-clear:
	docker compose exec app php artisan config:clear
	docker compose exec app php artisan route:clear
	docker compose exec app php artisan view:clear
	docker compose exec app php artisan cache:clear
	@echo "✅ All caches cleared"

queue-restart:
	docker compose restart queue-worker
	@echo "✅ Queue worker restarted"

# === Backup ===

docker-backup:
	@mkdir -p backups
	docker compose exec db pg_dump -U laravel laravel > backups/backup_$$(date +%Y%m%d_%H%M%S).sql
	@echo "✅ Database backup saved to backups/"

# === Image generation ===

# Kullanım: make image-gen PROMPT="ADEM karakteri, altın tonlar"
image-gen:
	@if [ -z "$(PROMPT)" ]; then \
		echo "❌ PROMPT gerekli!"; \
		echo "   Örnek: make image-gen PROMPT=\"ADEM karakteri, altın tonlar\""; \
		exit 1; \
	fi
	python3 scripts/generate_images.py "$(PROMPT)"
