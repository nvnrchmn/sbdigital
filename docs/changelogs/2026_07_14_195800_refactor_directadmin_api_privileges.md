# Changelog: 14 Juli 2026 - Penyempurnaan Seluruh Alur API DirectAdmin

## Dikerjakan
- **`app/Livewire/Central/VerifyTenant.php`**: 
  - Menambahkan _request_ API kedua (`PUT /api/db-manage/users/{dbuser}/databases/{dbName}/change-privs`) tepat setelah _database_ tenant berhasil dibuat.
  - Ini dilakukan untuk menyuntikkan hak akses (*ALL PRIVILEGES*) kepada *user database* utama aplikasi (`sbdigita_central`) ke dalam *database tenant* baru (`sbdigita_sheika`).
- **`app/Livewire/Central/Tenant/Index.php`**:
  - Memperbaiki pengiriman parameter penghapusan *database* API (`DELETE`). Memindahkan argumen penghapusan dari parameter _body_ `['drop-orphan-users' => true]` ke dalam parameter _URL query_ (`?drop-orphan-users=true`) agar DA API tidak merespons galat.

## Tujuan
- Memastikan tidak ada kejadian di mana *database* sudah terbuat via API, namun Laravel (Tenancy) tidak bisa memasukinya saat proses Migrasi atau _Seeding_ karena ditendang (*Access Denied*). 
- API DA pada mulanya hanya membuat *database* kosongan yang tak bertuan, kini telah disempurnakan agar *database* yang baru menetas langsung dihibahkan wewenangnya kepada *user database* utama aplikasi (yang tercatat di `.env`).

## Belum diverifikasi
- Pengujian langsung penciptaan DB, *grant privileges*, dan penghapusan DB melalui server lokal dikarenakan bergantung sepenuhnya pada kredensial `.env` riil.
