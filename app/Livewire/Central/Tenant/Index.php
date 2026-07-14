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
            'params' => ['id' => $id]
        ]);
    }

    #[On('delete-tenant')]
    public function deleteTenant($id)
    {
        $tenant = \App\Models\Tenant::find($id);
        if ($tenant) {
            
            // Hapus Database via DirectAdmin API
            if (env('DIRECTADMIN_URL') && env('DIRECTADMIN_USERNAME')) {
                $dbName = 'sbdigita_' . $tenant->id;
                $daUrl = rtrim(env('DIRECTADMIN_URL'), '/') . '/api/db-manage/databases/' . $dbName;
                
                $response = \Illuminate\Support\Facades\Http::withBasicAuth(
                    env('DIRECTADMIN_USERNAME'),
                    env('DIRECTADMIN_PASSWORD')
                )->delete($daUrl, [
                    'drop-orphan-users' => true
                ]);

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

    public function render()
    {
        $tenants = \App\Models\Tenant::with('domains')->latest()->paginate(10);

        return view('livewire.central.tenant.index', compact('tenants'))
            ->layout('layouts.superadmin');
    }
}
