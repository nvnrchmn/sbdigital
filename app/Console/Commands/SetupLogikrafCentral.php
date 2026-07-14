<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Setting;
use App\Services\LogikrafService;

class SetupLogikrafCentral extends Command
{
    protected $signature = 'logikraf:setup-central';
    protected $description = 'Mendaftarkan Sub-Akun Sentral SBDigital ke Logikraf Payment Hub dan menyimpannya ke Settings';

    public function handle()
    {
        $this->info('Memulai registrasi Sub-Akun Sentral SBDigital ke Logikraf...');
        
        $logikraf = new LogikrafService();
        $response = $logikraf->createSubAccount('SBDIGITAL-CENTRAL', 'Kas Utama SBDigital', 'admin@sbdigital.biz.id');
        
        if ($response && isset($response['data']['external_reference_id'])) {
            $centralId = $response['data']['external_reference_id'];
            $this->info("Berhasil! ID Sub-Akun Sentral Anda: {$centralId}");
            
            Setting::set('logikraf_central_sub_account_id', $centralId);
            $this->info('ID berhasil disimpan ke database pengaturan SBDigital.');
        } else {
            // Jika sudah ada
            if (isset($response['message']) && strpos(strtolower($response['message']), 'already exists') !== false) {
                $centralId = 'SBDIGITAL-CENTRAL';
                Setting::set('logikraf_central_sub_account_id', $centralId);
                $this->info("Sub-Akun Sentral sudah terdaftar sebelumnya. ID {$centralId} disimpan ke database.");
            } else {
                $this->error('Gagal mendaftarkan Sub-Akun Sentral Logikraf!');
                if ($response) {
                    $this->error(json_encode($response));
                }
            }
        }
    }
}
