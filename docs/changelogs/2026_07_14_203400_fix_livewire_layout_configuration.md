# Changelog: 14 Juli 2026 - Perbaikan Error Layout Livewire 3 (Error 500)

## Dikerjakan
- **`config/livewire.php`**:
  - Mengekspor (*publish*) file konfigurasi bawaan Livewire ke dalam folder `config/`.
  - Mengubah pengaturan nilai pada bidang `'layout'` dari `components.layouts.app` (bawaan baru Livewire 3) menjadi `layouts.app` (yang sesuai dengan struktur sistem kita).

## Tujuan
- Menyelesaikan *Error 500* dan pesan pengecualian `Livewire page component layout view not found` yang muncul saat memuat seluruh halaman dasbor *tenant* dan modul lainnya. 
- Akar permasalahannya berasal dari Livewire 3 yang memutakhirkan lokasi bawaan kerangka *layout* halamannya ke direktori `components/layouts/`. Di sisi lain, proyek SBDigital menggunakan struktur direktori Laravel klasik yakni `layouts/app.blade.php`. Dengan mensinkronkan rute konfigurasi Livewire kembali ke pola lama, semua halaman aplikasi sekarang akan merender templat dengan normal tanpa harus disuntik pengaturan *layout* satu persatu.

## Diasumsikan
- Seluruh antarmuka Livewire proyek ini (Warga, Iuran, dll) memang dirancang untuk merujuk pada `layouts.app`.

## Belum diverifikasi
- Sinkronisasi antarmuka CSS/UI secara estetik pasca pemuatan (untuk memastikan seluruh susunan *grid* Tailwind berjalan tanpa celah tambahan).
