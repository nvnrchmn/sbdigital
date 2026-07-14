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
            $this->nik = $warga->nik; // otomatis ter-decrypt via cast di Model
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

        // FIX (Fitur Enkripsi NIK): kolom `nik` sekarang terenkripsi (ciphertext beda
        // setiap kali walau plaintext sama), jadi Laravel `unique:warga,nik` bawaan
        // TIDAK BISA dipakai lagi. Uniqueness dicek manual lewat kolom `nik_hash`
        // (HMAC deterministik dari NIK asli) setelah validasi format.
        $this->validate([
            'nik' => ['required', 'string', 'regex:/^\d{16}$/'], // NIK Indonesia = 16 digit angka
            'nama_lengkap' => 'required|string|max:255',
            'id_rumah' => 'required|exists:rumah,id',
            'no_hp' => 'nullable|string|max:255',
            'status_warga' => 'required|in:Tetap,Kontrak',
        ], [
            'nik.regex' => 'NIK harus terdiri dari 16 digit angka.',
        ]);

        $nikHash = hash_hmac('sha256', $this->nik, config('app.key'));

        $duplicateExists = Warga::where('nik_hash', $nikHash)
            ->when($this->warga, fn ($q) => $q->where('id', '!=', $this->warga->id))
            ->exists();

        if ($duplicateExists) {
            $this->addError('nik', 'NIK ini sudah terdaftar untuk warga lain.');
            return;
        }

        if ($this->warga) {
            $this->warga->update([
                'nik' => $this->nik, // mutator di Model otomatis enkripsi + isi nik_hash
                'nama_lengkap' => $this->nama_lengkap,
                'id_rumah' => $this->id_rumah,
                'no_hp' => $this->no_hp,
                'status_warga' => $this->status_warga,
            ]);
            $this->dispatch('notify', message: 'Data warga berhasil diubah');
        } else {
            Warga::create([
                'nik' => $this->nik, // mutator di Model otomatis enkripsi + isi nik_hash
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
