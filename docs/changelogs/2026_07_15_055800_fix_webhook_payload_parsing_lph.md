# Fix Logikraf Webhook Payload Parsing

**Tanggal:** 2026-07-15
**Oleh:** Antigravity

## Deskripsi
Memperbaiki bug di mana webhook Logikraf Payment Hub (LPH) tidak memproses perubahan status pembayaran menjadi 'Lunas' karena Controller mengharapkan format payload Xendit, padahal LPH memiliki format payload tersendiri.

## File yang Diubah
- `app/Http/Controllers/LogikrafWebhookController.php`: 
  - Mengubah cara membaca payload dari `event == invoice.paid` dan `$data['data']['external_id']` menjadi langsung membaca `$data['status'] == 'PAID'` dan `$data['external_id']`.
  - Menambahkan baris untuk melakukan ekstrak ID *Invoice* asli, karena Logikraf otomatis menambahkan prefix `PHUB-{SAAS_APP_ID}-` pada `external_id` (contoh: `PHUB-5-INV-SUB-30` akan di-explode dan diekstrak menjadi `INV-SUB-30` saja agar bisa dikenali sistem).

## Alasan (Root Cause)
Sistem webhook di Logikraf tidak menggunakan *wrapper* `event` dan `data` seperti standar Xendit. Logikraf mengirim data *flat* (`external_id`, `status`, `paid_amount`, dll) sesuai dengan yang tertulis di dokumentasi `docs/payment-hub/lph.md` bab 4.2. Karena hal ini, `LogikrafWebhookController` gagal menemukan ID tagihan dan gagal mengubah status transaksi di tabel langganan maupun mengupdate `plan_id` pada Tenant.

## Verifikasi
- Tidak ada pengujian otomatis (unit/feature test) yang ditemukan untuk *webhook* controller ini di folder `tests/`.
- Perlu diverifikasi dengan mencoba pembayaran langganan secara simulasi (atau melihat transaksi *existing* jika *webhook* bisa di-trigger ulang dari dashboard LPH).
