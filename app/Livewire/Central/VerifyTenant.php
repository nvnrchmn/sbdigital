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

            // 2. Buat Tenant
            $freePlan = \App\Models\Plan::orderBy('max_houses', 'asc')->first();
            $tenant = Tenant::create([
                'id' => $registration->tenant_id,
                'nama_perumahan' => $registration->nama_perumahan,
                'plan_id' => $freePlan ? $freePlan->id : null,
            ]);

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
