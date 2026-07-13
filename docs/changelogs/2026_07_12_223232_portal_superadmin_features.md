# Changelog - 12 Juli 2026

**Tanggal:** 12 Juli 2026
**Fokus Pembaruan:** Penyempurnaan UX Portal Superadmin, Alur Autentikasi Warga (Multi-Tenancy), dan Uji Otomatis.

## 🚀 Fitur Baru (New Features)
- **Portal "Cari Perumahan" (Find Portal):** Menambahkan fitur `/cari-portal` yang inovatif agar warga atau pemilik perumahan (Tenant Owner) tidak perlu menghafal URL spesifik (misal: `/{tenant-id}/login`). Pengguna cukup memasukkan email mereka, dan sistem secara cerdas akan menelusuri seluruh basis data *tenant* lalu mengarahkan (*redirect*) mereka ke halaman *login* perumahannya masing-masing.

## 💅 Pembaruan Tampilan (UI/UX Improvements)
- **Responsivitas Mobile (Superadmin):** Menyempurnakan layout Portal Superadmin agar 100% *mobile-friendly*. 
  - Mengubah Sidebar statis menjadi dinamis.
  - Menambahkan *Bottom Navigation Bar* khusus versi *mobile* (layaknya aplikasi ponsel cerdas sesungguhnya) dengan 3 menu esensial: **Home (Dashboard)**, **Tenants**, dan **Lainnya (Toggle Menu/Profile)**.
- **Favicon Terintegrasi:** Mengubah dan memperbarui *favicon* sistem menjadi `sb-digital-icon.ico` di seluruh halaman aplikasi (khususnya *Landing Page* dan *Portal Admin*) guna memperkuat merek/branding *SB Digital*.

## 🛠️ Perbaikan Kutu (Bug Fixes)
- **Multiple Root Elements Error:** Memperbaiki galat kritis `Livewire\Features\SupportMultipleRootElementDetection\MultipleRootElementsDetectedException` pada komponen `layout.superadmin.sidebar`. Masalah ini terjadi karena Livewire V3 mewajibkan pengembalian elemen tag HTML tunggal sebagai *wrapper*. Perbaikan dilakukan dengan membungkus seluruh navigasi samping (*sidebar*) ke dalam satu `<div>` induk utama.

## 🧪 Pengujian & Keamanan (Testing & Stability)
- **Superadmin Feature Tests:** Merancang, menulis, dan meloloskan `12` skenario pengujian otomatis dengan `29 assertions` untuk menjaga stabilitas struktur:
  - `SuperadminDashboardTest`: Menguji otorisasi rute `/superadmin/dashboard` eksklusif untuk *Role* Super Admin.
  - `SuperadminTenantTest`: Menguji aksesibilitas modul manajemen *tenant*.
  - `SuperadminPlanTest`: Memastikan fungsionalitas formulir pembuatan dan pembaruan Paket/Limits berjalan sempurna di tingkat Livewire.
  - `SuperadminAnnouncementTest`: Memastikan *broadcast* siaran global berhasil masuk ke dalam sistem dengan validasi yang benar.
- **Adaptasi In-Memory Database:** Menambahkan dukungan lingkungan pengujian yang dinamis pada komponen `Plan` dan `GlobalAnnouncement`. Mengubah variabel statis `protected $connection = 'mysql';` menjadi metode dinamis `getConnectionName()` agar alat uji berbasis *SQLite* in-memory (`:memory:`) tidak *crash* ketika disandingkan dengan logika Multi-Tenancy (paket *stancl/tenancy*).
