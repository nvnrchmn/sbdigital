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
        if (!$this->userId) return;

        $user = User::findOrFail($this->userId);
        
        // Tenant Owner cannot be removed from their own role by mistake if we want to protect it, 
        // but let's just sync the roles.
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
