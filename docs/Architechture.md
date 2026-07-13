# System Architecture (TALL Stack)

## 1. Topologi Server & Framework
- **Backend/Framework:** Laravel 12 (PHP 8.3)
- **Frontend Layer:** Livewire 3 + Alpine.js + Tailwind CSS
- **Multi-Tenancy Engine:** `stancl/tenancy` v3.x
- **Database:** MySQL / MariaDB (DirectAdmin)
- **Queue/Background Jobs:** Database Driver (Tugas rutin seperti notifikasi tagihan bulanan)

## 2. Struktur Multi-Tenancy
Sistem akan memisahkan Domain dan Database secara tegas:
- **Central Domain (`sbdigital.biz.id`):** 
  - Mengelola *Landing Page*, Pendaftaran, dan SaaS Subscriptions.
  - Tabel utama: `tenants`, `domains`, `global_settings`, `saas_packages`.
- **Tenant Domains (`*.sbdigital.biz.id` atau subdomain/path custom):** 
  - Mengelola logic spesifik RT/RW.
  - Setiap tenant memiliki database terpisah, misalnya `sbdigita_sheika`, `sbdigita_mawar`.
  - Tabel operasional RT di-*migrate* secara individual ke database tenant ini.

## 3. Direktori Codebase (TALL Approach)
Daripada memisahkan frontend (React/Vue) dan backend, TALL stack menyatukan UI dan Logic:

- `app/Livewire/` - Menyimpan semua komponen Livewire.
  - `Central/` - Komponen khusus Central domain (Pricing, Register Tenant).
  - `Tenant/` - Komponen khusus Tenant (Dashboard, Tabel Warga).
- `resources/views/livewire/` - View (Blade) untuk komponen Livewire.
- `resources/views/components/` - Blade Components yang akan digunakan secara global (mengadopsi desain Shadcn UI). Contoh: `<x-button>`, `<x-input>`, `<x-modal>`.
- `routes/web.php` - Routing untuk Central Domain.
- `routes/tenant.php` - Routing untuk Tenant Domain.

## 4. State Management
- **Server State (Database Data):** Dikelola oleh properti publik di komponen **Livewire**. Data otomatis tersinkronisasi dua arah via AJAX.
- **Client State (UI Volatile Data):** Dikelola oleh **Alpine.js**. Misalnya, *toggle sidebar*, animasi *dropdown*, dan *tab switching*. Alpine memastikan UI terasa instan tanpa membebani server dengan request HTTP.

## 5. Security & Authorization
- **Authentication:** Laravel Breeze (Blade/Livewire edition) atau Fortify.
- **Authorization:** `spatie/laravel-permission` dengan *PermissionTeamId* agar Role/Permission bisa berjalan aman di dalam ekosistem Multi-Tenant.
- **CSRF & XSS:** Ditangani secara otomatis oleh Livewire dan Blade echos (`{{ $var }}`).
