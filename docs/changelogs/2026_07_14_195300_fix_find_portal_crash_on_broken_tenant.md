# Changelog: 14 Juli 2026 - Perbaikan Error 500 pada Pencarian Portal (Find Portal)

## Dikerjakan
- **`app/Livewire/Central/FindPortal.php`**: Menambahkan blok `try { ... } catch (\Exception $e) { continue; }` di sekeliling *query* pencarian data `User` pada proses *looping* iterasi ke dalam *database* setiap *tenant*.

## Tujuan
- Mencegah terjadinya *crash* masal (Error 500: *Access Denied* / *Unknown Database*) apabila di dalam sistem terdapat *record* pendaftaran perumahan yang **gagal terbuat/rusak fisik database-nya** (seperti kasus gagal koneksi API DirectAdmin). Dengan perbaikan ini, jika sistem menemukan *database* yang rusak saat mencari *email*, ia tidak akan *crash* melainkan mengabaikannya (*skip*) dan lanjut memeriksa *database* perumahan lain yang sehat.

## Diasumsikan
- Metode `continue` pada iterasi `foreach` sudah cukup aman untuk melewati _tenant_ bermasalah tanpa memicu _memory leak_.

## Belum diverifikasi
- Simulasi skenario dengan jumlah ratusan/ribuan *database* perumahan yang rusak secara bersamaan belum diuji performanya (*time-out risk*).
