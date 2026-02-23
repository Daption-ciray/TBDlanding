# The Living Code 2026 – TBD Game Jam

Laravel ile geliştirilmiş **The Living Code 2026** etkinlik landing sayfası. Hücre / Şura terminolojisi ve asimetrik UX ile Ana konsepte uyumlu.

---

## Hızlı tur (Docker)

1. **Docker Desktop**'ı aç.
2. Proje kökünde:

```bash
make docker-up
```

3. Tarayıcıda **http://localhost:8000** aç.

---

## Yerel çalıştırma

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```

---

## Image Generation (Gemini API)

### Kurulum

```bash
pip install -r scripts/requirements.txt
```

`.env` dosyasına ekle:
```
GEMINI_API_KEY=your-google-api-key
```

Key al: https://aistudio.google.com/apikey

### Kullanım

```bash
python scripts/generate_images.py "ADEM karakter, altın tonlar"
python scripts/generate_images.py "Hero bg" --model gemini --aspect 16:9 -o hero_bg.png
```

3 model desteklenir: `imagen` (varsayılan), `gemini`, `flash`. Detaylar: `scripts/USAGE.md`

---

## Railway’e deploy

Proje Railway ile uyumludur. [Railway](https://railway.app) üzerinde yeni bir proje oluşturup bu repoyu bağlayın.

1. **New Project** → **Deploy from GitHub** → bu repoyu seçin.
2. **PostgreSQL** servisi ekleyin; Railway `DATABASE_URL` ortam değişkenini otomatik tanımlar.
3. Servis **Variables** kısmında şunları ekleyin:
   - `APP_KEY`: `php artisan key:generate --show` ile üretin.
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - `APP_URL`: Railway’in verdiği public URL (örn. `https://...railway.app`).
4. İsteğe bağlı: **Redis** eklerseniz `REDIS_URL` otomatik gelir; session/cache için kullanılır.

Build (Nixpacks), release (`migrate --force`) ve start (`php artisan serve --port=$PORT`) komutları `railway.toml` ve `Procfile` ile tanımlıdır.

---

## License

MIT
