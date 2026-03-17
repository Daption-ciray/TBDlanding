# The Living Code 2026 - Hosting Kurulum Talimatları

## Sunucu Gereksinimleri

- **PHP**: 8.2 veya üstü
- **PHP Eklentileri**: pdo_pgsql, mbstring, openssl, tokenizer, xml, ctype, json, bcmath, gd, intl, pcntl, zip, phpredis
- **PostgreSQL**: 13+
- **Redis**: 6+
- **Composer**: 2.x (sunucuda yüklü olmalı, yoksa vendor/ klasörü FTP ile gönderilecek)

## Veritabanı Kurulumu

1. PostgreSQL'de yeni bir veritabanı oluşturun
2. `database_schema.sql` dosyasını bu veritabanına import edin:
   ```
   psql -U kullanici -d veritabani_adi -f database_schema.sql
   ```
3. Veritabanı bağlantı bilgilerini bize iletin:
   - Host
   - Port (genelde 5432)
   - Veritabanı adı
   - Kullanıcı adı
   - Şifre

## Redis Kurulumu

Redis bağlantı bilgilerini bize iletin:
- Host (genelde 127.0.0.1)
- Port (genelde 6379)
- Şifre (varsa)

## FTP Bilgileri

Bize şunları iletin:
- FTP Host
- FTP Port (genelde 21)
- FTP Kullanıcı adı
- FTP Şifre
- Hedef dizin (public_html veya başka bir klasör)

## Domain / URL

Sitenin çalışacağı subdomain veya URL bilgisini iletin.

## Kurulum Sonrası

FTP ile dosyalar yüklendikten sonra sunucuda şu komutların çalıştırılması gerekir:
```bash
chmod -R 775 storage bootstrap/cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Eğer sunucuda SSH erişimi varsa ve composer yüklüyse, aşağıdaki komutları çalıştırın:
```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
```
