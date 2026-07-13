<?php

namespace App\Livewire\Tenant\Iuran;

use App\Models\PembayaranIuran;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';

    protected $listeners = ['iuranSaved' => '$refresh'];

    public function delete(PembayaranIuran $iuran)
    {
        if (!Auth::user()->hasAnyRole(['Tenant Owner', 'Ketua RT', 'Bendahara'])) {
            abort(403, 'Hanya pengurus yang dapat menghapus data iuran.');
        }

        $iuran->delete();
        $this->dispatch('notify', message: 'Data iuran berhasil dihapus');
    }

    public function approve(PembayaranIuran $iuran)
    {
        if (!Auth::user()->hasAnyRole(['Tenant Owner', 'Ketua RT', 'Bendahara'])) {
            abort(403, 'Akses ditolak.');
        }

        $iuran->update(['status' => 'Lunas']);
        $this->dispatch('notify', message: 'Iuran telah disetujui (Lunas)');
    }

    public function render()
    {
        $user = Auth::user();
        
        $query = PembayaranIuran::with(['rumah', 'warga'])
            ->when($this->filterStatus, function($q) {
                $q->where('status', $this->filterStatus);
            });

        if ($this->search) {
            $query->whereHas('rumah', function($q) {
                $q->where('nomor_blok', 'like', '%' . $this->search . '%');
            });
        }

        // Jika user adalah Warga biasa (tidak punya role pengurus), 
        // hanya tampilkan iuran rumah miliknya.
        if (!$user->hasAnyRole(['Tenant Owner', 'Ketua RT', 'Bendahara', 'Sekretaris'])) {
            if ($user->warga && $user->warga->id_rumah) {
                $query->where('id_rumah', $user->warga->id_rumah);
            } else {
                // Jika belum tertaut ke rumah mana pun, kosongkan hasil
                $query->where('id', '<', 0); 
            }
        }

        $iurans = $query->orderBy('tahun', 'desc')
                        ->orderBy('bulan', 'desc')
                        ->paginate(10);

        return view('livewire.tenant.iuran.index', [
            'iurans' => $iurans,
        ]);
    }
}
