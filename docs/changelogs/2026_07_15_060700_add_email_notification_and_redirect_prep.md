# Menambahkan Notifikasi Email dan Persiapan Redirect LPH

**Tanggal:** 2026-07-15
**Oleh:** Antigravity

## Deskripsi
Menambahkan fitur notifikasi email kepada Tenant Owner ketika pembayaran langganan berhasil, serta memperbaiki secret HMAC untuk *webhook*, dan menyisipkan `success_redirect_url` saat membuat invoice ke LPH agar nantinya pengguna bisa otomatis dialihkan kembali ke halaman langganan/dashboard.

## File yang Diubah (Project SBDigital)
- `app/Http/Controllers/LogikrafWebhookController.php`: 
  - Memperbaiki sumber variabel `$secret` untuk verifikasi signature, dari `logikraf_webhook_secret` menjadi `logikraf_api_key` agar sesuai dengan *behavior* Logikraf Payment Hub (LPH) yang menggunakan API Key untuk men-generate HMAC.
  - Menambahkan *logic* pengiriman email notifikasi (`SubscriptionPaidMail`) ke email `Tenant Owner` sesaat setelah status transaksi di-update menjadi `Lunas`.
- `app/Services/LogikrafService.php`:
  - Mengubah fungsi `createMasterInvoice` (dan `createInvoice` jika diperlukan nantinya) agar dapat menerima dan meneruskan argumen `success_redirect_url` ke *payload* LPH.
- `app/Livewire/Tenant/Langganan/Index.php`:
  - Mengirim parameter `route('tenant.langganan')` sebagai URL *success redirect* ketika metode `createMasterInvoice` dipanggil.
- `app/Mail/SubscriptionPaidMail.php` & `resources/views/emails/subscription_paid.blade.php`:
  - Membuat *class Mailable* beserta *template view* blade baru khusus untuk email notifikasi pembayaran langganan.

## Alasan (Root Cause)
Sebelumnya, webhook Logikraf dikirim menggunakan HMAC yang di-*hash* dengan `API_KEY`, namun SBDigital mencoba memverifikasi menggunakan `WEBHOOK_SECRET` sehingga terjadi kegagalan validasi signature dan update status batal. Selain itu, fitur notifikasi email dan integrasi *success_redirect_url* sebelumnya belum ditambahkan sehingga pengguna tidak otomatis kembali ke halaman awal setelah *checkout* berhasil. 

## Verifikasi
- Tidak ada *automated test* untuk fungsionalitas pengiriman email dalam *Tenant context* ini, sehingga belum diverifikasi lewat `phpunit`.
- Terkait parameter `success_redirect_url`, saat ini *Project SBDigital* sudah menyiapkannya, namun **Sistem Logikraf Payment Hub (LPH) belum memprosesnya**. Modifikasi pada *project LPH* diperlukan.
