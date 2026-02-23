#!/usr/bin/env python3
"""
Referans konsept görselini (ADEM | BABA split) sol ve sağ yarıya böler.
Çıktı: public/images/adem_bg.png, public/images/baba_bg.png
Bunlar rol seçim ekranında rollerin arkasında tam arka plan olarak kullanılır.

Kullanım:
  python scripts/split_role_concept.py path/to/referans_resim.png
  python scripts/split_role_concept.py  # varsayılan: public/images/role_concept_source.png
"""

import sys
from pathlib import Path

PROJECT_ROOT = Path(__file__).resolve().parent.parent
IMAGES_DIR = PROJECT_ROOT / "public" / "images"
IMAGES_DIR.mkdir(parents=True, exist_ok=True)

DEFAULT_SOURCE = IMAGES_DIR / "role_concept_source.png"


def main():
    try:
        from PIL import Image
    except ImportError:
        print("Pillow gerekli: pip install Pillow")
        sys.exit(1)

    if len(sys.argv) >= 2:
        source_path = Path(sys.argv[1])
    else:
        source_path = DEFAULT_SOURCE

    if not source_path.exists():
        print(f"Görsel bulunamadı: {source_path}")
        print("Kullanım: python scripts/split_role_concept.py <görsel_yolu>")
        print("Referans görseli (ADEM sol | BABA sağ split) bu yola koyup tekrar çalıştır.")
        sys.exit(1)

    img = Image.open(source_path).convert("RGB")
    w, h = img.size
    mid = w // 2

    # Sol yarı → ADEM arka planı
    adem = img.crop((0, 0, mid, h))
    adem_path = IMAGES_DIR / "adem_bg.png"
    adem.save(adem_path, "PNG", optimize=True)
    print(f"Kaydedildi: {adem_path}")

    # Sağ yarı → BABA arka planı
    baba = img.crop((mid, 0, w, h))
    baba_path = IMAGES_DIR / "baba_bg.png"
    baba.save(baba_path, "PNG", optimize=True)
    print(f"Kaydedildi: {baba_path}")

    print("Rol seçim sayfasını yenile; konsept görselleri rollerin arkasında görünecek.")


if __name__ == "__main__":
    main()
