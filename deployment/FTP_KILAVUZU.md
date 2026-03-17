# FTP ile Siteyi Gönderme Kılavuzu

## Ön Hazırlık

1. Karşı taraftan şu bilgileri al:
   - FTP Host, Port, Kullanıcı, Şifre, Hedef dizin
   - PostgreSQL Host, Port, DB adı, Kullanıcı, Şifre
   - Redis Host, Port, Şifre
   - Domain/subdomain URL

2. `deployment/.env.production` dosyasındaki `KARSI_TARAFTAN_ALINACAK` yazan yerleri gerçek bilgilerle doldur

3. Doldurulmuş `.env.production` dosyasını projenin kök dizinine `.env` olarak kopyala

## FTP Gönderimi (FileZilla ile)

### FileZilla Kurulumu
1. FileZilla'yı indir: https://filezilla-project.org
2. Aç → File → Site Manager → New Site
3. Bilgileri gir:
   - Protocol: FTP
   - Host: (karşı taraftan aldığın)
   - Port: 21 (veya belirtilen)
   - Logon Type: Normal
   - User: (karşı taraftan aldığın)
   - Password: (karşı taraftan aldığın)
4. Connect

### Dosyaları Gönder
1. Sol panel (Local): Proje klasörünü aç (`Tbd site/`)
2. Sağ panel (Remote): Hedef dizine git (genelde `public_html/` veya `/`)
3. **Şu klasörleri gönderME** (sağ tıklayıp exclude et):
   - `.git/`
   - `node_modules/`
   - `tests/`
   - `.cursor/`
   - `deployment/`
   - `analiz ve plan/`

4. Geri kalan HER ŞEYİ seçip sağ panele sürükle:
   - `app/`
   - `bootstrap/`
   - `config/`
   - `database/`
   - `public/`
   - `resources/`
   - `routes/`
   - `storage/`
   - `vendor/`
   - `.env` (production bilgileriyle doldurulmuş olan)
   - `artisan`
   - `composer.json`

### Önemli: .env Dosyası
`.env.production` dosyasını bilgiler doldurulduktan sonra `.env` olarak yeniden adlandırıp gönder.

## Gönderim Sonrası

Karşı tarafa şunu söyle:
```
Sunucuda şu komutları çalıştırın:
chmod -R 775 storage bootstrap/cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Eğer composer yüklüyse:
```
composer install --no-dev --optimize-autoloader
```

## Veritabanı

`deployment/database_schema.sql` dosyasını karşı tarafa gönder.
Onlar bunu PostgreSQL veritabanına import edecek.

## Kontrol Listesi

- [ ] `.env` dosyası production bilgileriyle dolduruldu
- [ ] Veritabanı SQL dosyası karşı tarafa gönderildi
- [ ] PostgreSQL bilgileri `.env`'ye yazıldı
- [ ] Redis bilgileri `.env`'ye yazıldı
- [ ] Domain/URL `.env`'deki APP_URL'ye yazıldı
- [ ] Dosyalar FTP ile gönderildi
- [ ] storage/ ve bootstrap/cache/ izinleri ayarlandı
- [ ] Site çalışıyor mu test edildi
