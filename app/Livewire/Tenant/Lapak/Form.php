<?php

namespace App\Livewire\Tenant\Lapak;

use App\Models\ProdukLapak;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Form extends Component
{
    use WithFileUploads;

    public ?ProdukLapak $produk = null;
    public $nama_produk = '';
    public $deskripsi = '';
    public $harga = '';
    public $kategori = 'Lainnya';
    public $foto; // For new upload
    public $existingFoto = null; // For keeping track of existing image

    public function mount(ProdukLapak $produk = null)
    {
        $user = Auth::user();

        if ($produk && $produk->exists) {
            $isPengurus = $user->can('edit lapak') || $user->hasRole('Tenant Owner');
            if (!$isPengurus && $user->warga_id !== $produk->warga_id) {
                abort(403, 'Anda hanya dapat mengedit produk Anda sendiri.');
            }

            $this->produk = $produk;
            $this->nama_produk = $produk->nama_produk;
            $this->deskripsi = $produk->deskripsi;
            $this->harga = $produk->harga;
            $this->kategori = $produk->kategori;
            $this->existingFoto = $produk->foto;
        } else {
            if (!$user->can('create lapak') && !$user->hasRole('Tenant Owner') && !$user->warga_id) {
                abort(403, 'Anda tidak memiliki akses membuat produk.');
            }
        }
    }

    public function save()
    {
        abort_unless(auth()->user()->can('create lapak') || auth()->user()->can('edit lapak'), 403, 'Akses ditolak.');

        $user = Auth::user();
        if (!$user->warga_id) {
            // Pengurus tanpa data warga cannot sell, unless they link their account
            abort(403, 'Anda harus melengkapi data warga Anda terlebih dahulu sebelum dapat berjualan.');
        }

        $this->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'harga' => 'required|numeric|min:0',
            'kategori' => 'required|string|max:255',
            'foto' => 'nullable|image|max:2048', // Max 2MB image
        ]);

        $data = [
            'nama_produk' => $this->nama_produk,
            'deskripsi' => $this->deskripsi,
            'harga' => $this->harga,
            'kategori' => $this->kategori,
        ];

        if ($this->foto) {
            // Upload new photo
            $path = $this->foto->store('lapak', 'public');
            $data['foto'] = $path;

            // Delete old photo
            if ($this->produk && $this->existingFoto && Storage::disk('public')->exists($this->existingFoto)) {
                Storage::disk('public')->delete($this->existingFoto);
            }
        }

        if ($this->produk) {
            $this->produk->update($data);
            $this->dispatch('notify', message: 'Data produk berhasil diubah');
        } else {
            $data['warga_id'] = $user->warga_id;
            ProdukLapak::create($data);
            $this->dispatch('notify', message: 'Produk baru berhasil ditambahkan');
        }

        $this->dispatch('lapakSaved');
        $this->dispatch('closeModal');
    }

    public function render()
    {
        return view('livewire.tenant.lapak.form');
    }
}
