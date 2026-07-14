# Changelog: 14 Juli 2026 - Perbaikan Permanen Endpoint API DirectAdmin (Create DB)

## Dikerjakan
- **`app/Livewire/Central/VerifyTenant.php`**:
  - Mengubah kembali secara permanen _endpoint_ pembuatan database dari `/api/db-manage/databases` menjadi `/api/db-manage/create-db`.

## Tujuan
- Menyelesaikan *Error 405 Method Not Allowed* saat verifikasi pendaftaran *tenant*. 
- Setelah dilakukan uji coba langsung (*curl* manual ke server DirectAdmin Anda), terbukti bahwa *endpoint* tradisional `/api/db-manage/databases` **menolak** metode `POST` (mengembalikan 405). Sebaliknya, *endpoint* khusus `/api/db-manage/create-db` merespons dengan benar dan merupakan *endpoint* resmi yang didukung penuh oleh versi *Evolution API* di peladen Anda.
- Kesalahan pengembalian *endpoint* sebelumnya terjadi karena tumpang tindih waktu rilis pembaruan, di mana rute yang salah ter-*deploy* ke *server*.

## Belum diverifikasi
- Pengujian akhir pembuatan _tenant_ dari pendaftaran hingga selesai perlu diuji kembali oleh *user* setelah melakukan _deploy_.
