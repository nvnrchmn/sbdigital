<?php

namespace App\Livewire\Tenant\Surat;

use App\Models\SuratPengantar;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    public ?SuratPengantar $surat = null;
    public $jenis_surat = 'Pengantar Pembuatan KTP';
    public $keperluan = '';

    public function mount(SuratPengantar $surat = null)
    {
        $user = Auth::user();

        if ($surat && $surat->exists) {
            $isPengurus = $user->can('edit surat') || $user->hasRole('Tenant Owner');
            if (!$isPengurus && $user->warga_id !== $surat->warga_id) {
                abort(403, 'Anda hanya dapat mengedit permohonan Anda sendiri.');
            }
            if ($surat->status !== 'Menunggu' && !$isPengurus) {
                abort(403, 'Permohonan yang sudah diproses tidak dapat diedit.');
            }

            $this->surat = $surat;
            $this->jenis_surat = $surat->jenis_surat;
            $this->keperluan = $surat->keperluan;
        } else {
            if (!$user->can('create surat') && !$user->hasRole('Tenant Owner') && !$user->warga_id) {
                abort(403, 'Anda tidak memiliki akses.');
            }
        }
    }

    public function save()
    {
        abort_unless(auth()->user()->can('create surat') || auth()->user()->can('edit surat'), 403, 'Akses ditolak.');

        $user = Auth::user();
        if (!$user->warga_id) {
            abort(403, 'Anda harus melengkapi data warga Anda terlebih dahulu sebelum mengajukan surat.');
        }

        $this->validate([
            'jenis_surat' => 'required|string|max:255',
            'keperluan' => 'required|string|max:1000',
        ]);

        $data = [
            'jenis_surat' => $this->jenis_surat,
            'keperluan' => $this->keperluan,
        ];

        if ($this->surat) {
            $this->surat->update($data);
            $this->dispatch('notify', message: 'Data permohonan berhasil diubah');
        } else {
            $data['warga_id'] = $user->warga_id;
            $data['status'] = 'Menunggu';
            SuratPengantar::create($data);
            $this->dispatch('notify', message: 'Permohonan surat berhasil diajukan');
        }

        $this->dispatch('suratSaved');
        $this->dispatch('closeModal');
    }

    public function render()
    {
        return view('livewire.tenant.surat.form');
    }
}
