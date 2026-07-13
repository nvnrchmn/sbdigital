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
            $tenant->delete();
            $this->dispatch('swal:modal', [
                'title' => 'Berhasil!',
                'text'  => 'Tenant berhasil dihapus.',
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
