<?php

namespace App\Livewire\Tenant\Rumah;

use App\Models\Rumah;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    protected $listeners = ['rumahSaved' => '$refresh'];

    public function delete(Rumah $rumah)
    {
        $rumah->delete();
        $this->dispatch('notify', message: 'Data rumah berhasil dihapus');
    }

    public function render()
    {
        $rumahs = Rumah::where('nomor_blok', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.tenant.rumah.index', [
            'rumahs' => $rumahs,
        ]);
    }
}
