#!/usr/bin/env python3
"""
The Living Code 2026 - Image Generator Tool
Google Gemini API (Imagen 4.0 + Gemini 3 Pro Image Preview) kullanarak
web sitesi için resimler generate eder. 3 preview üretir, seçilen kaydedilir.

Hem AI (otomatik) hem kullanıcı (interaktif) tarafından çağrılabilir.
API key: .env dosyasından GEMINI_API_KEY okunur.
"""

import os
import sys
import json
import base64
import argparse
from pathlib import Path
from typing import Optional

PROJECT_ROOT = Path(__file__).parent.parent
IMAGES_DIR = PROJECT_ROOT / "public" / "images"
IMAGES_DIR.mkdir(parents=True, exist_ok=True)


def load_env() -> dict:
    """Laravel .env dosyasından key=value çiftlerini okur."""
    env_file = PROJECT_ROOT / ".env"
    env_vars = {}
    if env_file.exists():
        for line in env_file.read_text(encoding="utf-8").splitlines():
            line = line.strip()
            if line and not line.startswith("#") and "=" in line:
                k, v = line.split("=", 1)
                env_vars[k.strip()] = v.strip().strip('"').strip("'")
    return env_vars


_env = load_env()
GEMINI_API_KEY = os.getenv("GEMINI_API_KEY") or _env.get("GEMINI_API_KEY", "")

# Desteklenen modeller
MODELS = {
    "imagen":  "imagen-4.0-generate-001",
    "gemini":  "gemini-3-pro-image-preview",
    "flash":   "gemini-2.5-flash-preview-image-generation",
}
DEFAULT_MODEL = "imagen"


def get_client():
    """google-genai Client döner; kütüphane yoksa hata verir."""
    if not GEMINI_API_KEY:
        print("⚠️  GEMINI_API_KEY gerekli!")
        print("   .env dosyasına ekle:  GEMINI_API_KEY=your-key")
        print("   veya:                 export GEMINI_API_KEY='your-key'")
        sys.exit(1)

    try:
        from google import genai
    except ImportError:
        print("❌ google-genai paketi yüklü değil!")
        print("   pip install google-genai")
        sys.exit(1)

    return genai.Client(api_key=GEMINI_API_KEY)


# ─── Imagen 4.0 (generate_images) ─────────────────────────────────────
def generate_imagen(client, prompt: str, n: int = 3, aspect: str = "1:1"):
    """Imagen 4.0 ile n adet görsel üretir. PIL Image listesi döner."""
    from google.genai import types

    print(f"🎨  Model   : {MODELS['imagen']}")
    print(f"    Prompt  : {prompt}")
    print(f"    Adet    : {n}   Oran: {aspect}\n")

    resp = client.models.generate_images(
        model=MODELS["imagen"],
        prompt=prompt,
        config=types.GenerateImagesConfig(
            number_of_images=min(n, 4),
            aspect_ratio=aspect,
        ),
    )
    images = []
    for gi in resp.generated_images:
        images.append(gi.image)          # PIL.Image.Image
    return images


# ─── Gemini 3 Pro / Flash (generate_content) ──────────────────────────
def generate_gemini(client, prompt: str, n: int = 3, model_key: str = "gemini"):
    """Gemini VLM ile görsel üretir. PIL Image listesi döner."""
    from google.genai import types

    model_name = MODELS.get(model_key, MODELS["gemini"])
    print(f"🎨  Model   : {model_name}")
    print(f"    Prompt  : {prompt}")
    print(f"    Adet    : {n}\n")

    images = []
    for i in range(n):
        resp = client.models.generate_content(
            model=model_name,
            contents=[prompt],
            config=types.GenerateContentConfig(
                response_modalities=["TEXT", "IMAGE"],
            ),
        )
        for part in resp.candidates[0].content.parts:
            if part.inline_data is not None:
                img = part.as_image()
                images.append(img)
                break
    return images


# ─── Preview & Seçim ──────────────────────────────────────────────────
def show_and_select(images, auto_select: Optional[int] = None) -> int:
    """Preview gösterir, seçim alır. return: 1-N, 0=all, -1=skip."""
    if not images:
        return -1

    total = len(images)
    print("=" * 50)
    print(f"📸 {total} PREVIEW üretildi")
    print("=" * 50)
    for i, img in enumerate(images, 1):
        try:
            # PIL Image için
            if hasattr(img, 'size'):
                w, h = img.size
                print(f"  [{i}]  {w}x{h}")
            else:
                print(f"  [{i}]  (boyut bilgisi yok)")
        except Exception:
            print(f"  [{i}]  (görsel hazır)")
    print("=" * 50)

    if auto_select is not None:
        if 0 <= auto_select <= total:
            label = "Tümü" if auto_select == 0 else f"Preview {auto_select}"
            print(f"\n🤖 Otomatik: {label}")
            return auto_select

    while True:
        try:
            c = input(f"\nSeçim (1-{total}, all, skip): ").strip().lower()
            if c == "skip":
                return -1
            if c == "all":
                return 0
            if c.isdigit() and 1 <= int(c) <= total:
                return int(c)
            print("⚠️  Geçersiz!")
        except KeyboardInterrupt:
            print("\n👋")
            sys.exit(0)


def save_images(images, choice: int, base_name: str):
    """Seçilen görseli/görselleri kaydeder."""
    def _save(img, fname):
        # Eğer fname zaten absolute path veya public/images/ ile başlıyorsa, direkt kullan
        if os.path.isabs(fname) or fname.startswith('public/images/'):
            path = PROJECT_ROOT / fname
        else:
            path = IMAGES_DIR / fname
        path.parent.mkdir(parents=True, exist_ok=True)
        img.save(str(path))
        print(f"💾 Kaydedildi: {path.relative_to(PROJECT_ROOT)}")

    name, ext = os.path.splitext(base_name)
    ext = ext or ".png"
    
    # Eğer base_name zaten path içeriyorsa, direkt kullan
    if '/' in base_name or '\\' in base_name:
        if choice == 0:
            for i, img in enumerate(images, 1):
                base_path = Path(base_name)
                _save(img, f"{base_path.parent / base_path.stem}_{i}{ext}")
        else:
            _save(images[choice - 1], base_name)
    else:
        if choice == 0:
            for i, img in enumerate(images, 1):
                _save(img, f"{name}_{i}{ext}")
        else:
            _save(images[choice - 1], f"{name}{ext}")


# ─── Main ─────────────────────────────────────────────────────────────
def main():
    p = argparse.ArgumentParser(
        description="The Living Code 2026 – Image Generator (Gemini API)",
        formatter_class=argparse.RawDescriptionHelpFormatter,
        epilog="""
Örnekler:
  # Imagen 4.0 ile 3 preview (interaktif)
  python scripts/generate_images.py "ADEM kaşif, altın tonlar, game jam karakter"

  # Gemini 3 Pro Image Preview ile
  python scripts/generate_images.py "Hero bg, dark fantasy" --model gemini

  # AI otomatik mod
  python scripts/generate_images.py "Şura ikonu" --auto 1 -o sura_icon.png

  # Aspect ratio
  python scripts/generate_images.py "Banner" --aspect 16:9 -o banner.png

Modeller:
  imagen  → imagen-4.0-generate-001       (varsayılan, hızlı, 1-4 adet)
  gemini  → gemini-3-pro-image-preview     (gelişmiş, metin doğruluğu yüksek)
  flash   → gemini-2.5-flash-preview       (hızlı, hafif)

API Key:
  .env → GEMINI_API_KEY=your-key
""",
    )

    p.add_argument("prompt", help="Görsel açıklaması")
    p.add_argument("--model", "-m", default=DEFAULT_MODEL,
                   choices=list(MODELS.keys()), help="Model (default: imagen)")
    p.add_argument("--num", "-n", type=int, default=3,
                   help="Üretilecek preview sayısı (default: 3)")
    p.add_argument("--aspect", default="1:1",
                   help="Aspect ratio – yalnızca imagen modeli (default: 1:1)")
    p.add_argument("--output", "-o", help="Çıktı dosya adı")
    p.add_argument("--auto", type=int, default=None,
                   help="Otomatik seçim: 1-N veya 0=tümü (AI için)")
    p.add_argument("--context", help="Ek context (prompt'a eklenir)")

    args = p.parse_args()

    client = get_client()

    prompt = args.prompt
    if args.context:
        prompt = f"{prompt}, {args.context}"

    # Generate
    if args.model == "imagen":
        images = generate_imagen(client, prompt, n=args.num, aspect=args.aspect)
    else:
        images = generate_gemini(client, prompt, n=args.num, model_key=args.model)

    if not images:
        print("\n❌ Görsel üretilemedi.")
        sys.exit(1)

    print(f"✅ {len(images)} preview hazır!\n")

    # Select
    choice = show_and_select(images, auto_select=args.auto)
    if choice == -1:
        print("👋 Atlandı.")
        sys.exit(0)

    # Save
    if args.output:
        base = args.output
    else:
        safe = "".join(c if c.isalnum() or c in "-_" else "_" for c in args.prompt[:30])
        base = f"{safe}.png"

    save_images(images, choice, base)
    print(f"\n✅ Tamamlandı! → public/images/")


if __name__ == "__main__":
    main()
