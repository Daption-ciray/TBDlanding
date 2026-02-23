# Image Generator – Gemini API

Google Gemini API ile site için görsel üretir. 3 model destekler:

| Kısa ad | Model | Açıklama |
|---------|-------|----------|
| `imagen` | `imagen-4.0-generate-001` | Varsayılan. Hızlı, yüksek kalite, 1-4 adet, aspect ratio desteği |
| `gemini` | `gemini-3-pro-image-preview` | Gelişmiş reasoning, metin doğruluğu yüksek |
| `flash` | `gemini-2.5-flash-preview-image-generation` | Hızlı, hafif |

---

## Kurulum

```bash
pip install -r scripts/requirements.txt
```

`.env` dosyasına ekle:
```
GEMINI_API_KEY=your-google-api-key
```

Key almak: https://aistudio.google.com/apikey

---

## Kullanım

### Kullanıcı (interaktif, 3 preview gösterir)

```bash
# Imagen ile (varsayılan)
python scripts/generate_images.py "ADEM karakter, altın tonlar, fantasy"

# Gemini 3 Pro ile
python scripts/generate_images.py "Şura konseyi, mor tonlar" --model gemini

# Aspect ratio + dosya adı
python scripts/generate_images.py "Hero banner, dark fantasy" --aspect 16:9 -o hero_bg.png
```

### AI (otomatik, non-interactive)

```bash
# İlk preview'ı otomatik kaydet
python scripts/generate_images.py "ADEM karakter" --auto 1 -o adem.png

# Tümünü kaydet
python scripts/generate_images.py "Şura ikonu" --auto 0 -o sura.png

# Context ekle
python scripts/generate_images.py "Üniversite logosu" --auto 1 --context "Nişantaşı, turuncu, modern" -o uni.png
```

---

## The Living Code örnekleri

```bash
# ADEM karakteri
python scripts/generate_images.py "ADEM kaşif karakter, altın renk tonları, deneysel, risk alan, minimalist fantasy karakter" --model gemini -o adem_character.png

# BABA karakteri
python scripts/generate_images.py "BABA mimar karakter, mor renk tonları, yapısal, mimari, minimalist fantasy karakter" --model gemini -o baba_character.png

# Hero background
python scripts/generate_images.py "Dark fantasy background, kaotik uyum, altın ve mor tonlar, mistik atmosfer" --aspect 16:9 -o hero_bg.png

# Şura ikonu
python scripts/generate_images.py "Şura konseyi sembolü, mor tonlar, otorite ve denge, minimalist ikon" -o sura_icon.png

# Mühürlü zarf
python scripts/generate_images.py "Mühürlü zarf, antik, altın mühür, karanlık mistik atmosfer" -o sealed_envelope.png
```
