<?php

namespace App\Livewire\Tenant\Rumah;

use App\Models\Rumah;
use Livewire\Component;

class Form extends Component
{
    public ?Rumah $rumah = null;
    public $nomor_blok = '';
    public $keterangan = '';

    public function mount(Rumah $rumah = null)
    {
        if ($rumah && $rumah->exists) {
            $this->rumah = $rumah;
            $this->nomor_blok = $rumah->nomor_blok;
            $this->keterangan = $rumah->keterangan;
        }
    }

    public function save()
    {
        $this->validate([
            'nomor_blok' => 'required|string|max:255|unique:rumah,nomor_blok' . ($this->rumah ? ',' . $this->rumah->id : ''),
            'keterangan' => 'nullable|string',
        ]);

        if ($this->rumah) {
            $this->rumah->update([
                'nomor_blok' => $this->nomor_blok,
                'keterangan' => $this->keterangan,
            ]);
            $this->dispatch('notify', message: 'Data rumah berhasil diubah');
        } else {
            // Check limits based on Tenant's plan
            $plan_id = tenant('plan_id');
            if ($plan_id) {
                $plan = \App\Models\Plan::find($plan_id);
                if ($plan && Rumah::count() >= $plan->max_houses) {
                    $this->addError('nomor_blok', 'Limit kapasitas tercapai! Paket Anda hanya mengizinkan maksimal ' . $plan->max_houses . ' rumah.');
                    return;
                }
            }

            Rumah::create([
                'nomor_blok' => $this->nomor_blok,
                'keterangan' => $this->keterangan,
            ]);
            $this->dispatch('notify', message: 'Rumah baru berhasil ditambahkan');
        }

        $this->dispatch('rumahSaved');
        $this->dispatch('closeModal');
    }

    public function render()
    {
        return view('livewire.tenant.rumah.form');
    }
}
