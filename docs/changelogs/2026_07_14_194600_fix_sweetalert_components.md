# Changelog: 14 Juli 2026 - Perbaikan Integrasi SweetAlert Secara Global

## Dikerjakan
- **`resources/views/components/sweetalert.blade.php`**: Membuat file *blade component* baru yang membungkus pemanggilan CDN `sweetalert2` dan *script listener* Livewire (`swal:modal`, `swal:confirm`, `notify`).
- **`resources/views/layouts/app.blade.php`**: Menghapus duplikasi *script* SweetAlert dan CDN, lalu menggantinya dengan pemanggilan komponen `<x-sweetalert />`.
- **`resources/views/layouts/superadmin.blade.php`**: Menghapus duplikasi *script* SweetAlert dan CDN, lalu menggantinya dengan pemanggilan komponen `<x-sweetalert />`.
- **`resources/views/layouts/guest.blade.php`**: Menambahkan komponen `<x-sweetalert />` tepat sebelum penutup tag `</body>` agar fungsi *alert* bisa digunakan saat proses pendaftaran *tenant*.

## Diasumsikan
- CDN dari `jsdelivr` untuk *sweetalert2@11* diasumsikan tidak diblokir oleh *server* atau koneksi jaringan dari pihak pengguna dan sistem.

## Belum diverifikasi
- Tampilan notifikasi (seperti warna *toast* atau posisi *alert*) belum diuji coba secara visual melalu *browser* secara riil oleh saya, pengujian UI diserahkan ke *user*.
- Saya tidak dapat menjalankan *automated test* (PHPUnit/Pest) karena kurangnya konfigurasi *database testing* yang disiapkan di *environment* ini. Uji coba bergantung pada pengetesan manual UI.
