<?php

namespace App\Livewire\Tenant\Role;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    protected $listeners = ['roleSaved' => '$refresh'];

    public function mount()
    {
        // FIX (P0 - Broken Access Control): sebelumnya halaman daftar user + role
        // ini bisa diakses siapa saja yang login (termasuk warga biasa).
        abort_unless(
            auth()->user()->can('manage roles'),
            403,
            'Hanya Tenant Owner yang dapat mengakses manajemen role.'
        );
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::query()
            ->with('roles', 'warga')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.tenant.role.index', [
            'users' => $users
        ]);
    }
}
