<?php

namespace App\Livewire\Tenant\Surat;

use App\Models\SuratPengantar;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Support\TenantPermissions;

class Approve extends Component
{
    public SuratPengantar $surat;
    public $status = 'Disetujui';
    public $nomor_surat = '';
    public $keterangan_admin = '';

    public function mount(SuratPengantar $surat)
    {
        $user = Auth::user();
        if (!TenantPermissions::hasAnyRoleOrPermission($user, TenantPermissions::SURAT, 'approve surat')) {
            abort(403, 'Anda tidak memiliki akses menyetujui surat.');
        }

        $this->surat = $surat;
        $this->status = $surat->status === 'Menunggu' ? 'Disetujui' : $surat->status;
        $this->nomor_surat = $surat->nomor_surat ?? '';
        $this->keterangan_admin = $surat->keterangan_admin ?? '';
    }

    public function save()
    {
        $user = Auth::user();
        if (!TenantPermissions::hasAnyRoleOrPermission($user, TenantPermissions::SURAT, 'approve surat')) {
            abort(403, 'Akses ditolak.');
        }

        $rules = [
            'status' => 'required|in:Menunggu,Disetujui,Ditolak',
            'keterangan_admin' => 'nullable|string|max:1000',
        ];

        // Jika disetujui, nomor surat bisa diisi
        if ($this->status === 'Disetujui') {
            $rules['nomor_surat'] = 'required|string|max:255';
        }

        $this->validate($rules);

        $this->surat->update([
            'status' => $this->status,
            'nomor_surat' => $this->status === 'Disetujui' ? $this->nomor_surat : null,
            'keterangan_admin' => $this->keterangan_admin,
            'tanggal_disetujui' => $this->status === 'Disetujui' ? now() : null,
        ]);

        $this->dispatch('notify', message: 'Status surat berhasil diperbarui');
        $this->dispatch('suratApproved');
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.tenant.surat.approve');
    }
}
