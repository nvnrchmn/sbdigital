<?php

namespace App\Livewire\Tenant\Laporan;

use App\Models\LaporanWarga;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    public ?LaporanWarga $laporan = null;
    public $judul = '';
    public $deskripsi = '';

    public function mount(LaporanWarga $laporan = null)
    {
        if ($laporan && $laporan->exists) {
            $this->laporan = $laporan;
            $this->judul = $laporan->judul;
            $this->deskripsi = $laporan->deskripsi;
        }
    }

    public function save()
    {
        $user = Auth::user();

        if (!$user->warga_id) {
            $this->addError('judul', 'Akun Anda belum dikaitkan dengan data Warga, sehingga tidak dapat membuat laporan.');
            return;
        }

        $this->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        $isPengurus = $user->hasAnyRole(['Tenant Owner', 'Ketua RT', 'Sekretaris']);

        if ($this->laporan) {
            if (!$isPengurus && $user->warga_id !== $this->laporan->warga_id) {
                abort(403);
            }
            $this->laporan->update([
                'judul' => $this->judul,
                'deskripsi' => $this->deskripsi,
            ]);
            $this->dispatch('notify', message: 'Laporan berhasil diperbarui');
        } else {
            LaporanWarga::create([
                'warga_id' => $user->warga_id,
                'judul' => $this->judul,
                'deskripsi' => $this->deskripsi,
                'is_published' => $isPengurus ? true : false,
            ]);
            $this->dispatch('notify', message: 'Laporan berhasil dikirim. ' . (!$isPengurus ? 'Menunggu persetujuan.' : ''));
        }

        $this->dispatch('laporanSaved');
        $this->dispatch('closeModal');
    }

    public function render()
    {
        return view('livewire.tenant.laporan.form');
    }
}
