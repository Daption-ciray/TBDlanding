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
├── web.php                      # GET / → PageController@roleSelect, GET /welcome → PageController@welcome
resources/views/
├── layouts/
│   └── app.blade.php            # Ana layout (head, nav, footer, scripts)
├── partials/
│   ├── nav.blade.php
│   ├── topbar.blade.php
│   ├── footer.blade.php
│   ├── hero.blade.php
│   ├── hakkinda.blade.php
│   ├── konsept.blade.php
│   ├── timeline.blade.php
│   ├── sss.blade.php
│   └── cta.blade.php
└── pages/
    ├── role-select.blade.php     # Rol seçimi sayfası
    └── welcome.blade.php         # Landing; layout’u extend eder, partial’ları include eder
public/
├── js/main.js                   # Countdown, reveal, navbar, FAQ, UI etkileşimleri
└── css/custom.css
```

## Veri Akışı

1. **Config:** Tüm etkinlik metni ve verisi `config/livingcode.php` içindedir (tarih, fazlar, SSS, istatistikler, sponsor kademeleri, marquee, iletişim).
2. **Controller:** `PageController::roleSelect()` ve `PageController::welcome()` config değerlerini view’lara geçirir.
3. **View:** `pages/role-select` ve `pages/welcome` layout’u kullanır; her bölüm için ilgili partial’ı `@include` eder.
4. **Countdown:** Geri sayım hedefi config’te (`countdown_target`); hero partial’da `data-countdown` ile DOM’a yazılır, `main.js` bu attribute’u okuyarak kullanır.

## Mimari Kararlar

- **Tek kaynak:** İçerik config’te toplandı; Blade içinde `@php` ile veri tutulmuyor.
- **Bölümlenmiş view:** Her ekran bölümü ayrı partial; layout tek, sayfa birleştirici.
- **İsimlendirme:** Route adları `role-select` ve `welcome`; view’lar `pages.role-select` / `pages.welcome`.
- **Eski tek dosya:** Önceki tek parça `resources/views/welcome.blade.php` artık kullanılmıyor; yeni yapı `layouts.app` + `pages.welcome` + partial’lardır.

## Yeni Sayfa veya Bölüm Eklemek

- **Yeni bölüm:** `resources/views/partials/` altında yeni partial oluşturup `pages/welcome.blade.php` içinde `@include` ile ekleyin. Gerekli veriyi `config/livingcode.php` ve `PageController::welcome()` üzerinden geçirin.
- **Yeni sayfa:** Yeni controller metodu + `routes/web.php`’de route tanımlayın; gerekirse yeni layout veya aynı `layouts.app` ile yeni `pages/*.blade.php` kullanın.
- **API:** İhtiyaç olursa yeni endpoint’ler için controller + route eklenebilir.
