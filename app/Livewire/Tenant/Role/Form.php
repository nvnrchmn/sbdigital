<?php

namespace App\Livewire\Tenant\Role;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Form extends Component
{
    public $userId;
    public $name;
    public $email;
    public $selectedRoles = [];

    public function mount($user = null)
    {
        // FIX (P0 - Privilege Escalation): sebelumnya tidak ada pengecekan sama sekali,
        // sehingga warga biasa bisa membuka form ini dan self-assign role apapun.
        abort_unless(
            auth()->user()->can('manage roles'),
            403,
            'Hanya Tenant Owner yang dapat mengatur role pengguna.'
        );

        if ($user) {
            $data = User::findOrFail($user);
            $this->userId = $data->id;
            $this->name = $data->name;
            $this->email = $data->email;
            $this->selectedRoles = $data->roles->pluck('name')->toArray();
        }
    }

    public function save()
    {
        // FIX: cek ulang di save(), jangan hanya andalkan mount().
        // Livewire bisa memanggil action tanpa re-run mount() dalam beberapa skenario request.
        abort_unless(auth()->user()->can('manage roles'), 403);

        if (!$this->userId) return;

        $user = User::findOrFail($this->userId);

        // FIX: cegah Tenant Owner yang sedang login mencabut role "Tenant Owner"
        // dari dirinya sendiri, supaya tenant tidak kehilangan pemilik akun.
        $isEditingSelf = $user->id === auth()->id();
        $isRemovingOwnerRole = $user->hasRole('Tenant Owner') && !in_array('Tenant Owner', $this->selectedRoles);

        if ($isEditingSelf && $isRemovingOwnerRole) {
            $this->addError('selectedRoles', 'Anda tidak dapat mencabut role Tenant Owner dari akun Anda sendiri. Tugaskan Tenant Owner lain terlebih dahulu.');
            return;
        }

        // FIX: cegah non-Tenant Owner (kalau suatu saat permission 'manage roles' diberikan
        // ke role lain) menaikkan seseorang menjadi Tenant Owner tanpa hak penuh.
        if (in_array('Tenant Owner', $this->selectedRoles) && !auth()->user()->hasRole('Tenant Owner')) {
            $this->addError('selectedRoles', 'Hanya Tenant Owner yang dapat menugaskan role Tenant Owner ke pengguna lain.');
            return;
        }

        $user->syncRoles($this->selectedRoles);

        $this->dispatch('roleSaved');
        $this->dispatch('closeModal');
        $this->dispatch('notify', message: 'Role pengguna berhasil diperbarui');
    }

    public function render()
    {
        $availableRoles = Role::whereNotIn('name', ['Super Admin'])->get();

        return view('livewire.tenant.role.form', [
            'availableRoles' => $availableRoles
        ]);
    }
}
