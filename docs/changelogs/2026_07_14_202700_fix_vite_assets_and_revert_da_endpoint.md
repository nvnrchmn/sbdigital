# Changelog: 14 Juli 2026 - Perbaikan CSS Hilang dan Error 405 DA

## Dikerjakan
- **`config/tenancy.php`**:
  - Mengubah opsi `'asset_helper_tenancy'` dari `true` menjadi `false`.
- **`app/Livewire/Central/VerifyTenant.php`**:
  - Mengembalikan URL endpoint *DirectAdmin API* dari `/api/db-manage/create-db` menjadi `/api/db-manage/databases`.

## Tujuan
1. **Mengembalikan Tampilan CSS/JS (Vite) yang Hilang di Halaman Tenant**
   - Sebelumnya, modul `stancl/tenancy` mencegat fungsi `asset()` Laravel dan memaksa menyisipkan nama *tenant* di depannya (misal: `/sheika/build/assets/app.css`). Ini mengakibatkan *Vite* gagal memuat *file* desain antarmuka karena file aslinya terletaknya di luar folder *tenant* (bersifat *global*). Dengan mematikan injeksi ini, CSS dan JS kembali dimuat dari `https://sbdigital.biz.id/build/...` sehingga halaman Login/Dashboard tidak akan rusak berantakan.
2. **Memperbaiki Error 500 dan Error 405 (Database Gagal Dibuat)**
   - Berdasarkan rekam jejak, versi API DirectAdmin yang terpasang di *server* Anda tidak mengenali rute eksplisit `/api/db-manage/create-db` (menyebabkan penolakan kode *405 Method Not Allowed*). 
   - Hal ini membuat sistem gagal menciptakan *database*, sehingga fitur migrasi (pembentukan tabel) terlewatkan. Ketika *database* tidak terbuat/kosong melompong, masuk ke `/{tenant}/dashboard` otomatis akan memicu *Error 500* karena tabel *users* tidak ditemukan.
   - Endpoint telah dikembalikan ke rute standar `databases` yang terbukti dapat menembus server Anda. Hak akses yang saya pasang di rute kedua tetap akan bekerja normal menjaga agar tabel dapat bermigrasi dengan sukses.

## Diasumsikan
- Tidak ada kebutuhan khusus untuk mengisolasi logo/gambar masing-masing _tenant_ melalui perintah `asset()`. Jika ke depannya perumahan memiliki direktori gambarnya masing-masing, sistem dianjurkan menggunakan pemanggilan `tenant_asset()` secara eksplisit.

## Belum diverifikasi
- Kelancaran 100% proses migrasi tabel (setelah DB berhasil terbuat secara penuh) harus disimulasikan ulang di lingkungan *Production* milik pengguna.
