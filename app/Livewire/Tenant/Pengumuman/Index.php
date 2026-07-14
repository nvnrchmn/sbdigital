<?php

namespace App\Livewire\Tenant\Pengumuman;

use App\Models\Pengumuman;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    protected $listeners = ['pengumumanSaved' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        abort_unless(auth()->user()->can('delete pengumuman'), 403, 'Akses ditolak.');

        Pengumuman::findOrFail($id)->delete();
        $this->dispatch('notify', message: 'Pengumuman berhasil dihapus');
    }

    public function render()
    {
        $pengumumans = Pengumuman::query()
            ->with('admin')
            ->when($this->search, function ($query) {
                $query->where('judul', 'like', '%' . $this->search . '%')
                    ->orWhere('isi', 'like', '%' . $this->search . '%');
            })
            ->latest('prioritas')
            ->latest()
            ->paginate(10);

        return view('livewire.tenant.pengumuman.index', [
            'pengumumans' => $pengumumans
        ]);
    }
}
