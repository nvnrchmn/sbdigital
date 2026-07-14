<?php

namespace App\Livewire\Central;

use App\Models\User;
use App\Models\Tenant;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterTenant extends Component
{
    public $nama_perumahan = '';
    public $tenant_id = '';
    public $admin_name = '';
    public $admin_email = '';
    public $admin_password = '';

    public function updatedNamaPerumahan()
    {
        if (empty($this->tenant_id)) {
            $this->tenant_id = Str::slug($this->nama_perumahan, '_');
        }
    }

    public function register()
    {
        $this->validate([
            'nama_perumahan' => 'required|string|max:255',
            'tenant_id' => 'required|string|alpha_dash|max:50|unique:tenants,id|unique:tenant_registrations,tenant_id',
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|max:255',
            'admin_password' => 'required|string|min:8',
        ], [
            'tenant_id.unique' => 'ID Perumahan/URL ini sudah digunakan atau sedang dalam proses pendaftaran.',
        ]);

        // Cari paket gratis
        $freePlan = \App\Models\Plan::orderBy('max_houses', 'asc')->first();

        // 1. Buat TenantRegistration
        $token = Str::random(60);
        $registration = \App\Models\TenantRegistration::create([
            'nama_perumahan' => $this->nama_perumahan,
            'tenant_id' => strtolower($this->tenant_id),
            'admin_name' => $this->admin_name,
            'admin_email' => $this->admin_email,
            'admin_password' => Hash::make($this->admin_password),
            'token' => $token,
            'status' => 'pending',
        ]);

        // 2. Kirim Email Verifikasi
        \Illuminate\Support\Facades\Mail::to($this->admin_email)->send(new \App\Mail\VerifyTenantEmail($registration));

        // 3. Tampilkan pesan sukses dengan SweetAlert
        $this->dispatch('notify', [
            'message' => 'Pendaftaran berhasil! Silakan periksa email Anda untuk memverifikasi pendaftaran.',
            'icon' => 'success'
        ]);
        
        $this->reset(['nama_perumahan', 'tenant_id', 'admin_name', 'admin_email', 'admin_password']);
    }

    public function render()
    {
        return view('livewire.central.register-tenant')->layout('layouts.guest');
    }
}
