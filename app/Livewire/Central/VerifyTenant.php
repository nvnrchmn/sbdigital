<?php

namespace App\Livewire\Central;

use Livewire\Component;
use App\Models\TenantRegistration;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;

#[Layout('layouts.guest')]
class VerifyTenant extends Component
{
    public $token;
    public $status = 'loading'; // loading, success, error
    public $message = '';
    public $tenantUrl = '';

    public function mount($token)
    {
        // Public endpoint, maybe? Or needs auth? If Central component is public, we skip. But Verify is usually public or uses token.

        $this->token = $token;
        $this->verify();
    }

    public function verify()
    {
        $registration = TenantRegistration::where('token', $this->token)
            ->where('status', 'pending')
            ->first();

        if (!$registration) {
            $this->status = 'error';
            $this->message = 'Tautan verifikasi tidak valid atau pendaftaran sudah diverifikasi sebelumnya.';
            return;
        }

        try {
            // 1. Update status
            $registration->update(['status' => 'verified']);

            // 1.5. Buat Database via DirectAdmin API (Jika dikonfigurasi)
            if (config('services.directadmin.url') && config('services.directadmin.username')) {
                // Konfigurasi nama database (tenancy.php menggunakan prefix sbdigita_)
                $dbName = 'sbdigita_' . $registration->tenant_id;
                
                $daUrl = rtrim(config('services.directadmin.url'), '/') . '/api/db-manage/create-db';
                
                $response = \Illuminate\Support\Facades\Http::withBasicAuth(
                    config('services.directadmin.username'),
                    config('services.directadmin.password')
                )->post($daUrl, [
                    'database' => $dbName
                ]);

                // 409 = Conflict (Database sudah ada)
                if (!$response->successful() && $response->status() !== 409) {
                    throw new \Exception('Gagal membuat database di server (DA Error: ' . $response->status() . ' - ' . $response->body() . ')');
                }

                // Berikan hak akses penuh kepada user database sentral
                $dbUser = config('database.connections.mysql.username'); // cth: sbdigita_central
                if ($dbUser) {
                    $privUrl = rtrim(config('services.directadmin.url'), '/') . '/api/db-manage/users/' . $dbUser . '/databases/' . $dbName . '/change-privs';
                    
                    $privResponse = \Illuminate\Support\Facades\Http::withBasicAuth(
                        config('services.directadmin.username'),
                        config('services.directadmin.password')
                    )->put($privUrl, [
                        'privileges' => [
                            'alter' => true,
                            'alterRoutine' => true,
                            'create' => true,
                            'createRoutine' => true,
                            'createTmpTable' => true,
                            'createView' => true,
                            'delete' => true,
                            'drop' => true,
                            'event' => true,
                            'execute' => true,
                            'index' => true,
                            'insert' => true,
                            'lockTables' => true,
                            'references' => true,
                            'select' => true,
                            'showView' => true,
                            'trigger' => true,
                            'update' => true,
                        ]
                    ]);

                    if (!$privResponse->successful()) {
                        throw new \Exception('Gagal memberikan hak akses database ke user ' . $dbUser . ' (DA Error: ' . $privResponse->status() . ' - ' . $privResponse->body() . ')');
                    }
                }
            }

            // 2. Buat Tenant
            $freePlan = \App\Models\Plan::orderBy('max_houses', 'asc')->first();
            $tenant = Tenant::create([
                'id' => $registration->tenant_id,
                'nama_perumahan' => $registration->nama_perumahan,
                'plan_id' => $freePlan ? $freePlan->id : null,
            ]);

            // 2.5 Daftarkan Sub-Akun Logikraf
            try {
                $logikraf = new \App\Services\LogikrafService();
                $logikraf->createSubAccount($tenant->id, $tenant->nama_perumahan, $registration->admin_email);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Gagal membuat Sub-Akun Logikraf saat registrasi: ' . $e->getMessage());
            }

            // 3. Buat User Admin di DB Tenant
            $adminData = [
                'name' => $registration->admin_name,
                'email' => $registration->admin_email,
                'password' => $registration->admin_password, // sudah di-hash saat pendaftaran
            ];

            $tenant->run(function () use ($adminData) {
                $user = User::create($adminData);
                $user->assignRole('Tenant Owner');
            });

            $this->status = 'success';
            $this->message = 'Pendaftaran berhasil diverifikasi! Ruang kerja perumahan Anda telah dibuat.';
            $this->tenantUrl = '/' . $tenant->id . '/login';

        } catch (\Exception $e) {
            $this->status = 'error';
            $this->message = 'Terjadi kesalahan saat membuat ruang kerja. Silakan hubungi dukungan kami. Error: ' . $e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.central.verify-tenant');
    }
}
