# Project Overview

## Latar Belakang
SB-Digital awalnya dibangun menggunakan arsitektur Laravel sebagai API/Backend yang digabungkan dengan React via Inertia.js. Meskipun modern, pemisahan state antara client (React) dan server (Laravel) menimbulkan kompleksitas dalam pemeliharaan, serta proses rendering awal yang terkadang kurang optimal untuk SEO di halaman sentral.

Untuk meningkatkan produktivitas developer, kecepatan loading, dan konsistensi UI, proyek ini akan dibangun ulang menggunakan ekosistem **TALL Stack**.

## TALL Stack Components
1. **Tailwind CSS**: Framework utility-first untuk styling yang sangat efisien.
2. **Alpine.js**: Framework JavaScript minimalis untuk menangani interaksi frontend ringan (dropdown, modal, toggle) tanpa overhead seperti React/Vue.
3. **Laravel**: PHP Framework tangguh sebagai inti dari sistem, menangani Multi-Tenancy, Database, Authentication, dan Routing.
4. **Livewire**: Framework Full-Stack untuk Laravel yang memungkinkan pembuatan interface dinamis (Reactive) tanpa perlu menulis kode JavaScript kustom. Livewire menangani komunikasi state ke server secara transparan.

## UI Ecosystem (Shadcn UI)
Proyek ini mengadopsi prinsip desain dari **Shadcn UI**. Karena Shadcn aslinya dibangun untuk React, pada lingkungan TALL stack kita akan menggunakan porting atau pendekatan serupa seperti:
- Menggunakan komponen Blade yang didesain persis seperti Shadcn (misal: *MaryUI*, *Flux*, atau membangun *Blade Components* manual mengikuti panduan desain Shadcn).
- Desain minimalis, border-radius yang tegas, penggunaan shadow yang halus, dan mode gelap (Dark Mode) bawaan.

## Target Pengguna
1. **Pengurus RT/RW (Super Admin Tenant)**: Menggunakan sistem via PC/Laptop atau Tablet untuk mencatat keuangan dan mengelola tagihan warga.
2. **Warga (User Tenant)**: Mayoritas menggunakan *Smartphone* untuk melihat tagihan, membayar iuran, dan melaporkan keluhan. UI untuk warga harus bergaya *Mobile-First/App-Like*.
3. **Pemilik Platform (Central Admin)**: Mengelola pendaftaran RT baru, paket harga, dan pengaturan server.
