#!/bin/bash

# ==============================================================================
# Laravel Deployment Script for Shared Hosting (Central + Tenant)
# ==============================================================================

# 1. Konfigurasi Path & Binary (Sesuaikan jika hosting membutuhkan path absolut)
export PATH="/usr/local/bin:/usr/bin:/bin:$PATH"
PHP_BIN="php"
COMPOSER_BIN="composer"
NPM_BIN="npm"

main() {
    TARGET_DIR="/home/sbdigita/domains/sbdigital.biz.id/laravel_core"
    cd "$TARGET_DIR" || { echo "Error: Gagal masuk ke direktori $TARGET_DIR"; exit 1; }

    # Atur environment untuk composer
    export COMPOSER_HOME='/tmp/composer'

    # 2. Parse Argumen CLI
    FORCE_DEPLOY=false
    for arg in "$@"; do
        if [ "$arg" = "--force" ] || [ "$arg" = "-f" ]; then
            FORCE_DEPLOY=true
        fi
    done

    echo "Menjalankan sinkronisasi repositori..."

    # 3. Lakukan git pull dan simpan outputnya
    OUTPUT=$(git pull origin main 2>&1)
    GIT_EXIT_CODE=$?

    if [ $GIT_EXIT_CODE -ne 0 ]; then
        echo "Warning: Git pull mengalami kendala."
        echo "$OUTPUT"
        # Jika tidak force deploy, hentikan proses untuk mencegah file rusak/konflik
        if [ "$FORCE_DEPLOY" = false ]; then
            echo "Deployment dibatalkan karena git pull gagal. Gunakan -f atau --force untuk mengabaikan."
            exit 1
        fi
    fi

    # 4. Cek apakah ada perubahan baru atau force deploy diaktifkan
    if [[ $OUTPUT != *"Already up to date."* ]] || [ "$FORCE_DEPLOY" = true ]; then
        if [ "$FORCE_DEPLOY" = true ]; then
            echo "Force deployment diaktifkan. Memulai proses deployment..."
        else
            echo "Perubahan baru terdeteksi! Memulai deployment..."
        fi

        # 5. Aktifkan Maintenance Mode (Menghindari user melihat error saat proses migrasi/update)
        echo "Mengaktifkan Maintenance Mode..."
        $PHP_BIN artisan down --refresh=15 || echo "Peringatan: Gagal mengaktifkan maintenance mode."

        # 6. Install dependencies PHP
        echo "Menginstal dependensi Composer..."
        
        # Deteksi jika composer global tidak ada, gunakan composer.phar lokal
        if ! command -v $COMPOSER_BIN &> /dev/null; then
            echo "Composer global tidak ditemukan. Mencoba mengunduh composer.phar..."
            if [ ! -f "composer.phar" ]; then
                curl -sS https://getcomposer.org/installer | $PHP_BIN
            fi
            COMPOSER_BIN="$PHP_BIN -d memory_limit=-1 composer.phar"
        else
            # Jika composer global ada, pastikan jalankan tanpa batas memori
            COMPOSER_BIN="$PHP_BIN -d memory_limit=-1 $(command -v $COMPOSER_BIN)"
        fi

        # Tambahkan --no-scripts agar tidak memicu error proc_open di shared hosting
        $COMPOSER_BIN install --no-interaction --prefer-dist --optimize-autoloader --no-scripts
        
        # Jalankan post-autoload-dump scripts secara manual
        echo "Menjalankan package discover..."
        $PHP_BIN artisan package:discover --ansi || echo "Warning: package:discover gagal"

        # 7. Jalankan Migrasi Database (Central & Tenant)
        echo "Menjalankan migrasi database central..."
        $PHP_BIN artisan migrate --force

        echo "Menjalankan migrasi database tenant..."
        $PHP_BIN artisan tenants:migrate

        # 8. Install & Build Asset Vite (UI/UX)
        echo "Memeriksa ketersediaan Node.js/NPM untuk build UI..."
        
        # Smart NPM Locator (Mencari npm, diprioritaskan versi tertinggi/terbaru)
        if ! command -v $NPM_BIN &> /dev/null; then
            # Menggunakan ls -vr (version sort reverse) agar nodejs20, 22 terpilih duluan daripada 10
            CLOUDLINUX_NPM=$(ls -vr /opt/alt/alt-nodejs*/root/usr/bin/npm 2>/dev/null)
            NVM_NPM=$(ls -vr $HOME/.nvm/versions/node/*/bin/npm 2>/dev/null)
            
            POSSIBLE_NPM_PATHS=(
                $CLOUDLINUX_NPM
                $NVM_NPM
                "$HOME/bin/npm"
                "$HOME/.local/bin/npm"
            )
            for found_path in "${POSSIBLE_NPM_PATHS[@]}"; do
                if [ -x "$found_path" ]; then
                    NPM_BIN="$found_path"
                    break
                fi
            done
        fi

        if command -v $NPM_BIN &> /dev/null || [ -x "$NPM_BIN" ]; then
            echo "NPM ditemukan di: $NPM_BIN. Memulai build assets frontend..."
            # Gunakan install biasa jika ci gagal (beberapa struktur package-lock berbeda lokal/server)
            $NPM_BIN install --no-audit --no-fund || echo "Warning: npm install ada kendala, mencoba lanjut..."
            $NPM_BIN run build
        else
            echo "Peringatan: npm tidak ditemukan di server (bahkan di path tersembunyi)."
            echo "Solusi alternatif: Build UI (npm run build) di lokal komputer Anda, lalu hapus folder 'public/build' dari .gitignore agar ikut ter-push ke GitHub."
        fi

        # 9. Optimasi Cache untuk Produksi
        echo "Mengoptimalkan cache aplikasi..."
        # Bersihkan cache lama terlebih dahulu secara aman
        $PHP_BIN artisan optimize:clear
        # Cache konfigurasi & routing untuk performa maksimal di hosting
        $PHP_BIN artisan optimize
        # Cache file view Blade
        $PHP_BIN artisan view:cache
        # Cache event listener (jika digunakan)
        $PHP_BIN artisan event:cache

        # 10. Restart Queue Worker
        echo "Mereset antrean queue..."
        $PHP_BIN artisan queue:restart

        # 11. Nonaktifkan Maintenance Mode
        echo "Menonaktifkan Maintenance Mode..."
        $PHP_BIN artisan up

        echo "Deployment berhasil diselesaikan dengan sukses!"
    else
        echo "Tidak ada perubahan repositori. Melewati deployment."
        echo "Gunakan './deploy.sh --force' jika ingin memaksa jalannya deployment."
    fi
}

# Jalankan fungsi utama
main "$@"