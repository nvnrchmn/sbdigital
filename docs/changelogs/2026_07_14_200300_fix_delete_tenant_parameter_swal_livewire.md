# Changelog: 14 Juli 2026 - Perbaikan Error pada Tombol Hapus Tenant (SweetAlert Livewire 3)

## Dikerjakan
- **`app/Livewire/Central/Tenant/Index.php`**:
  - Mengubah struktur pengiriman parameter `params` di dalam `$this->dispatch('swal:confirm')` pada metode `confirmDelete()`.
  - Sebelumnya menggunakan `['id' => $id]` (mendeklarasikan _array/object_).
  - Sekarang diubah menjadi `$id` secara langsung (*literal string*).

## Tujuan
- Menyelesaikan *bug* di mana menekan tombol "Hapus" tidak menghasilkan aksi apa-apa atau menimbulkan *error*. Hal ini disebabkan oleh cara Livewire 3 memetakan parameter *event listener* dari Javascript ke *backend* (PHP). 
- Jika melempar _object_ `['id' => 'sheika']`, maka *method* `deleteTenant($id)` akan menerima `$id` sebagai **Collection/Array**, bukan *String*. Akibatnya, pemanggilan `Tenant::find($id)` mengembalikan `Collection`, dan perintah penghapusan `database` (`$tenant->id`) seketika mengalami *crash* di balik layar karena properti `id` tidak ada di dalam turunan `Collection`. Dengan melempar *string* mentah, variabel akan dipetakan secara akurat.

## Diasumsikan
- Tidak ada komponen *blade* atau kelas lain yang bergantung pada format parameter lama berbentuk *Array* pada _listener_ `swal:confirm`, sehingga perubahan _payload_ menjadi tipe data campuran (dinamis) di parameter JS `Livewire.dispatch(..., params)` aman dilakukan.

## Belum diverifikasi
- Kelancaran animasi pemunculan SweetAlert *Popup* konfirmasi (*Yakin ingin menghapus?*) pada peramban klien secara riil belum diuji coba.
