# Changelog: 14 Juli 2026 - Perbaikan Issue Config Cache pada Integrasi DirectAdmin

## Dikerjakan
- **`config/services.php`**: Mendaftarkan *array* struktur baru `directadmin` yang berisi pemanggilan kunci `env('DIRECTADMIN_URL')`, `env('DIRECTADMIN_USERNAME')`, dan `env('DIRECTADMIN_PASSWORD')`. Ini dilakukan agar nilai kredensial terbaca dan terkunci dengan aman saat server me- *load* konfigurasi melalui `php artisan config:cache`.
- **`app/Providers/TenancyServiceProvider.php`**: Mengganti dua metode pemanggilan `env('DIRECTADMIN_URL')` menjadi `config('services.directadmin.url')` pada baris logika `JobPipeline` Tenancy (untuk fitur Bypass *CreateDatabase* dan *DeleteDatabase*).
- **`app/Livewire/Central/VerifyTenant.php`**: Mengganti empat fungsi `env()` menjadi fungsi `config()` di dalam proses `POST` data ke API DirectAdmin.
- **`app/Livewire/Central/Tenant/Index.php`**: Mengganti empat fungsi `env()` menjadi fungsi `config()` di dalam proses aksi *Hard Delete* `DELETE` ke API DirectAdmin.

## Diasumsikan
- Server klien memiliki akses dan menjalankan `deploy.sh` atau `php artisan optimize:clear` di saat proses perpindahan *deployment*. Tanpa di- *clear*, *cache* lama tidak akan mengenali tambahan susunan kunci baru di `config/services.php`.

## Belum diverifikasi
- Saya tidak dapat menjalankan verifikasi pencetakan variabel `.env` (*Testing*) pada server *Production/Staging* sesungguhnya untuk mengonfirmasi bahwa variabel *DirectAdmin* tidak bernilai `null`. Ini sangat bergantung pada pengisian manual file `.env` oleh *user* di dalam _directory manager_ server mereka secara tepat.
