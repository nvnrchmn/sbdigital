# SB Digital — UI/UX Reference Document

**Produk:** SB Digital (Sistem Manajemen Warga Digital)
**Studio:** Logikraf
**Tech stack:** TALL Stack (Tailwind CSS, Alpine.js, Laravel, Livewire) + `stancl/tenancy`
**Tujuan dokumen:** Menjadi acuan tunggal bagi developer maupun AI coding agent saat membangun UI, agar seluruh tampilan — dari landing page tenant hingga dashboard RT/RW — konsisten dengan identitas visual SB Digital dan tidak drift antar sesi development.

---

## 1. Filosofi desain

SB Digital adalah alat kerja sehari-hari untuk pengurus RT/RW: input data warga, iuran, surat-menyurat, pengumuman. Prioritas UI adalah **kejelasan dan kecepatan**, bukan dekorasi. Tone visual: *tenang, rapi, terpercaya* — seperti aplikasi perbankan/pemerintahan yang modern, bukan seperti landing page startup yang ramai.

Tiga prinsip yang mengikat setiap keputusan desain:

1. **Tenang lebih dulu, berwarna kemudian.** Latar dan struktur netral (putih/abu-abu), warna brand (cyan → indigo) dipakai selektif untuk elemen aktif/aksi/status — bukan untuk mengecat seluruh halaman.
2. **Konsisten dengan mark logo.** Sudut membulat (squircle), gradient diagonal cyan → indigo, dan motif "sinyal/gelombang" dari logo jadi bahasa visual yang berulang di badge, avatar, empty state — bukan cuma dipakai sekali di header.
3. **Dibangun untuk kepadatan data.** Ini bukan situs marketing; ini dashboard dengan tabel, form, dan angka. Setiap komponen harus tetap terbaca saat berisi 50+ baris data.

---

## 2. Fondasi brand (diturunkan dari logo)

| Elemen | Sumber | Aturan pakai |
|---|---|---|
| Gradient utama | `#31C3FF → #2A5DF9`, diagonal (135°) | Hanya untuk: badge ikon, tombol primary utama (CTA tunggal per layar), progress bar, elemen hero. Jangan dipakai di background kartu/tabel. |
| Warna solid pengganti gradient | `#2A5DF9` (indigo) | Dipakai untuk teks link, ikon aktif, border fokus, state "selected" pada list/tab. |
| Slate Black | `#12172E` | Warna teks judul & elemen gelap (bukan `#000000` murni). |
| Bentuk sudut | `rx` besar (squircle), bukan sudut tajam maupun pill penuh | Badge/ikon: radius ~22% dari sisi. Kartu: `rounded-2xl`. Tombol/input: `rounded-lg`. |
| Motif sinyal (arc) | 2–3 garis lengkung konsentris dari logo | Dipakai *sparingly* sebagai elemen dekoratif di empty state, halaman onboarding, atau ilustrasi "belum ada data" — bukan di UI fungsional sehari-hari. |

---

## 3. Design tokens

Semua token di bawah didefinisikan sebagai extend di `tailwind.config.js` agar dipakai lewat utility class, bukan hex hardcoded di Blade.

### 3.1 Warna

```js
// tailwind.config.js
module.exports = {
  theme: {
    extend: {
      colors: {
        brand: {
          // cyan — aksen sekunder, ujung terang gradient
          cyan: {
            50:  '#EAFBFF',
            100: '#CEF3FF',
            200: '#A0E8FF',
            300: '#6DD9FF',
            400: '#43CBFF',
            500: '#31C3FF', // logo — cyan
            600: '#0FA8E8',
            700: '#0B85BA',
            800: '#0A6690',
            900: '#0A506F',
          },
          // indigo — warna primary, ujung gelap gradient
          indigo: {
            50:  '#EEF2FF',
            100: '#E0E7FF',
            200: '#C3D0FF',
            300: '#9FB2FE',
            400: '#6D8AFC',
            500: '#2A5DF9', // logo — indigo, = brand primary
            600: '#1B45DB',
            700: '#1636AD',
            800: '#142C87',
            900: '#12246B',
          },
        },
        // Slate — netral utama untuk teks & surface, bertema dingin (bukan gray netral biasa)
        slate: {
          50:  '#F7F8FA',
          100: '#EEF1F5',
          200: '#DFE3EA',
          300: '#C4CAD4',
          400: '#9AA3B2',
          500: '#6B7280',
          600: '#4B5468',
          700: '#333B4F',
          800: '#1F2536',
          900: '#12172E', // Slate Black — warna teks judul
        },
        success: { 500: '#16B364', 100: '#DBFAE8' },
        warning: { 500: '#F59E0B', 100: '#FEF3C7' },
        danger:  { 500: '#EF4444', 100: '#FEE2E2' },
        info:    { 500: '#31C3FF', 100: '#EAFBFF' }, // reuse brand.cyan
      },
      backgroundImage: {
        'brand-gradient': 'linear-gradient(135deg, #31C3FF 0%, #2A5DF9 100%)',
      },
    },
  },
}
```

**Aturan kontras:** teks di atas `brand-gradient` atau `brand.indigo.500` selalu putih (`#FFFFFF`). Teks di atas `brand.cyan.100`/`indigo.100` (badge lembut) pakai warna solid tergelap dari ramp yang sama (`cyan.800` / `indigo.800`), bukan hitam generik.

### 3.2 Tipografi

| Peran | Font | Fallback stack | Kapan dipakai |
|---|---|---|---|
| Display | **Poppins** (700/800) | `'Poppins', 'Segoe UI', sans-serif` | Judul halaman marketing/landing, hero, judul modal besar |
| UI / body | **Plus Jakarta Sans** (400/500/600) | `'Plus Jakarta Sans', 'Segoe UI', sans-serif` | Semua teks UI dashboard: label, tabel, form, navigasi |
| Mono | **JetBrains Mono** (400/500) | `'JetBrains Mono', ui-monospace, monospace` | Nomor surat, ID warga/tenant, kode iuran, angka rupiah di tabel keuangan |

Poppins dipakai terbatas di halaman marketing karena bobotnya berat untuk teks padat; Plus Jakarta Sans dipilih sebagai pasangan karena geometrinya senada dengan Poppins tapi lebih ringan dibaca di ukuran kecil — penting untuk dashboard yang padat data.

```js
// tailwind.config.js — fontFamily
fontFamily: {
  display: ['Poppins', 'sans-serif'],
  sans: ['Plus Jakarta Sans', 'sans-serif'],
  mono: ['JetBrains Mono', 'ui-monospace', 'monospace'],
},
```

**Skala tipografi**

| Token | Ukuran / line-height | Weight | Contoh pemakaian |
|---|---|---|---|
| `display-2xl` | 48px / 56px | 800 | Hero landing page |
| `display-xl` | 36px / 44px | 800 | Judul section marketing |
| `display-lg` | 30px / 38px | 700 | Judul halaman dashboard (H1) |
| `heading-md` | 20px / 28px | 600 | Judul kartu / section dashboard (H2) |
| `heading-sm` | 16px / 24px | 600 | Sub-judul, judul modal |
| `body-md` | 14px / 22px | 400 | Teks UI default (tabel, form, paragraf) |
| `body-sm` | 13px / 18px | 400 | Keterangan, teks sekunder |
| `caption` | 12px / 16px | 500 | Label uppercase, timestamp, badge |

### 3.3 Radius & elevasi

```js
borderRadius: {
  sm: '6px',
  DEFAULT: '8px',
  md: '10px',
  lg: '12px',   // tombol, input
  xl: '16px',
  '2xl': '20px', // kartu
},
boxShadow: {
  // shadow lembut bertint indigo, bukan hitam murni — selaras dengan brand
  xs: '0 1px 2px rgba(18, 23, 46, 0.05)',
  sm: '0 2px 6px rgba(18, 23, 46, 0.06)',
  md: '0 6px 16px rgba(42, 93, 249, 0.08)',
  lg: '0 12px 28px rgba(42, 93, 249, 0.12)',
},
```

Gunakan shadow paling minimal yang cukup: kartu statis pakai `shadow-xs`/tanpa shadow + border; elevasi dipakai untuk elemen yang "mengambang" di atas konten lain (dropdown, modal, toast).

---

## 4. Layout & shell aplikasi

SB Digital multi-tenant (`app.sbdigital.id/{tenant-slug}/`), jadi shell dashboard perlu jelas menunjukkan konteks tenant aktif.

```
┌─────────────────────────────────────────────────┐
│ Topbar: [nama tenant/RT]        [notif] [avatar] │
├───────────┬─────────────────────────────────────┤
│           │  Page header (judul + aksi utama)    │
│  Sidebar  ├─────────────────────────────────────┤
│  (nav)    │                                       │
│           │  Konten (kartu / tabel / form)        │
│  ikon +   │                                       │
│  label    │                                       │
└───────────┴─────────────────────────────────────┘
```

- **Sidebar**: lebar tetap `w-64` di desktop, collapse jadi ikon-saja (`w-16`) via toggle Alpine yang disimpan di `localStorage`. Di mobile, jadi drawer overlay.
- **Topbar**: selalu menampilkan nama tenant aktif (bukan "SB Digital" generik) supaya pengurus RT tahu konteks data yang sedang dilihat — penting karena arsitektur database-per-tenant.
- **Page header**: pola tetap `judul halaman (display-lg) + deskripsi singkat opsional + tombol aksi utama di kanan (pakai brand-gradient)`.
- **Konten**: max-width mengikuti container, padding `px-6 py-8` desktop / `px-4 py-6` mobile.

---

## 5. Pola komponen (Blade + Alpine.js)

Semua komponen sebagai Blade component di `resources/views/components/`, memakai `x-data` untuk state lokal (dropdown, modal, tab) dan `wire:model`/`wire:loading` untuk state yang butuh server (Livewire). Alpine menangani interaksi murni-UI, Livewire menangani apa pun yang menyentuh data.

### 5.1 Tombol

```blade
{{-- resources/views/components/button.blade.php --}}
@props(['variant' => 'primary', 'size' => 'md'])
@php
$base = 'inline-flex items-center justify-center gap-2 rounded-lg font-sans font-semibold
         transition disabled:opacity-50 disabled:pointer-events-none';
$variants = [
    'primary'   => 'bg-brand-gradient text-white hover:brightness-105 shadow-sm',
    'secondary' => 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50',
    'ghost'     => 'text-brand-indigo-500 hover:bg-brand-indigo-50',
    'danger'    => 'bg-danger-500 text-white hover:bg-red-600',
];
$sizes = ['sm' => 'h-8 px-3 text-body-sm', 'md' => 'h-10 px-4 text-body-md', 'lg' => 'h-12 px-6 text-heading-sm'];
@endphp
<button {{ $attributes->merge(['class' => "$base {$variants[$variant]} {$sizes[$size]}"]) }}>
    {{ $slot }}
</button>
```

- Satu halaman = satu tombol `primary` (yang pakai gradient). Aksi lain pakai `secondary`/`ghost`.
- State `wire:loading` mengganti label jadi spinner, ukuran tombol tidak berubah (pakai `wire:loading.attr="disabled"` + spinner ikon di dalam slot).

### 5.2 Kartu status/ringkasan

```blade
<div class="rounded-2xl border border-slate-200 bg-white p-5">
    <p class="text-caption uppercase tracking-wide text-slate-500">Total warga</p>
    <p class="mt-1 font-display text-display-lg text-slate-900">1.284</p>
    <p class="mt-2 text-body-sm text-success-500">+12 bulan ini</p>
</div>
```

### 5.3 Badge status (iuran, surat, dsb.)

```blade
@props(['status' => 'pending'])
@php
$map = [
    'lunas'   => 'bg-success-100 text-emerald-800',
    'pending' => 'bg-warning-100 text-amber-800',
    'telat'   => 'bg-danger-100 text-red-800',
    'draft'   => 'bg-slate-100 text-slate-700',
];
@endphp
<span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-caption font-medium {{ $map[$status] }}">
    {{ $slot }}
</span>
```

### 5.4 Modal (Alpine, tanpa dependensi JS tambahan)

```blade
<div x-data="{ open: false }" @keydown.escape.window="open = false">
    <x-button @click="open = true">Tambah warga</x-button>

    <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 p-4"
         x-transition.opacity>
        <div @click.outside="open = false"
             class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-lg"
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            <h2 class="font-sans text-heading-sm font-semibold text-slate-900">Tambah warga</h2>
            {{-- form Livewire di sini --}}
        </div>
    </div>
</div>
```

### 5.5 Toast notifikasi

Pakai `x-data` global di layout + `wire:dispatch`/browser event dari Livewire (`$dispatch('notify', ...)`), auto-dismiss dengan `x-init="setTimeout(() => show = false, 3000)"`. Posisi tetap: kanan-atas, stack vertikal, ikon status di kiri (pakai warna semantic dari §3.1).

### 5.6 Tabel data

- Header sticky, baris zebra sangat halus (`odd:bg-white even:bg-slate-50/60`) — bukan garis tebal.
- Baris punya `hover:bg-brand-indigo-50/40` supaya jelas interaktif.
- Aksi per baris (edit/hapus) muncul sebagai ikon di kolom kanan, bukan tombol teks — hemat ruang untuk data padat.
- Loading state pakai `wire:loading.class="opacity-50 pointer-events-none"` di `<tbody>`, bukan skeleton animasi yang berat.

### 5.7 Form & input

- Semua input: `rounded-lg border-slate-300 focus:border-brand-indigo-500 focus:ring-brand-indigo-500/20`.
- Label selalu di atas input (bukan placeholder-as-label), `text-body-sm font-medium text-slate-700`.
- Pesan error Livewire (`@error`) tampil di bawah input, `text-body-sm text-danger-500`, dengan border input berubah ke `border-danger-500`.

---

## 6. Ikonografi

- Gunakan **Heroicons** (varian *outline*, 1.5px stroke) via paket `blade-heroicons` — selaras dengan gaya garis outline pada mark logo (bukan ikon filled/solid).
- Ukuran standar: `w-5 h-5` di dalam teks/tombol, `w-6 h-6` di navigasi sidebar, `w-4 h-4` di badge/caption.
- Ikon aktif (nav terpilih, filter aktif) boleh diberi warna `brand.indigo.500`; ikon default `slate.500`.

---

## 7. Motion & interaksi

- Semua transisi Alpine: `duration-150` untuk micro-interaction (dropdown, tooltip), `duration-200` untuk modal/drawer. Jangan lebih dari itu — dashboard kerja harus terasa responsif, bukan "cinematic".
- Hover state wajib pada semua elemen klikable (tombol, baris tabel, item nav): perubahan background atau border, bukan animasi transform/scale.
- Motif "sinyal" logo boleh dipakai sebagai animasi halus (pulse lambat) *hanya* pada indikator "live/realtime", misalnya status kehadiran online — bukan dekorasi umum.
- Hormati `prefers-reduced-motion`: bungkus transisi non-esensial dengan media query, atau gunakan `motion-safe:` variant Tailwind.

---

## 8. Mode gelap (opsional, fase 2)

Tidak wajib di rilis awal, tapi token warna sudah disiapkan agar mudah ditambahkan lewat `dark:` variant:

- `bg-white` → `dark:bg-slate-900`, `text-slate-900` → `dark:text-slate-50`
- Gradient brand tetap sama di dark mode (kontras tetap baik di atas background gelap).
- Toggle disimpan di Alpine `x-data` root layout + `localStorage`, bukan mengikuti `prefers-color-scheme` secara otomatis (pengguna RT/RW cenderung ekspektasi kontrol manual).

---

## 9. Aksesibilitas — batas minimum

- Kontras teks minimum WCAG AA (4.5:1) untuk body text; badge lembut (§5.3) sudah dihitung memenuhi ini.
- Semua elemen interaktif punya `focus-visible` ring (`focus:ring-2 focus:ring-brand-indigo-500/40`), jangan pernah `outline-none` tanpa pengganti.
- Modal/drawer: fokus terkunci di dalam (`x-trap` dari plugin Alpine Focus, atau implementasi manual), `Escape` selalu menutup.
- Ikon-only button wajib `aria-label`.

---

## 10. Struktur file yang disarankan

```
resources/
  views/
    components/
      button.blade.php
      card.blade.php
      badge.blade.php
      modal.blade.php
      toast.blade.php
      input.blade.php
    layouts/
      app.blade.php        # shell dashboard (sidebar + topbar)
      guest.blade.php       # login/landing tenant
  css/
    app.css                 # @tailwind + font-face imports
tailwind.config.js           # token di §3
```

---

## 11. Ringkasan Do / Don't

| ✅ Do | ❌ Don't |
|---|---|
| Gradient brand hanya di 1 elemen fokus per layar | Gradient dipakai di background section penuh |
| Sudut membulat konsisten (squircle/rounded-lg/2xl) | Campur sudut tajam dan pill di komponen sejenis |
| Poppins untuk display, Plus Jakarta Sans untuk UI | Poppins dipakai untuk teks tabel/paragraf padat |
| Warna semantic (success/warning/danger) untuk status | Warna brand (indigo/cyan) dipakai untuk status "error" |
| Motif sinyal logo untuk empty state / indikator live | Motif sinyal ditempel di semua kartu sebagai dekorasi |
| Shadow tipis bertint indigo | Shadow hitam pekat/berat |

---

*Dokumen ini adalah acuan hidup — perbarui bila ada keputusan desain baru yang disepakati, agar tetap jadi satu sumber kebenaran untuk seluruh sesi development SB Digital.*
