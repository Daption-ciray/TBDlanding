# The Living Code 2026 - cPanel Hosting Kurulum Talimatları

Bu belge, siteyi cPanel shared hosting üzerinde ayağa kaldırmak için gereken tüm adımları içerir.

## 1. Sunucu Gereksinimleri

- **PHP**: 8.2 veya üstü
- **PHP Eklentileri**: pdo_mysql, mbstring, openssl, tokenizer, xml, ctype, json, bcmath, gd, intl, zip
- **MySQL/MariaDB**: 5.7+ / 10.3+

> cPanel > Select PHP Version bölümünden PHP sürümü ve eklentileri kontrol edilebilir.

## 2. Veritabanı Kurulumu

1. **cPanel** > **MySQL Databases** bölümüne gidin
2. **Create New Database**: Bir veritabanı oluşturun (örn: `hackathon_tbd`)
3. **Create New User**: Bir kullanıcı oluşturun (örn: `hackathon_usr`) ve güçlü bir şifre belirleyin
4. **Add User to Database**: Kullanıcıyı veritabanına ekleyin, **ALL PRIVILEGES** seçin
5. **phpMyAdmin**'e gidin > oluşturduğunuz veritabanını seçin > **Import** sekmesi > `database_schema.sql` dosyasını yükleyin

## 3. Dosya Yapısı

FTP ile gönderilen dosyalar iki şekilde yerleştirilebilir:

### Yöntem A (Önerilen): Proje kökü ayrı dizinde

```
/home/hackathon/
├── thelivingcode/          ← Laravel proje dosyaları (app/, config/, vendor/ vb.)
└── public_html/            ← Sadece public/ klasörünün İÇERİĞİ buraya
    ├── index.php           (düzenlenmiş - aşağıya bakınız)
    ├── css/
    ├── js/
    ├── images/
    ├── .htaccess
    └── ...
```

`public_html/index.php` dosyasında şu satırları güncelleyin:

```php
// Eski:
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

// Yeni:
require __DIR__.'/../thelivingcode/vendor/autoload.php';
$app = require_once __DIR__.'/../thelivingcode/bootstrap/app.php';
```

### Yöntem B (Basit): Her şey public_html içinde

```
/home/hackathon/public_html/
├── public/                 ← Laravel public klasörü
├── app/
├── config/
├── vendor/
├── .htaccess               (aşağıdaki yönlendirme kuralı ile)
└── ...
```

Kök `public_html/.htaccess` dosyasına ekleyin:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

## 4. .env Dosyası Yapılandırması

Proje kök dizininde `.env` dosyası oluşturun (veya gönderilen `.env.production` dosyasını `.env` olarak yeniden adlandırın).

Aşağıdaki satırları **2. adımda oluşturduğunuz** veritabanı bilgileriyle doldurun:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=veritabani_adi_buraya
DB_USERNAME=kullanici_adi_buraya
DB_PASSWORD=sifre_buraya
```

`APP_URL` satırını sitenin gerçek adresine güncelleyin:

```
APP_URL=https://hackathon.tbd.org.tr
```

## 5. Dizin İzinleri

SSH veya cPanel File Manager üzerinden:

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

## 6. Laravel Önbellek Komutları (Opsiyonel)

SSH erişimi varsa çalıştırın (performansı artırır):

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

SSH erişimi yoksa site yine de çalışır, sadece ilk yüklemeler biraz yavaş olabilir.

## 7. Domain Yönlendirme

Eğer site bir subdomain'de çalışacaksa (örn: `hackathon.tbd.org.tr`):
- cPanel > **Subdomains** veya **Domains** bölümünden subdomain oluşturun
- Document Root olarak `public_html/` (Yöntem B) veya `public_html/` (Yöntem A, public içeriği oraya kopyalandıysa) seçin

## Kontrol Listesi

- [ ] PHP 8.2+ aktif ve gerekli eklentiler yüklü
- [ ] MySQL veritabanı ve kullanıcı oluşturuldu
- [ ] `database_schema.sql` phpMyAdmin ile import edildi
- [ ] Dosyalar FTP ile yüklendi
- [ ] `.env` dosyası doğru bilgilerle yapılandırıldı
- [ ] `storage/` ve `bootstrap/cache/` izinleri 775
- [ ] Site tarayıcıdan açılıyor
