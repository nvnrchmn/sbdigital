<?php

namespace App\Livewire\Tenant\Lapak;

use App\Models\ProdukLapak;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterKategori = '';

    protected $listeners = ['lapakSaved' => '$refresh'];

    public function delete(ProdukLapak $produk)
    {
        $user = Auth::user();
        $isPengurus = $user->can('edit lapak') || $user->can('delete lapak') || $user->hasRole('Tenant Owner');
        
        if (!$isPengurus && $user->warga_id !== $produk->warga_id) {
            abort(403, 'Anda hanya dapat menghapus produk Anda sendiri.');
        }

        if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
            Storage::disk('public')->delete($produk->foto);
        }

        $produk->delete();
        $this->dispatch('notify', message: 'Produk berhasil dihapus dari lapak');
    }

    public function render()
    {
        $query = ProdukLapak::with('warga')
            ->where(function($q) {
                $q->where('nama_produk', 'like', '%' . $this->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterKategori, function($q) {
                $q->where('kategori', $this->filterKategori);
            });

        $produks = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('livewire.tenant.lapak.index', [
            'produks' => $produks,
        ]);
    }
}
