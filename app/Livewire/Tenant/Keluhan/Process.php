<?php

namespace App\Livewire\Tenant\Keluhan;

use App\Models\Keluhan;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Support\TenantPermissions;

class Process extends Component
{
    public Keluhan $keluhan;
    public $status = 'Diproses';
    public $tanggapan_admin = '';

    public function mount(Keluhan $keluhan)
    {
        $user = Auth::user();
        if (!TenantPermissions::hasAnyRoleOrPermission($user, TenantPermissions::KELUHAN, 'process keluhan')) {
            abort(403, 'Anda tidak memiliki akses memproses keluhan.');
        }

        $this->keluhan = $keluhan;
        $this->status = $keluhan->status === 'Menunggu' ? 'Diproses' : $keluhan->status;
        $this->tanggapan_admin = $keluhan->tanggapan_admin ?? '';
    }

    public function save()
    {
        $user = Auth::user();
        if (!TenantPermissions::hasAnyRoleOrPermission($user, TenantPermissions::KELUHAN, 'process keluhan')) {
            abort(403, 'Akses ditolak.');
        }

        $this->validate([
            'status' => 'required|in:Menunggu,Diproses,Selesai,Ditolak',
            'tanggapan_admin' => 'nullable|string|max:1000',
        ]);

        $this->keluhan->update([
            'status' => $this->status,
            'tanggapan_admin' => $this->tanggapan_admin,
        ]);

        $this->dispatch('notify', message: 'Tanggapan dan status keluhan berhasil diperbarui');
        $this->dispatch('keluhanProcessed');
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.tenant.keluhan.process');
    }
}
