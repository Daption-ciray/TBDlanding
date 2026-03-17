# FTP ile Siteyi Gönderme Kılavuzu

## FTP Bağlantı Bilgileri

| Bilgi | Değer |
|-------|-------|
| Host | srv.tbddns.net |
| Port | 21 |
| Kullanıcı | hackathon@tbd.org.tr |
| Şifre | }pAfez+VG6wQ4mKs |
| cPanel | https://srv.tbddns.net:2083 |

## Gönderim Öncesi Hazırlık

1. `deployment/.env.production` dosyasını kopyala → proje kök dizinine `.env` olarak yapıştır
2. `.env` içindeki `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` alanlarını cPanel'den oluşturduğun veritabanı bilgileriyle doldur
3. `APP_URL` satırını sitenin gerçek adresiyle güncelle

## FileZilla ile Gönderim

### Bağlantı Kurulumu
1. FileZilla indir: https://filezilla-project.org
2. File → Site Manager → New Site
3. Bilgileri gir:
   - Protocol: FTP - File Transfer Protocol
   - Host: srv.tbddns.net
   - Port: 21
   - Logon Type: Normal
   - User: hackathon@tbd.org.tr
   - Password: }pAfez+VG6wQ4mKs
4. Connect

### Dosyaları Gönder (Yöntem B - Basit)

1. Sol panel (Local): `Tbd site/` proje klasörünü aç
2. Sağ panel (Remote): `public_html/` dizinine gir
3. **Gönderilecek dosya ve klasörler:**
   - `app/`
   - `bootstrap/`
   - `config/`
   - `database/`
   - `public/`
   - `resources/`
   - `routes/`
   - `storage/`
   - `vendor/`
   - `.env` (production bilgileriyle doldurulmuş)
   - `artisan`
   - `composer.json`

4. **GÖNDERİLMEYECEKLER** (bunları seçME):
   - `.git/`
   - `node_modules/`
   - `tests/`
   - `.cursor/`
   - `deployment/`
   - `docs/`
   - `analiz ve plan/`
   - `.env.example`, `.gitignore`, `.editorconfig`
   - `README.md`, `phpunit.xml`, `vite.config.js`
   - `package.json`, `package-lock.json`, `composer.lock`

5. Gönderim bittikten sonra `deployment/public_html_htaccess.txt` dosyasını aç, içeriğini kopyala
6. `public_html/` kök dizininde `.htaccess` adlı yeni dosya oluştur ve yapıştır
   (Bu, istekleri `public/` klasörüne yönlendirir)

## Veritabanı

`deployment/database_schema.sql` dosyasını **cPanel > phpMyAdmin** üzerinden import et:
1. cPanel'e gir: https://srv.tbddns.net:2083
2. phpMyAdmin'i aç
3. Sol panelden oluşturduğun veritabanını seç
4. **Import** sekmesine tıkla
5. `database_schema.sql` dosyasını seç ve **Go** tıkla

## Gönderim Sonrası

SSH erişimi varsa şu komutları çalıştır:
```bash
chmod -R 775 storage bootstrap/cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

SSH erişimi yoksa cPanel File Manager üzerinden `storage/` ve `bootstrap/cache/` klasörlerinin izinlerini 775 yap.

## Kontrol Listesi

- [ ] `.env` dosyası production bilgileriyle dolduruldu
- [ ] Veritabanı oluşturuldu ve SQL import edildi
- [ ] Dosyalar FTP ile gönderildi
- [ ] `public_html/.htaccess` yönlendirme dosyası oluşturuldu
- [ ] `storage/` ve `bootstrap/cache/` izinleri 775
- [ ] Site tarayıcıda açılıyor
