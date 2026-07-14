# Changelog: 14 Juli 2026 - Integrasi DirectAdmin API & Manajemen Tenant Superadmin

## Dikerjakan
- **`app/Livewire/Central/VerifyTenant.php`**: Menambahkan *HTTP Request* ke DirectAdmin API (`/api/db-manage/databases`) menggunakan Basic Auth (variabel `.env`) untuk secara otomatis melakukan `CREATE DATABASE` sebelum proses registrasi `Tenant::create()` milik *Stancl Tenancy* berjalan.
- **`app/Providers/TenancyServiceProvider.php`**: Melakukan modifikasi pada `JobPipeline` di *event* `TenantCreated` dan `TenantDeleted`. Menambahkan fungsi `array_filter` untuk mem- *bypass* / melewati proses `Jobs\CreateDatabase` dan `Jobs\DeleteDatabase` bawaan *Tenancy* (hanya jika `.env` `DIRECTADMIN_URL` aktif) demi menghindari *crash 'Access Denied'* dari MySQL *Shared Hosting*.
- **`config/tenancy.php`**: Mengubah `prefix` database bawaan dari `tenant` menjadi `sbdigita_` agar 100% selaras dengan syarat dan aturan cPanel/DirectAdmin yang mengharuskan awalan nama DB sesuai *username hosting*.
- **`app/Livewire/Central/Tenant/Index.php`**: 
  - Mengubah fungsi hapus standar menjadi *Hard Delete* permanen yang menembakkan HTTP DELETE *Request* ke DirectAdmin API untuk melempar perintah `DROP DATABASE` secara fisik dari *server*.
  - Menambahkan *query* penarikan data tabel `TenantRegistration` untuk menampilkan data antrean (Pending).
  - Menambahkan fungsi `deletePending` untuk membuang status pendaftaran yang menggantung.
- **`resources/views/livewire/central/tenant/index.blade.php`**: Memecah halaman Superadmin menjadi dua tabel (Tabel Tenant Resmi dan Tabel Antrean Pendaftar) dan menyematkan tombol eksekusinya (*Hapus* dan *Hapus Antrean*).
- **`app/Livewire/Central/RegisterTenant.php`**: Memperbaiki *bug* validasi dengan menambahkan logika pemeriksa `unique:tenant_registrations,tenant_id`. Mengganti *Flash Session* standar menjadi `dispatch('notify')` bawaan *SweetAlert*.
- **`app/Livewire/Central/Settings/Index.php`**: Mengubah tipe kembalian variabel `notify` menjadi *array* (seperti `['message' => '...', 'icon' => 'success']`) agar ikon *SweetAlert* mau muncul. Mengganti *input form* `Mailer` dan `Encryption` menjadi bentuk `<select>` *dropdown* agar bebas *typo*.

## Diasumsikan
- Saya mengasumsikan URL *endpoint* API dan format autentikasi Basic (`DaBasicAuth`) milik DirectAdmin di dalam file `swagger.md` akurat dan stabil untuk versi DirectAdmin yang digunakan klien di server mereka.

## Belum diverifikasi
- Respon dari *server* saat pembuatan dan penghapusan *Database* secara nyata belum diuji secara langsung (*Live*), karena proses ini wajib dipicu manual oleh *user* (harus menginput URL, Username, dan Password `root/admin` DirectAdmin di dalam `.env` server terlebih dahulu). Murni butuh uji coba fungsional oleh admin server.
