<?php

namespace App\Livewire\Central\Tenant;

use Livewire\Component;
use Livewire\Attributes\On;

class Index extends Component
{
    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirm', [
            'title' => 'Apakah Anda yakin?',
            'text'  => 'Ingin menghapus tenant ini beserta seluruh datanya? Tindakan ini tidak dapat dibatalkan!',
            'action' => 'delete-tenant',
            'params' => $id
        ]);
    }

    #[On('delete-tenant')]
    public function deleteTenant($id)
    {
        $tenant = \App\Models\Tenant::find($id);
        if ($tenant) {
            
            // Hapus Database via DirectAdmin API
            if (config('services.directadmin.url') && config('services.directadmin.username')) {
                $dbName = 'sbdigita_' . $tenant->id;
                $daUrl = rtrim(config('services.directadmin.url'), '/') . '/api/db-manage/databases/' . $dbName . '?drop-orphan-users=true';
                
                $response = \Illuminate\Support\Facades\Http::withBasicAuth(
                    config('services.directadmin.username'),
                    config('services.directadmin.password')
                )->delete($daUrl);

                if (!$response->successful() && $response->status() !== 404) {
                    $this->dispatch('swal:modal', [
                        'title' => 'Gagal!',
                        'text'  => 'Gagal menghapus database di server (DA Error: ' . $response->status() . ')',
                        'icon'  => 'error',
                    ]);
                    return;
                }
            }

            $tenant->delete();
            $this->dispatch('swal:modal', [
                'title' => 'Berhasil!',
                'text'  => 'Tenant beserta databasenya berhasil dihapus permanen.',
                'icon'  => 'success',
            ]);
        }
    }

    public function deletePending($id)
    {
        $registration = \App\Models\TenantRegistration::find($id);
        if ($registration) {
            $registration->delete();
            $this->dispatch('swal:modal', [
                'title' => 'Berhasil!',
                'text'  => 'Antrean pendaftaran berhasil dihapus. Pendaftar kini bisa menggunakan nama tersebut kembali.',
                'icon'  => 'success',
            ]);
        }
    }

    public function render()
    {
        $tenants = \App\Models\Tenant::with('domains')->latest()->paginate(10);
        $pendings = \App\Models\TenantRegistration::where('status', 'pending')->latest()->get();

        return view('livewire.central.tenant.index', compact('tenants', 'pendings'))
            ->layout('layouts.superadmin');
    }
}
