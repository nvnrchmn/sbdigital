<?php

namespace App\Livewire\Tenant\Pengumuman;

use App\Models\Pengumuman;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    public $pengumumanId = null;
    public $judul = '';
    public $isi = '';
    public $prioritas = false;

    public function mount($pengumuman = null)
    {
        // FIX (P1 - Broken Access Control): sebelumnya tidak ada pengecekan role,
        // warga biasa bisa membuat/mengedit pengumuman (risiko defacement/misinformasi).
        abort_unless(
            Auth::user()->hasAnyRole(['Tenant Owner', 'Ketua RT', 'Wakil Ketua', 'Sekretaris']),
            403,
            'Anda tidak memiliki akses untuk mengelola pengumuman.'
        );

        if ($pengumuman) {
            $data = Pengumuman::findOrFail($pengumuman);
            $this->pengumumanId = $data->id;
            $this->judul = $data->judul;
            $this->isi = $data->isi;
            $this->prioritas = $data->prioritas;
        }
    }

    public function save()
    {
        // FIX: cek ulang di save(), konsisten dengan pola di modul Iuran/Warga.
        abort_unless(
            Auth::user()->hasAnyRole(['Tenant Owner', 'Ketua RT', 'Wakil Ketua', 'Sekretaris']),
            403
        );

        $this->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'prioritas' => 'boolean'
        ]);

        Pengumuman::updateOrCreate(
            ['id' => $this->pengumumanId],
            [
                'judul' => $this->judul,
                'isi' => $this->isi,
                'prioritas' => $this->prioritas,
                'admin_id' => Auth::id(),
            ]
        );

        $this->dispatch('pengumumanSaved');
        $this->dispatch('closeModal');
        $this->dispatch('notify', message: 'Pengumuman berhasil disimpan');
    }

    public function render()
    {
        return view('livewire.tenant.pengumuman.form');
    }
}
