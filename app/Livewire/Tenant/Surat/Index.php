<?php

namespace App\Livewire\Tenant\Surat;

use App\Models\SuratPengantar;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Support\TenantPermissions;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';

    protected $listeners = ['suratSaved' => '$refresh', 'suratApproved' => '$refresh'];

    public function delete(SuratPengantar $surat)
    {
        $user = Auth::user();
        
        // Hanya bisa menghapus jika statusnya masih Menunggu, ATAU jika user punya permission delete surat
        if ($surat->status !== 'Menunggu' && !TenantPermissions::hasAnyRoleOrPermission($user, TenantPermissions::SURAT, 'delete surat')) {
            abort(403, 'Anda tidak dapat menghapus surat yang sudah diproses.');
        }

        // Warga hanya bisa hapus suratnya sendiri
        if (!TenantPermissions::hasAnyRoleOrPermission($user, TenantPermissions::SURAT, 'delete surat') && $user->warga_id !== $surat->warga_id) {
            abort(403, 'Anda hanya dapat menghapus pengajuan Anda sendiri.');
        }

        $surat->delete();
        $this->dispatch('notify', message: 'Pengajuan surat berhasil dihapus');
    }

    public function render()
    {
        $user = Auth::user();
        $isPengurus = TenantPermissions::hasAnyRoleOrPermission($user, TenantPermissions::SURAT, ['view surat', 'approve surat']);

        $query = SuratPengantar::with('warga')
            ->where(function($q) {
                $q->where('jenis_surat', 'like', '%' . $this->search . '%')
                  ->orWhere('keperluan', 'like', '%' . $this->search . '%')
                  ->orWhereHas('warga', function($q) {
                      $q->where('nama_lengkap', 'like', '%' . $this->search . '%');
                  });
            })
            ->when($this->filterStatus, function($q) {
                $q->where('status', $this->filterStatus);
            });

        // Warga biasa hanya melihat pengajuannya sendiri
        if (!$isPengurus) {
            $query->where('warga_id', $user->warga_id);
        }

        $surats = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.tenant.surat.index', [
            'surats' => $surats,
            'isPengurus' => $isPengurus,
        ]);
    }
}
