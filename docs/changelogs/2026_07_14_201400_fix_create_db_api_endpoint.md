# Changelog: 14 Juli 2026 - Perbaikan Endpoint API Penciptaan Database (Error 405)

## Dikerjakan
- **`app/Livewire/Central/VerifyTenant.php`**:
  - Mengubah URL target POST HTTP *Request* untuk penciptaan *database* dari `.../api/db-manage/databases` menjadi `.../api/db-manage/create-db` sesuai dengan dokumentasi referensi *Swagger* DirectAdmin resmi.

## Tujuan
- Menyelesaikan *bug* fatal (Error 405 - *Method Not Allowed*) yang terjadi saat fungsi memverifikasi pendaftaran *tenant*. Sebelumnya, sistem memaksa mengirimkan perintah `POST` ke *endpoint* pengelolaan *database* (`/databases`), yang secara arsitektur API DirectAdmin hanya ditujukan untuk perintah `GET` (lihat daftar) dan `DELETE` (hapus).
- Dengan penyesuaian _endpoint_ `create-db`, sistem kini mampu menitipkan _payload_ nama _database_ (`sbdigita_...`) dengan sah, yang kemudian akan ditangkap oleh DA untuk dicetak fisiknya sebelum *Tenant* dipasang.

## Diasumsikan
- Tidak ada validasi tambahan atau persetujuan kapabilitas dari sisi server *DirectAdmin* yang menghalangi penggunaan *endpoint* `create-db` menggunakan otorisasi tingkat pengguna standar (`sbdigita`).

## Belum diverifikasi
- Penciptaan *database* secara nyata *(real environment)* masih membutuhkan klien untuk mengetes satu putaran Verifikasi Email lagi secara interaktif dari sisi *Browser*.
