<?php

namespace App\Livewire\Central\Plan;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $plans = \App\Models\Plan::withCount('tenants')->get();

        return view('livewire.central.plan.index', compact('plans'))
            ->layout('layouts.superadmin');
    }
}
