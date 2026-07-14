# Fix Logikraf Invoice Response Structure

**Tanggal:** 2026-07-15
**Oleh:** Antigravity

## Deskripsi
Memperbaiki bug di mana halaman pembayaran (checkout) tidak muncul saat user (Tenant Owner) melakukan proses berlangganan maupun pembayaran iuran warga, akibat kesalahan parsing struktur array response dari Logikraf Payment Hub.

## File yang Diubah
- `app/Livewire/Tenant/Langganan/Index.php`: Memperbarui akses array ke `$invoice['data']['checkout_url']` dan `$invoice['data']['transaction']['external_id']`.
- `app/Livewire/Tenant/Iuran/Form.php`: Memperbarui akses array ke `$invoice['data']['checkout_url']` dan `$invoice['data']['transaction']['external_id']`.

## Alasan (Root Cause)
Sesuai dokumentasi di `docs/payment-hub/lph.md`, format response untuk create invoice mengembalikan JSON dengan key `data`, dimana `checkout_url` dan data transaksi tersimpan di dalamnya. Sebelumnya, kode di Livewire Component mencoba mengakses `checkout_url` langsung dari root array (`$invoice['checkout_url']`), sehingga nilai null didapatkan dan user tidak diarahkan ke halaman pembayaran (status fallback ke `#` atau `# dummy url`).

## Verifikasi
- Tidak ada unit/feature test khusus untuk Livewire Component ini di folder `tests/`.
- Perlu diuji secara manual dengan melakukan proses langganan atau membuat tagihan iuran melalui aplikasi.
