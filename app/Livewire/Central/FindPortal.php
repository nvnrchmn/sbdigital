<?php

namespace App\Livewire\Central;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class FindPortal extends Component
{
    public $email = '';
    public $foundTenants = [];
    public $hasSearched = false;

    public function search()
    {
        $this->validate([
            'email' => 'required|email'
        ]);

        $this->hasSearched = true;
        $this->foundTenants = [];
        $email = $this->email;

        // 1. Check if it's a Central Superadmin User
        // Note: Central DB uses 'users' table.
        $centralUser = DB::connection(config('tenancy.database.central_connection', 'mysql'))
            ->table('users')
            ->where('email', $email)
            ->first();

        if ($centralUser) {
            // Superadmin found, redirect to central login
            return redirect()->route('login')->with('email', $email);
        }

        // 2. Iterate through all Tenants
        $tenants = Tenant::all();
        $matchedTenants = [];

        foreach ($tenants as $tenant) {
            try {
                $tenant->run(function () use ($email, $tenant, &$matchedTenants) {
                    // Check if user exists in this tenant's DB
                    $user = DB::table('users')->where('email', $email)->first();
                    if ($user) {
                        $matchedTenants[] = [
                            'id' => $tenant->id,
                            'name' => $tenant->name ?? $tenant->id,
                            'login_url' => url('/' . $tenant->id . '/login')
                        ];
                    }
                });
            } catch (\Exception $e) {
                // Abaikan jika database tenant rusak atau belum terbuat sempurna
                continue;
            }
        }

        $this->foundTenants = $matchedTenants;

        // Auto-redirect if exactly 1 tenant is found
        if (count($this->foundTenants) === 1) {
            return redirect($this->foundTenants[0]['login_url']);
        }
    }

    public function render()
    {
        return view('livewire.central.find-portal');
    }
}
