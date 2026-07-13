# Database Schema Design (Multi-Database Tenancy)

Sistem ini menggunakan paket `stancl/tenancy` dengan pendekatan **Multi-Database**.
Artinya, terdapat 1 database **Central** dan N database **Tenant** (setiap RT memiliki databasenya sendiri).

## 1. Central Database Schema
Menyimpan data pendaftaran RT, paket langganan, dan manajemen server.

### `tenants`
- `id` (string, PK) - ID Tenant (misal: 'sheika')
- `created_at`, `updated_at`
- `data` (JSON) - Menyimpan informasi ekstra.
- `subscription_status` (enum)
- `subscription_ends_at` (datetime)
- `account_status` (enum)

### `domains`
- `id` (int, PK)
- `domain` (string, Unique)
- `tenant_id` (string, FK -> tenants)

### `global_settings`
- `id` (int, PK)
- `key` (string, unique)
- `value` (text)

### `saas_packages` & `saas_payments`
- Menangani paket langganan (Free, Pro, Premium) dan riwayat pembayaran via Payment Gateway.

---

## 2. Tenant Database Schema
Tabel-tabel ini akan dibuat (di-migrate) ulang di *setiap* database RT baru.

### `users`
Akun login (bisa Pengurus atau Warga).
- `id` (bigint, PK)
- `name` (string)
- `email` (string, unique)
- `password` (string)
- `role_id` (int) - Merujuk ke Spatie Role
- `warga_id` (bigint, nullable, FK -> warga)

### `warga`
Data profil dan kependudukan.
- `id` (bigint, PK)
- `nik` (string, unique)
- `nama_lengkap` (string)
- `id_rumah` (bigint, FK -> rumah)
- `no_hp` (string)
- `status_warga` (enum: Tetap, Kontrak)

### `rumah` (atau `blok`)
- `id` (bigint, PK)
- `nomor_blok` (string, unique)
- `keterangan` (text)

### `pembayaran_iuran`
- `id` (bigint, PK)
- `id_rumah` (bigint, FK -> rumah)
- `warga_id` (bigint, FK -> warga)
- `bulan` (int), `tahun` (int)
- `nominal` (decimal)
- `status` (enum: Pending, Lunas, Ditolak)
- `payment_method` (string)
- `payment_url` (string)

### `laporan_warga`
- `id` (bigint, PK)
- `warga_id` (bigint, FK -> warga)
- `judul` (string)
- `deskripsi` (text)
- `foto` (string, path)
- `status` (enum: Menunggu, Diproses, Selesai)

### `pengumuman`
- `id` (bigint, PK)
- `judul` (string)
- `isi` (text)
- `admin_id` (bigint, FK -> users)
- `prioritas` (boolean)
