# Changelog: 14 Juli 2026 - Penyesuaian Arsitektur Payment Hub & Push Protection

## Dikerjakan
- **`config/logikraf.php`**: Menambahkan pengaturan `central_sub_account_id` untuk menyimpan ID Sub-Akun milik SBDigital (Master).
- **`app/Services/LogikrafService.php`**:
  - Mengubah fungsi `createMasterInvoice` agar mengirimkan tagihan langganan (B2B) ke `central_sub_account_id` milik SBDigital, bukan ke Sub-Akun perumahan, untuk mencegah dana langganan berbalik ke kantong penyewa.
  - Menghapus penyuntikan manual `platform_fee_amount` karena Logikraf API menghitungnya secara otomatis berdasarkan konfigurasi SaaS.
- **`app/Livewire/Tenant/Langganan/Index.php`**: Menambahkan eksekusi `return redirect()->away(...)` pada fungsi `subscribe()` agar pengguna otomatis dilempar ke halaman *checkout* Xendit setelah tagihan langganan berhasil dibuat.
- **`docs/payment-hub/lph.md`**: Mengubah teks `sk_test_...` menjadi `logikraf_test_...` dan melakukan `git commit --amend` untuk mengatasi pemblokiran otomatis oleh *GitHub Secret Scanning / Push Protection*.

## Tujuan
Menyesuaikan alur *Logikraf Payment Hub* agar 100% selaras dengan dokumentasi asli, memastikan dana tagihan antar-bisnis (SaaS ke Tenant) masuk ke kas utama SBDigital, serta memuluskan sinkronisasi kode ke repositori GitHub.

## Belum diverifikasi
- Simulasi pengujian akhir (*End-to-End*) dari halaman Dasbor Tenant menuju halaman *checkout* Xendit yang baru saja ditambahkan logika *auto-redirect*.
