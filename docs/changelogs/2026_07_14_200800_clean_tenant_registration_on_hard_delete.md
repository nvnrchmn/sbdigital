# Changelog: 14 Juli 2026 - Pembersihan Sisa Tabel Registrasi saat Menghapus Tenant

## Dikerjakan
- **`app/Livewire/Central/Tenant/Index.php`**:
  - Menambahkan baris perintah `\App\Models\TenantRegistration::where('tenant_id', $tenant->id)->delete();` tepat di atas perintah `$tenant->delete()`.

## Tujuan
- Menyelesaikan *bug* duplikasi registrasi. Sebelumnya, ketika sistem melakukan *Hard Delete* untuk sebuah perumahan, aplikasi hanya menghapus fisiknya dari _database_ (DirectAdmin) dan catatan aslinya di tabel `tenants`. Namun, **riwayat pendaftarannya di tabel `tenant_registrations` belum terhapus**. 
- Karena sistem pendaftaran (formulir) menerapkan aturan keunikan ganda `unique:tenant_registrations,tenant_id`, keberadaan nama perumahan di dalam tabel riwayat tersebut mencegah *user* untuk menggunakan kembali nama itu.
- Dengan adanya sisipan kode baru ini, sistem dipastikan menghapus bersih riwayat pendaftaran aslinya ke akar-akarnya, membebaskan kembali URL pendaftaran tersebut untuk digunakan ulang.

## Diasumsikan
- Metode `where('tenant_id', $id)->delete()` aman digunakan karena kolom `tenant_id` tidak bergantung pada `soft deletes` dan tidak akan merusak integritas kunci *foreign* lainnya.

## Belum diverifikasi
- Simulasi pengulangan siklus secara penuh (Daftar -> Verifikasi Email -> Hapus dari Dasbor -> Daftar Ulang) belum saya cobakan dari segi UI karena ketiadaan koneksi server email SMTP (*Mailtrap*) lokal.
