<?php

namespace App\Livewire\Tenant\Warga;

use App\Models\Warga;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    protected $listeners = ['wargaSaved' => '$refresh'];

    public function delete(Warga $warga)
    {
        if (!auth()->user()->hasAnyRole(['Tenant Owner', 'Ketua RT', 'Sekretaris'])) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus warga.');
        }

        $warga->delete();
        $this->dispatch('notify', message: 'Data warga berhasil dihapus');
    }

    public function render()
    {
        $wargas = Warga::with('rumah')
            ->where('nama_lengkap', 'like', '%' . $this->search . '%')
            ->orWhere('nik', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.tenant.warga.index', [
            'wargas' => $wargas,
        ]);
    }
}
