# Master Plan: Pengembangan Modul Tenant & Warga

**Tanggal Dokumen:** 12 Juli 2026
**Fase Berikutnya:** Pengembangan Portal Pengurus Perumahan (Tenant Owner) & Portal Warga (Tenant User).

---

## 🎯 Objektif Utama
Setelah Portal Superadmin berhasil diselesaikan beserta *testing*-nya, fokus pengembangan selanjutnya adalah di ruang lingkup **Tenancy** (dalam konteks pangkalan data *tenant* masing-masing).

Ada dua level pengguna di dalam lingkup Tenant:
1. **Pengurus Perumahan (Tenant Owner / RT / RW):** Memiliki wewenang untuk mengatur data perumahan, tagihan iuran bulanan, kas, warga, dan pengumuman tingkat perumahan.
2. **Warga (Tenant User / Penghuni):** Warga biasa yang menggunakan aplikasi untuk melihat tagihan, membayar iuran bulanan, melihat laporan kas perumahan secara transparan, serta membaca pengumuman warga.

---

## 🏗️ 1. Pembangunan Portal Pengurus (Tenant Owner)
Portal ini akan diakses oleh Ketua RT/RW atau Bendahara perumahan.

**Fitur yang akan diimplementasikan:**
- [ ] **Dashboard Pengurus:** Menampilkan metrik sederhana (Jumlah Kas Masuk dan Kas Keluar, Tagihan Belum Dibayar, Jumlah Warga).
- [x] **Manajemen Role:** Pengaturan hak akses di dalam lingkup Tenant.
- [x] **Manajemen Rumah (Blok & Nomor):** Data rumah atau kavling yang ada di perumahan.
- [x] **Manajemen Warga (CRUD Warga):** 
  - Admin dapat menambahkan data warga baru.
  - Saat warga ditambah, otomatis membuatkan akun untuk *login* warga ke portal (dikirimkan via email).
  - Warga akan dipetakan ke data blok/nomor rumah.
- [x] **Manajemen Iuran (Billing System):**
  - Pembuatan tipe iuran (contoh: Iuran Kebersihan & Keamanan = Rp 150.000/Bulan).
  - Sistem *Generate Tagihan Bulanan* secara otomatis (menggunakan *Cron Job / Scheduler*).
- [x] **Laporan Kas (Keuangan):** Pemasukan dan Pengeluaran kas RT secara sederhana agar bisa dilihat transparan oleh semua warga.
- [x] **Pengumuman Lokal:** Membuat pengumuman atau himbauan yang hanya bisa dilihat oleh warga perumahan tersebut.
- [ ] **Moderasi Lapak Warga:** Memantau dan mengelola (menghapus jika perlu) produk/jasa yang dijual oleh warga untuk menjaga kenyamanan.

---

## 📱 2. Pembangunan Portal Warga (Tenant User / Residents)
Portal ini difokuskan pada pengalaman PWA (Progressive Web App) yang sangat bersahabat (*Mobile-First*) layaknya aplikasi ponsel biasa.

**Fitur yang akan diimplementasikan:**
- [ ] **Beranda Warga (Home):** Menampilkan sapaan, status tagihan terkini (Lunas / Belum Lunas), dan pengumuman terbaru.
- [ ] **Bayar Iuran:**
  - Warga dapat melihat rincian tagihan bulan ini dan bulan-bulan sebelumnya yang menunggak.
  - Konfirmasi pembayaran manual (unggah bukti transfer) ATAU Integrasi Payment Gateway (jika direncanakan menggunakan Midtrans/Xendit/dll).
- [ ] **Transparansi Kas:** Halaman ringkas yang menunjukkan total saldo kas RT saat ini beserta mutasi kas terbaru.
- [ ] **Lapak Warga (UMKM Lokal):** 
  - Katalog produk/jasa yang dijual oleh warga untuk warga.
  - Warga dapat menambahkan dan mengelola dagangannya sendiri.
  - Pemesanan diarahkan langsung ke WhatsApp penjual agar simpel dan cepat.

---

## 🛠️ 3. Standardisasi Desain & Teknis
- **UI/UX:** Menggunakan pendekatan TailwindCSS dengan desain yang elegan, transisi yang halus, efek *glassmorphism* (jika sesuai), dan dukungan PWA penuh.
- **Arsitektur Kode:** Semuanya akan menggunakan **Livewire v3 (Volt)** dengan arsitektur berbasis komponen (*Single Page Application* *feeling* menggunakan `wire:navigate`).
- **Keamanan Lingkup Data (Data Isolation):** Karena kita menggunakan `stancl/tenancy`, secara struktural data setiap perumahan akan aman dan 100% terisolasi dalam *database* (atau tabel/skema) terpisah.
- **Testing:** Sama seperti Superadmin, setiap modul akan dilindungi oleh *Feature Test* untuk memastikan kestabilan aplikasi jangka panjang.

---

**Langkah Terdekat untuk Sesi Berikutnya:**
1. Menyusun struktur Database Migration untuk `Tenants` (Tabel Warga, Tagihan, Kas).
2. Membangun halaman Layout dasar (*Mobile First*) untuk Pengurus dan Warga.
3. Melakukan *seeding* data palsu (*dummy*) ke dalam *database tenant* untuk uji coba *Dashboard*.
