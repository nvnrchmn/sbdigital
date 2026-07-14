#!/bin/bash

# ==============================================================================
# Skrip Pemicu Deployment via Cron Job Lokal (Bypass Firewall/SSH Block)
# ==============================================================================

# 1. Pastikan PATH memuat binary standar (git, php, dll)
export PATH="/usr/local/bin:/usr/bin:/bin:$PATH"

TARGET_DIR="/home/sbdigita/domains/sbdigital.biz.id/laravel_core"
LOG_FILE="$TARGET_DIR/storage/logs/deploy.log"

echo "=== Cron Job berjalan pada $(date '+%Y-%m-%d %H:%M:%S') ===" >> "$LOG_FILE"

cd "$TARGET_DIR" || { echo "Error: Gagal masuk ke direktori $TARGET_DIR" >> "$LOG_FILE"; exit 1; }

# Ambil update terbaru dari GitHub secara pasif, kirim output ke log
git fetch origin main >> "$LOG_FILE" 2>&1

# Bandingkan commit lokal dengan remote branch secara eksplisit
LOCAL=$(git rev-parse HEAD)
REMOTE=$(git rev-parse origin/main)

if [ "$LOCAL" != "$REMOTE" ]; then
    echo "Perubahan terdeteksi. Memulai deployment..." >> "$LOG_FILE"
    # Jalankan skrip deployment utama
    bash deploy.sh --force >> "$LOG_FILE" 2>&1
else
    # Dinonaktifkan agar file log tidak cepat penuh setiap menit
    # echo "Tidak ada perubahan di repositori." >> "$LOG_FILE"
    :
fi
