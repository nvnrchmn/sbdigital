# Changelog: 14 Juli 2026 - Perbaikan Error 422 Pembuatan Tagihan (Invoice Logikraf)

## Dikerjakan
- **`app/Services/LogikrafService.php`**:
  - Menambahkan parameter `string $tenantId` pada metode `createMasterInvoice`.
  - Memasukkan nilai `$tenantId` tersebut ke dalam kueri antarmuka sebagai `external_reference_id` saat menelepon (*hit*) rute `/invoices` Logikraf API.
- **`app/Livewire/Tenant/Langganan/Index.php`**:
  - Memperbarui argumen saat memanggil metode `$logikraf->createMasterInvoice(...)` dengan menyisipkan variabel `$tenantId` (ID Perumahan) di posisi kedua.

## Tujuan
- Menyelesaikan pesang kegagalan *Logikraf createMasterInvoice failed (Status: 422)*. 
- API pembuatan tagihan (*Invoice*) Logikraf bersifat ketat, yang mewajibkan seluruh pengajuan tagihan baru harus menyertakan **`external_reference_id`** (baik itu untuk sub-akun atau untuk tagihan sentral/master).
- Perbaikan ini memastikan tagihan akan dibuat dengan sempurna dan memiliki referensi jelas menuju ID perumahan sang penyewa (*Tenant ID*) yang bertindak sebagai pihak pembayar.

## Belum diverifikasi
- Simulasi penyelesaian tagihan (*checkout*) hingga tuntas oleh *User* untuk memastikan _callback/webhook_ langganan berjalan.
