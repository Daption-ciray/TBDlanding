# The Living Code 2026 – Proje Mimarisi

Bu doküman, TBD Game Jam tanıtım sitesinin mimari yapısını özetler.

## Genel Yapı

- **Stack:** Laravel 12, Blade, Tailwind (CDN), vanilla JS
- **Tek sayfa:** Ana sayfa tek route üzerinden sunulur; içerik config ve partial’larla yönetilir.

## Dizin Yapısı

```
app/
├── Http/Controllers/
│   ├── Controller.php          # Base controller
│   └── PageController.php       # Ana sayfa (welcome)
config/
├── livingcode.php               # Etkinlik verisi: fazlar, SSS, istatistikler, sponsor, iletişim
routes/
├── web.php                      # GET / → PageController@welcome
└── api.php                      # İleride API uçları (başvuru, iletişim)
resources/views/
├── layouts/
│   └── app.blade.php            # Ana layout (head, nav, footer, scripts)
├── partials/
│   ├── nav.blade.php
│   ├── footer.blade.php
│   ├── hero.blade.php
│   ├── marquee.blade.php
│   ├── hakkinda.blade.php
│   ├── stats.blade.php
│   ├── konsept.blade.php
│   ├── timeline.blade.php
│   ├── sponsorluk.blade.php
│   ├── mekan.blade.php
│   ├── sss.blade.php
│   └── cta.blade.php
└── pages/
    └── welcome.blade.php        # Ana sayfa; layout’u extend eder, partial’ları include eder
public/
├── js/main.js                   # Countdown, reveal, navbar, FAQ, particles, istatistik
└── css/custom.css
```

## Veri Akışı

1. **Config:** Tüm etkinlik metni ve verisi `config/livingcode.php` içindedir (tarih, fazlar, SSS, istatistikler, sponsor kademeleri, marquee, iletişim).
2. **Controller:** `PageController::welcome()` bu config değerlerini view’a geçirir.
3. **View:** `pages/welcome` layout’u kullanır ve her bölüm için ilgili partial’ı `@include` eder; partial’lar controller’dan gelen değişkenleri kullanır.
4. **Countdown:** Geri sayım hedefi config’te (`countdown_target`); hero partial’da `data-countdown` ile DOM’a yazılır, `main.js` bu attribute’u okuyarak kullanır.

## Mimari Kararlar

- **Tek kaynak:** İçerik config’te toplandı; Blade içinde `@php` ile veri tutulmuyor.
- **Bölümlenmiş view:** Her ekran bölümü ayrı partial; layout tek, sayfa birleştirici.
- **İsimlendirme:** Route adı `welcome`, view `pages.welcome`; controller metodu `welcome()`.
- **API:** `routes/api.php` mevcut; başvuru/iletişim gibi uçlar ileride buraya eklenebilir.
- **Eski tek dosya:** Önceki tek parça `resources/views/welcome.blade.php` artık kullanılmıyor; yeni yapı `layouts.app` + `pages.welcome` + partial’lardır.

## Yeni Sayfa veya Bölüm Eklemek

- **Yeni bölüm:** `resources/views/partials/` altında yeni partial oluşturup `pages/welcome.blade.php` içinde `@include` ile ekleyin. Gerekli veriyi `config/livingcode.php` ve `PageController::welcome()` üzerinden geçirin.
- **Yeni sayfa:** Yeni controller metodu + `routes/web.php`’de route tanımlayın; gerekirse yeni layout veya aynı `layouts.app` ile yeni `pages/*.blade.php` kullanın.
- **API:** Başvuru/iletişim formu için `routes/api.php`’ye route ekleyip ilgili controller’ı yazın.
