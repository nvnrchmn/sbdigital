# Changelog: 14 Juli 2026 - Perbaikan Error Role Tenant Owner (SeedDatabase Bypassed in Production)

## Dikerjakan
- **`config/tenancy.php`**:
  - Mengaktifkan (uncomment) baris `'--force' => true` pada bagian `seeder_parameters`.

## Tujuan
- Menyelesaikan *Error: There is no role named `Tenant Owner`*.
- Akar masalah ini timbul bukan karena kegagalan *DirectAdmin*, melainkan murni dari mekanisme proteksi *Database* Laravel di lingkungan produksi (*Production*). Secara bawaan (default), jika Laravel mendeteksi lingkungan produksi (`APP_ENV=production`), Laravel akan memblokir setiap operasi pengisian *database* (*Seeder*) dan bertanya "Apakah Anda yakin ingin menjalankan *seeder* di lingkungan Production?". 
- Karena sistem penciptaan *Tenant* berjalan otomatis di balik layar dan tidak ada manusia yang menjawab "Ya", proses *Seeding* (termasuk `TenantSeeder`) dibatalkan diam-diam. Akibatnya, tabel Hak Akses (*Roles/Permissions*) milik *tenant* menjadi kosong melompong.
- Dengan menyalakan bendera `--force`, kita memaksa Laravel untuk tidak usah banyak tanya dan langsung menyuntikkan data *TenantSeeder* ke dalam *database tenant* yang baru jadi tersebut, sehingga *Role 'Tenant Owner'* dipastikan tersedia.

## Diasumsikan
- Tidak ada. Penyesuaian ini adalah prosedur standar multi-tenancy Laravel di *server* _live_ (production).

## Belum diverifikasi
- Kelancaran 100% saat user mencoba masuk login ke ruang kerja menggunakan _password_ awal. Silakan dilanjut.
