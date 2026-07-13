<?php

namespace App\Livewire\Tenant\Keluhan;

use App\Models\Keluhan;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterKategori = '';
    public $filterStatus = '';

    protected $listeners = ['keluhanSaved' => '$refresh', 'keluhanProcessed' => '$refresh'];

    public function delete(Keluhan $keluhan)
    {
        $user = Auth::user();
        $isPengurus = $user->can('delete keluhan') || $user->hasRole('Tenant Owner');
        
        // Warga hanya bisa hapus miliknya sendiri & statusnya harus Menunggu
        if (!$isPengurus) {
            if ($user->warga_id !== $keluhan->warga_id) {
                abort(403, 'Anda hanya dapat menghapus keluhan Anda sendiri.');
            }
            if ($keluhan->status !== 'Menunggu') {
                abort(403, 'Keluhan yang sudah diproses tidak dapat dihapus.');
            }
        }

        if ($keluhan->foto && Storage::disk('public')->exists($keluhan->foto)) {
            Storage::disk('public')->delete($keluhan->foto);
        }

        $keluhan->delete();
        $this->dispatch('notify', message: 'Laporan keluhan berhasil dihapus');
    }

    public function render()
    {
        $user = Auth::user();
        $isPengurus = $user->can('process keluhan') || $user->hasRole('Tenant Owner');

        $query = Keluhan::with('warga')
            ->where(function($q) {
                $q->where('judul', 'like', '%' . $this->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $this->search . '%')
                  ->orWhere('lokasi', 'like', '%' . $this->search . '%')
                  ->orWhereHas('warga', function($q) {
                      $q->where('nama_lengkap', 'like', '%' . $this->search . '%');
                  });
            })
            ->when($this->filterKategori, function($q) {
                $q->where('kategori', $this->filterKategori);
            })
            ->when($this->filterStatus, function($q) {
                $q->where('status', $this->filterStatus);
            });

        $keluhans = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.tenant.keluhan.index', [
            'keluhans' => $keluhans,
            'isPengurus' => $isPengurus,
        ]);
    }
}
