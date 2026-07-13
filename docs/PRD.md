# Product Requirements Document (PRD)

## 1. Pendahuluan
**SB-Digital** adalah platform SaaS (Software as a Service) berbasis Multi-Tenancy yang dirancang khusus untuk manajemen operasional Rukun Tetangga (RT) dan Rukun Warga (RW). Platform ini mempermudah pengurus dalam mengelola data warga, keuangan (iuran bulanan, kas), penanganan keluhan, serta komunikasi terpusat melalui pengumuman.

## 2. Tujuan Pembuatan Ulang (Rewrite)
Pembuatan ulang aplikasi ini bertujuan untuk:
- Mengganti stack Inertia.js (React) + Laravel murni menjadi **TALL Stack (Tailwind CSS, Alpine.js, Laravel, Livewire)**.
- Meningkatkan interaktivitas UI secara server-driven dan meminimalisir dependensi NPM yang rumit pada frontend.
- Mengimplementasikan **Shadcn UI** (porting ke Blade/Livewire jika memungkinkan, atau membangun komponen Blade berbasis desain Shadcn).
- Menyederhanakan manajemen *State* yang sebelumnya terpisah antara React dan Laravel.

## 3. Fitur Utama

### A. Central Domain (SaaS Management)
1. **Landing Page:** Menampilkan informasi fitur, harga paket langganan, dan kontak.
2. **Sistem Pendaftaran (Onboarding):** Form registrasi bagi Pengurus RT baru untuk membuat *Tenant* (ruang kerja).
3. **Manajemen Subscription:** Pengaturan paket SaaS, pembayaran langganan (integrasi Logikraf/Payment Gateway), dan pemantauan masa aktif.
4. **Super Admin Dashboard:** 
   - Mengelola daftar tenant.
   - Manajemen paket berlangganan dan fitur yang di-*toggle*.
   - Manajemen *Global Settings* (konfigurasi API, Mail, dll).

### B. Tenant Domain (Aplikasi RT/RW)
1. **Manajemen Warga (Data Kependudukan):**
   - Pendataan warga (NIK, Nama, KK, Alamat, Status Huni).
   - Pengelompokan warga berdasarkan Rumah/Blok.
2. **Manajemen Keuangan & Iuran:**
   - Tagihan iuran bulanan yang ter-generate otomatis.
   - Pencatatan pembayaran tunai dan non-tunai (Payment Gateway).
   - Buku Kas RT (Pemasukan dan Pengeluaran).
3. **Sistem Laporan / Pengaduan Warga:**
   - Warga dapat mengajukan keluhan (dengan foto dan deskripsi).
   - Pengurus dapat menanggapi dan mengubah status keluhan (Menunggu, Diproses, Selesai).
4. **Pengumuman & Informasi:**
   - Pengurus dapat mempublikasikan pengumuman ke seluruh warga.
5. **Role-Based Access Control (RBAC):**
   - Hak akses detail (Pengurus Inti, Bendahara, Warga Biasa).

## 4. Requirement Non-Fungsional
- **Performa:** Render halaman maksimal 1.5 detik menggunakan Livewire navigasi SPA (`wire:navigate`).
- **Responsif:** Mobile-first design, dapat diakses dengan nyaman via Smartphone.
- **Keamanan:** Data antar tenant benar-benar terisolasi di level database (Stancl Tenancy Multi-Database).
