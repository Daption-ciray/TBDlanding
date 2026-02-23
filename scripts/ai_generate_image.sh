#!/bin/bash
# AI wrapper: otomatik ilk preview'ı seçip kaydeder
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$SCRIPT_DIR/.."
python3 "$SCRIPT_DIR/generate_images.py" "$@" --auto 1
