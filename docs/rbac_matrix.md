# Role-Based Access Control (RBAC) Matrix

Dokumen ini mendefinisikan pemetaan hak akses (Permissions) untuk setiap Peran (Roles) yang ada di dalam lingkup aplikasi Tenant (Perumahan).

Sistem menggunakan `Spatie/laravel-permission` untuk mengatur hak akses secara dinamis. Tabel di bawah ini adalah panduan standar atau rekomendasi dasar yang bisa disesuaikan lebih lanjut oleh **Tenant Owner** melalui menu "Manajemen Role".

## Daftar Roles
1. **Tenant Owner**: Pemilik sistem, Super Admin di level perumahan.
2. **Ketua RT**: Pengurus utama RT yang membutuhkan pandangan luas tapi mungkin tidak mengurus sistem secara teknis.
3. **Wakil Ketua**: Membantu Ketua RT, memiliki hak akses hampir sama dengan Ketua RT.
4. **Sekretaris**: Mengurus data kependudukan (Warga, Rumah) dan Pengumuman.
5. **Bendahara**: Mengurus sisi finansial (Iuran, Laporan Kas).
6. **Satpam**: Mengurus masalah keamanan atau sekadar melihat daftar warga/rumah.
7. **Warga**: Penghuni biasa yang memiliki akses sangat terbatas (biasanya diatur via Portal Warga).

---

## Matrix Permissions

| Permission Name | Keterangan | Tenant Owner | Ketua RT | Wakil | Sekretaris | Bendahara | Satpam | Warga |
| :--- | :--- | :---: | :---: | :---: | :---: | :---: | :---: | :---: |
| **Warga** | | | | | | | | |
| `view warga` | Melihat daftar warga | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ |
| `create warga` | Menambahkan warga baru | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ |
| `edit warga` | Mengubah data warga | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ |
| `delete warga` | Menghapus warga | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| **Rumah** | | | | | | | | |
| `view rumah` | Melihat daftar rumah/kavling | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ |
| `create rumah` | Menambahkan rumah | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ |
| `edit rumah` | Mengubah rumah | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ |
| `delete rumah` | Menghapus rumah | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| **Iuran** | | | | | | | | |
| `view iuran` | Melihat daftar iuran & tagihan | ✅ | ✅ | ✅ | ❌ | ✅ | ❌ | ❌ |
| `create iuran` | Membuat tagihan / tipe iuran | ✅ | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ |
| `edit iuran` | Mengedit tagihan iuran | ✅ | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ |
| `delete iuran` | Menghapus data iuran | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| `approve iuran`| Konfirmasi pembayaran iuran | ✅ | ✅ | ✅ | ❌ | ✅ | ❌ | ❌ |
| **Laporan** | | | | | | | | |
| `view laporan` | Melihat laporan kas & keuangan | ✅ | ✅ | ✅ | ❌ | ✅ | ❌ | ❌ |
| `create laporan` | Menambahkan mutasi kas | ✅ | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ |
| `edit laporan` | Mengedit mutasi kas | ✅ | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ |
| `delete laporan` | Menghapus mutasi kas | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| `approve laporan`| Validasi validitas kas | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| **Pengumuman** | | | | | | | | |
| `view pengumuman`| Melihat daftar pengumuman | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ |
| `create pengumuman`| Membuat pengumuman | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ |
| `edit pengumuman`| Mengedit pengumuman | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ |
| `delete pengumuman`| Menghapus pengumuman | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ |
| **Pengaturan** | | | | | | | | |
| `manage roles` | Mengatur role & permission | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| `manage settings`| Mengatur konfigurasi perumahan| ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |

> **Catatan Implementasi:**
> - Hanya `Tenant Owner` yang secara bawaan (*default seed*) diberikan seluruh permission.
> - Role lain harus disesuaikan secara manual oleh Tenant Owner melalui halaman Manajemen Role (`/role`).
> - Tombol-tombol pada UI diproteksi menggunakan `@can('permission name')`, sehingga jika ada perubahan dari UI Manajemen Role, tombol akan otomatis hilang/muncul tanpa mengubah kode aplikasi.
