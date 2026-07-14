<?php

namespace App\Livewire\Central\Tenant;

use Livewire\Component;

class Form extends Component
{
    public ?\App\Models\Tenant $tenant = null;
    public $nama_perumahan;
    public $domain;
    public $nama_admin;
    public $email_admin;
    public $password_admin;
    public $plan_id;

    public function mount(?\App\Models\Tenant $tenant = null)
    {
        abort_unless(auth()->user()->hasRole('Super Admin'), 403, 'Akses ditolak.');

        if ($tenant && $tenant->exists) {
            $this->tenant = $tenant;
            $this->nama_perumahan = $tenant->nama_perumahan;
            $this->nama_admin = $tenant->nama_admin;
            $this->email_admin = $tenant->email_admin;
            $this->plan_id = $tenant->plan_id;
            $this->domain = $tenant->id; // Using 'domain' property to hold the 'id' (Path) for backwards compatibility in UI state temporarily
        }
    }

    public function save()
    {
        abort_unless(auth()->user()->hasRole('Super Admin'), 403, 'Akses ditolak.');

        $this->validate([
            'nama_perumahan' => 'required|string|max:255',
            'domain' => 'required|string|max:50|alpha_dash|unique:tenants,id,' . ($this->tenant ? $this->tenant->id : ''),
            'nama_admin' => 'required|string|max:255',
            'email_admin' => 'required|email|max:255',
            'password_admin' => $this->tenant ? 'nullable|min:8' : 'required|min:8',
            'plan_id' => 'required|exists:plans,id',
        ]);

        if (!$this->tenant) {
            $tenant = \App\Models\Tenant::create([
                'id' => $this->domain, // Set ID to be the path
                'nama_perumahan' => $this->nama_perumahan,
                'nama_admin' => $this->nama_admin,
                'email_admin' => $this->email_admin,
                'plan_id' => $this->plan_id,
            ]);

            // Call Logikraf API
            $logikraf = new \App\Services\LogikrafService();
            $subaccount = $logikraf->createSubAccount($tenant->id, $this->nama_perumahan, $this->email_admin);
            
            if ($subaccount && isset($subaccount['id'])) {
                $tenant->update(['logikraf_subaccount_id' => $subaccount['id']]);
            }

        } else {
            // Cannot easily change primary key 'id' in stancl/tenancy once created, 
            // so we only update the other fields.
            $this->tenant->update([
                'nama_perumahan' => $this->nama_perumahan,
                'nama_admin' => $this->nama_admin,
                'email_admin' => $this->email_admin,
                'plan_id' => $this->plan_id,
            ]);
        }

        return redirect()->route('superadmin.tenants.index');
    }

    public function render()
    {
        $plans = \App\Models\Plan::all();
        return view('livewire.central.tenant.form', compact('plans'))
            ->layout('layouts.superadmin');
    }
}
