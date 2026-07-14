<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use App\Models\Warga;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class EncryptExistingNik extends Command
{
    /**
     * php artisan nik:encrypt-existing
     * php artisan nik:encrypt-existing --tenant=ksb2   (hanya 1 tenant, untuk testing)
     * php artisan nik:encrypt-existing --dry-run        (simulasi, tidak menulis apapun)
     */
    protected $signature = 'nik:encrypt-existing
        {--tenant= : Jalankan hanya untuk satu tenant ID tertentu (opsional, untuk testing)}
        {--dry-run : Tampilkan apa yang akan dilakukan tanpa menyimpan perubahan}';

    protected $description = 'Backfill: enkripsi kolom NIK yang masih plaintext di semua database tenant, dan isi kolom nik_hash untuk keperluan uniqueness check.';

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $onlyTenant = $this->option('tenant');

        if ($dryRun) {
            $this->warn('=== MODE DRY-RUN: tidak ada perubahan yang akan disimpan ===');
        }

        $tenants = $onlyTenant
            ? Tenant::where('id', $onlyTenant)->get()
            : Tenant::all();

        if ($tenants->isEmpty()) {
            $this->error('Tidak ada tenant ditemukan. Cek parameter --tenant jika digunakan.');
            return self::FAILURE;
        }

        $this->info("Akan memproses {$tenants->count()} tenant.");

        if (!$dryRun && !$this->confirm('Pastikan Anda sudah BACKUP semua database tenant. Lanjutkan?', false)) {
            $this->warn('Dibatalkan oleh user.');
            return self::SUCCESS;
        }

        $totalEncrypted = 0;
        $totalSkipped = 0;
        $totalFailed = 0;

        foreach ($tenants as $tenant) {
            $this->line("--- Tenant: {$tenant->id} ---");

            try {
                tenancy()->initialize($tenant);

                // Ambil semua warga. Kita cek satu per satu apakah nik_hash sudah terisi
                // (indikator bahwa baris ini sudah pernah di-backfill sebelumnya).
                $wargaList = Warga::whereNull('nik_hash')->orWhere('nik_hash', '')->get();

                if ($wargaList->isEmpty()) {
                    $this->line('  Tidak ada data yang perlu di-backfill (sudah terenkripsi semua atau kosong).');
                } else {
                    $this->line("  Ditemukan {$wargaList->count()} baris warga untuk diproses.");

                    foreach ($wargaList as $warga) {
                        try {
                            $rawNik = $warga->getRawOriginal('nik');

                            // Deteksi apakah nilai sekarang sudah ciphertext (sudah pernah dienkripsi
                            // oleh proses lain) atau masih plaintext NIK 16 digit.
                            $isLikelyPlaintext = (bool) preg_match('/^\d{10,16}$/', (string) $rawNik);

                            if (!$isLikelyPlaintext) {
                                $this->warn("  [SKIP] Warga ID {$warga->id}: nilai nik tidak terlihat seperti NIK plaintext, dilewati demi keamanan (cek manual).");
                                $totalSkipped++;
                                continue;
                            }

                            $plainNik = $rawNik;
                            $nikHash = hash_hmac('sha256', $plainNik, config('app.key'));

                            if ($dryRun) {
                                $this->line("  [DRY-RUN] Warga ID {$warga->id} akan dienkripsi.");
                            } else {
                                DB::table('warga')->where('id', $warga->id)->update([
                                    'nik' => Crypt::encryptString($plainNik),
                                    'nik_hash' => $nikHash,
                                ]);
                            }

                            $totalEncrypted++;
                        } catch (\Throwable $e) {
                            $this->error("  [GAGAL] Warga ID {$warga->id}: {$e->getMessage()}");
                            $totalFailed++;
                        }
                    }
                }
            } catch (\Throwable $e) {
                $this->error("  Gagal memproses tenant {$tenant->id}: {$e->getMessage()}");
                $totalFailed++;
            } finally {
                tenancy()->end();
            }
        }

        $this->newLine();
        $this->info("Selesai. Terenkripsi: {$totalEncrypted}, Dilewati: {$totalSkipped}, Gagal: {$totalFailed}");

        if ($totalFailed > 0) {
            $this->warn('Ada kegagalan. Cek log di atas dan tangani manual sebelum melanjutkan ke production.');
            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
