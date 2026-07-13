<?php

namespace App\Livewire\Central\Dashboard;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $totalTenants = \App\Models\Tenant::count();
        $recentTenants = \App\Models\Tenant::latest()->take(5)->get();

        $totalWarga = 0;
        $totalKasBeredar = 0;

        $tenants = \App\Models\Tenant::all();
        foreach ($tenants as $tenant) {
            try {
                tenancy()->initialize($tenant);
                if (\Illuminate\Support\Facades\Schema::hasTable('warga')) {
                    $totalWarga += \Illuminate\Support\Facades\DB::table('warga')->count();
                }
                if (\Illuminate\Support\Facades\Schema::hasTable('pembayaran_iuran')) {
                    $totalKasBeredar += \Illuminate\Support\Facades\DB::table('pembayaran_iuran')->where('status', 'Lunas')->sum('nominal');
                }
            } catch (\Exception $e) {
                // Ignore missing tables or schema errors
            } finally {
                if (tenancy()->initialized) {
                    tenancy()->end();
                }
            }
        }

        return view('livewire.central.dashboard.index', compact('totalTenants', 'recentTenants', 'totalWarga', 'totalKasBeredar'))
            ->layout('layouts.superadmin');
    }
}
