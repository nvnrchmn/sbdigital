<?php

namespace App\Livewire\Central\Plan;

use Livewire\Component;

class Form extends Component
{
    public ?\App\Models\Plan $plan = null;
    public $name;
    public $description;
    public $max_houses = 50;
    public $price = 0;
    public $billing_cycle = 'monthly';
    public $features = [];

    public function mount(?\App\Models\Plan $plan = null)
    {
        abort_unless(auth()->user()->hasRole('Super Admin'), 403, 'Akses ditolak.');

        if ($plan && $plan->exists) {
            $this->plan = $plan;
            $this->name = $plan->name;
            $this->description = $plan->description;
            $this->max_houses = $plan->max_houses;
            $this->price = $plan->price;
            $this->billing_cycle = $plan->billing_cycle;
            $this->features = $plan->features ?? [];
        }
    }

    public function save()
    {
        abort_unless(auth()->user()->hasRole('Super Admin'), 403, 'Akses ditolak.');

        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_houses' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|in:monthly,yearly',
            'features' => 'array',
        ]);

        if (!$this->plan) {
            \App\Models\Plan::create([
                'name' => $this->name,
                'description' => $this->description,
                'max_houses' => $this->max_houses,
                'price' => $this->price,
                'billing_cycle' => $this->billing_cycle,
                'features' => $this->features,
            ]);
        } else {
            $this->plan->update([
                'name' => $this->name,
                'description' => $this->description,
                'max_houses' => $this->max_houses,
                'price' => $this->price,
                'billing_cycle' => $this->billing_cycle,
                'features' => $this->features,
            ]);
        }

        return redirect()->route('superadmin.plans.index');
    }

    public function render()
    {
        return view('livewire.central.plan.form')
            ->layout('layouts.superadmin');
    }
}
