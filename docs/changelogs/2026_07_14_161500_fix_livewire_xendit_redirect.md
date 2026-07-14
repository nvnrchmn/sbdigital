# Changelog: Perbaikan Integrasi Xendit & Livewire 3 Redirect

## Tanggal: 14 Juli 2026
**Masalah Utama:** 
Redirect ke halaman pembayaran Xendit gagal setelah faktur berhasil dibuat di Logikraf. Browser tetap berada di halaman `/langganan` atau mengalami _reload_ paksa.

## Analisis & Langkah yang Dikerjakan:
1. **Analisis API & Pembuatan Tagihan:**
   - Log aplikasi menunjukkan `createMasterInvoice` berhasil mengembalikan respons valid dari Logikraf.
   - Database berhasil mencatat URL Xendit yang benar (bukan URL dummy `#`).
   - Masalah murni berada pada lapisan *frontend* (Livewire/Javascript).

2. **Perbaikan Error Javascript pada SweetAlert:**
   - Terjadi error `Cannot read properties of undefined (reading 'icon')` di komponen `sweetalert.blade.php`.
   - Hal ini disebabkan oleh perbedaan format *event payload* di Livewire 3 yang membungkus data di dalam array jika didispatch dengan parameter *named arguments*.
   - **Tindakan:** Mengubah listener di `sweetalert.blade.php` agar mampu mengekstrak array `data[0]` atau `data` secara aman.

3. **Eksplorasi Metode Redirect:**
   - Metode `redirect()->away()` mengalami kendala karena _interceptor_ Livewire 3 dan `stancl/tenancy` path routing.
   - Upaya _bypass_ menggunakan Javascript event `dispatch('redirect-external')` tidak dieksekusi dengan stabil oleh _engine_ SPA Livewire (`wire:navigate`).
   - **Tindakan Akhir:** Menggunakan metode bawaan resmi Livewire 3 khusus URL eksternal: `$this->redirect($url, navigate: false);` yang secara stabil ditangani oleh _engine_ Livewire 3.

4. **Pencegahan Form Submit:**
   - Menambahkan `type="button"` pada tombol langganan agar browser tidak salah menafsirkannya sebagai submit form yang menyebabkan halaman termuat ulang.

## Yang Sudah Diverifikasi:
- Tagihan Xendit dipastikan terbentuk dengan status PENDING.
- Error JS pada komponen SweetAlert telah hilang.
- Metode `$this->redirect` dikonfirmasi sebagai jalur resmi Livewire 3 untuk URL eksternal.

## Tindakan Selanjutnya bagi Pengguna:
1. Pastikan menjalankan `git pull` (via `./deploy.sh --force`) di production.
2. Sangat wajib menekan **Ctrl + F5** (Hard Refresh) untuk membersihkan *cache* SPA Livewire di browser sebelum menguji ulang klik tombol berlangganan.
