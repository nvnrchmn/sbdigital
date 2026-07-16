<?php

namespace App\Livewire\Tenant\Keluhan;

use App\Models\Keluhan;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Form extends Component
{
    use WithFileUploads;

    public $keluhan = null;
    public $judul = '';
    public $deskripsi = '';
    public $kategori = 'Fasilitas Umum';
    public $lokasi = '';
    public $foto;
    public $existingFoto = null;

    public function mount($keluhan = null)
    {
        $user = Auth::user();

        if ($keluhan) {
            $keluhan = $keluhan instanceof Keluhan ? $keluhan : Keluhan::findOrFail($keluhan);
            $isPengurus = $user->can('edit keluhan') || $user->hasRole('Tenant Owner');
            
            // Warga biasa hanya bisa edit laporannya sendiri yang masih Menunggu
            if (!$isPengurus) {
                if ($user->warga_id !== $keluhan->warga_id) {
                    abort(403, 'Anda hanya dapat mengedit laporan Anda sendiri.');
                }
                if ($keluhan->status !== 'Menunggu') {
                    abort(403, 'Laporan yang sudah diproses tidak dapat diedit.');
                }
            }

            $this->keluhan = $keluhan;
            $this->judul = $keluhan->judul;
            $this->deskripsi = $keluhan->deskripsi;
            $this->kategori = $keluhan->kategori;
            $this->lokasi = $keluhan->lokasi;
            $this->existingFoto = $keluhan->foto;
        } else {
            if (!$user->can('create keluhan') && !$user->hasRole('Tenant Owner') && !$user->warga_id) {
                abort(403, 'Anda tidak memiliki akses membuat laporan keluhan.');
            }
        }
    }

    public function save()
    {
        abort_unless(auth()->user()->can('create keluhan') || auth()->user()->can('edit keluhan'), 403, 'Akses ditolak.');

        $user = Auth::user();
        if (!$user->warga_id) {
            abort(403, 'Anda harus melengkapi data warga Anda terlebih dahulu sebelum melapor.');
        }

        $this->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:1000',
            'kategori' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = [
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'kategori' => $this->kategori,
            'lokasi' => $this->lokasi,
        ];

        if ($this->foto) {
            $path = $this->foto->store('keluhan', 'public');
            $data['foto'] = $path;

            if ($this->keluhan && $this->existingFoto && Storage::disk('public')->exists($this->existingFoto)) {
                Storage::disk('public')->delete($this->existingFoto);
            }
        }

        if ($this->keluhan) {
            $this->keluhan->update($data);
            $this->dispatch('notify', message: 'Data keluhan berhasil diubah');
        } else {
            $data['warga_id'] = $user->warga_id;
            $data['status'] = 'Menunggu';
            Keluhan::create($data);
            $this->dispatch('notify', message: 'Keluhan baru berhasil dikirimkan');
        }

        $this->dispatch('keluhanSaved');
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.tenant.keluhan.form');
    }
}
