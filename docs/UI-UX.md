# UI/UX Guidelines (Shadcn UI & TALL Stack)

## 1. Filosofi Desain
Aplikasi akan mengadopsi bahasa desain **Shadcn UI**:
- Minimalis dan berfokus pada konten.
- Menggunakan palet warna monokromatik (Slate/Zinc) untuk background, dengan warna primer biru/cyan yang modern.
- Sudut elemen (border-radius) konsisten, umumnya `rounded-md` atau `rounded-xl`.
- *Subtle borders* dan *soft shadows* untuk membedakan kedalaman (depth) antar elemen.
- **Dark Mode Support:** Menjadi keharusan sejak awal. Shadcn menggunakan CSS Variables untuk warna, yang sangat memudahkan *toggling* Dark/Light mode.

## 2. Struktur Layout

### Dashboard Pengurus (Desktop-Oriented)
- **Sidebar (Kiri):** Lebar statis (sekitar 250px) dengan logo di atas, daftar menu dengan ikon (Heroicons/Lucide), dan profil/switch mode di bawah.
- **Header:** Berisi navigasi *breadcrumbs*, input *global search*, dan lonceng notifikasi.
- **Main Content:** Memiliki padding yang luas (p-6 atau p-8).
- **Data Table:** Komponen paling krusial. Gunakan desain tabel Shadcn dengan filter, pagination, dan *dropdown actions* di setiap baris.

### Dashboard Warga (Mobile-Oriented)
- **Bottom Navigation:** Menggantikan sidebar tradisional. Karena warga mayoritas mengakses via HP, menu (Home, Tagihan, Laporan, Profil) diletakkan di bawah (Fixed Bottom Bar).
- **Cards & Widgets:** Tampilan utama berisi *summary* (Tagihan Belum Dibayar, Pengumuman Terbaru) menggunakan *Card components* (Shadcn Card).
- **Forms:** Input teks menggunakan `rounded-md`, border tipis, dengan efek *focus-ring* khas Shadcn (Ring offset).

## 3. Komponen Inti (TALL Implementation)
Karena Shadcn aslinya berbasis React/Radix UI, pada TALL stack kita akan menggunakan **Alpine.js** untuk mencapai fungsionalitas yang sama:
1. **Dialog / Modal:** Dikelola state-nya dengan `x-data="{ open: false }"`.
2. **Dropdown / Popover:** Menggunakan plugin Alpine `anchor` dan `x-transition` untuk animasi halus.
3. **Toast Notifications:** Di-trigger dari Livewire (contoh: `$this->dispatch('notify', ['message' => 'Sukses'])`) dan ditangkap oleh komponen Alpine Toast di *layout* utama.

## 4. Micro-Interactions
- Transisi halaman menggunakan `wire:navigate` (Livewire SPA) agar tidak ada *blank screen* saat pindah halaman.
- Indikator loading (`wire:loading`) pada tombol submit agar tidak terjadi *double-click*.
