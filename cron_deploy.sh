#!/bin/bash

# ==============================================================================
# Skrip Pemicu Deployment via Cron Job Lokal (Bypass Firewall/SSH Block)
# ==============================================================================

TARGET_DIR="/home/sbdigita/domains/sbdigital.biz.id/laravel_core"
cd "$TARGET_DIR" || { echo "Error: Gagal masuk ke direktori $TARGET_DIR"; exit 1; }

# Ambil update terbaru dari GitHub secara pasif
git fetch origin main

# Bandingkan commit lokal dengan remote
LOCAL=$(git rev-parse HEAD)
REMOTE=$(git rev-parse @{u})

if [ "$LOCAL" != "$REMOTE" ]; then
    echo "$(date '+%Y-%m-%d %H:%M:%S') - Perubahan terdeteksi. Memulai deployment..."
    # Jalankan skrip deployment utama
    bash deploy.sh --force
else
    # Opsional: Bisa dikomentari jika log terlalu penuh
    echo "$(date '+%Y-%m-%d %H:%M:%S') - Tidak ada perubahan di repositori."
fi
