<?php

namespace App\Livewire\Tenant\Laporan;

use App\Models\LaporanWarga;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Support\TenantPermissions;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';

    protected $listeners = ['laporanSaved' => '$refresh'];

    public function delete(LaporanWarga $laporan)
    {
        $user = Auth::user();
        $isPengurus = TenantPermissions::hasAnyRoleOrPermission($user, TenantPermissions::LAPORAN, ['edit laporan', 'delete laporan']);
        
        if (!$isPengurus && $user->warga_id !== $laporan->warga_id) {
            abort(403, 'Anda hanya dapat menghapus laporan Anda sendiri.');
        }

        $laporan->delete();
        $this->dispatch('notify', message: 'Laporan berhasil dihapus');
    }

    public function publish(LaporanWarga $laporan)
    {
        if (!TenantPermissions::hasAnyRoleOrPermission(Auth::user(), TenantPermissions::LAPORAN, 'approve laporan')) {
            abort(403, 'Akses ditolak.');
        }

        $laporan->update(['is_published' => true]);
        $this->dispatch('notify', message: 'Laporan telah dipublikasikan');
    }

    public function changeStatus(LaporanWarga $laporan, $newStatus)
    {
        if (!TenantPermissions::hasAnyRoleOrPermission(Auth::user(), TenantPermissions::LAPORAN, 'edit laporan')) {
            abort(403, 'Akses ditolak.');
        }

        $laporan->update(['status' => $newStatus]);
        $this->dispatch('notify', message: 'Status laporan diubah menjadi ' . $newStatus);
    }

    public function render()
    {
        $user = Auth::user();
        $isPengurus = TenantPermissions::hasAnyRoleOrPermission($user, TenantPermissions::LAPORAN, ['edit laporan', 'approve laporan']);

        $query = LaporanWarga::with('warga')
            ->where(function($q) {
                $q->where('judul', 'like', '%' . $this->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterStatus, function($q) {
                $q->where('status', $this->filterStatus);
            });

        if (!$isPengurus) {
            $query->where(function($q) use ($user) {
                $q->where('is_published', true)
                  ->orWhere('warga_id', $user->warga_id);
            });
        }

        $laporans = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.tenant.laporan.index', [
            'laporans' => $laporans,
            'isPengurus' => $isPengurus,
        ]);
    }
}
