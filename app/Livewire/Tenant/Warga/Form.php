<?php

namespace App\Livewire\Tenant\Warga;

use App\Models\Warga;
use App\Models\Rumah;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    public ?Warga $warga = null;
    public $nik = '';
    public $nama_lengkap = '';
    public $id_rumah = '';
    public $no_hp = '';
    public $status_warga = 'Tetap';

    public function mount(Warga $warga = null)
    {
        if (!Auth::user()->hasAnyRole(['Tenant Owner', 'Ketua RT', 'Sekretaris'])) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        if ($warga && $warga->exists) {
            $this->warga = $warga;
            $this->nik = $warga->nik;
            $this->nama_lengkap = $warga->nama_lengkap;
            $this->id_rumah = $warga->id_rumah;
            $this->no_hp = $warga->no_hp;
            $this->status_warga = $warga->status_warga;
        }
    }

    public function save()
    {
        if (!Auth::user()->hasAnyRole(['Tenant Owner', 'Ketua RT', 'Sekretaris'])) {
            abort(403);
        }

        $this->validate([
            'nik' => 'required|string|max:255|unique:warga,nik' . ($this->warga ? ',' . $this->warga->id : ''),
            'nama_lengkap' => 'required|string|max:255',
            'id_rumah' => 'required|exists:rumah,id',
            'no_hp' => 'nullable|string|max:255',
            'status_warga' => 'required|in:Tetap,Kontrak',
        ]);

        if ($this->warga) {
            $this->warga->update([
                'nik' => $this->nik,
                'nama_lengkap' => $this->nama_lengkap,
                'id_rumah' => $this->id_rumah,
                'no_hp' => $this->no_hp,
                'status_warga' => $this->status_warga,
            ]);
            $this->dispatch('notify', message: 'Data warga berhasil diubah');
        } else {
            Warga::create([
                'nik' => $this->nik,
                'nama_lengkap' => $this->nama_lengkap,
                'id_rumah' => $this->id_rumah,
                'no_hp' => $this->no_hp,
                'status_warga' => $this->status_warga,
            ]);
            $this->dispatch('notify', message: 'Warga baru berhasil ditambahkan');
        }

        $this->dispatch('wargaSaved');
        $this->dispatch('closeModal');
    }

    public function render()
    {
        return view('livewire.tenant.warga.form', [
            'rumahs' => Rumah::orderBy('nomor_blok')->get()
        ]);
    }
}
