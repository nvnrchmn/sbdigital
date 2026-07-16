<?php

namespace App\Livewire\Tenant\Laporan;

use App\Models\LaporanWarga;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Support\TenantPermissions;

class Form extends Component
{
    public $laporan = null;
    public $judul = '';
    public $deskripsi = '';

    public function mount($laporan = null)
    {
        $user = Auth::user();

        if (!$user->warga_id && !TenantPermissions::hasAnyRoleOrPermission($user, TenantPermissions::LAPORAN, ['create laporan', 'edit laporan'])) {
            abort(403, 'Akses ditolak.');
        }

        if ($laporan) {
            $laporan = $laporan instanceof LaporanWarga ? $laporan : LaporanWarga::findOrFail($laporan);
            $this->laporan = $laporan;
            $this->judul = $laporan->judul;
            $this->deskripsi = $laporan->deskripsi;
        }
    }

    public function save()
    {
        $user = Auth::user();

        if (!$user->warga_id && !TenantPermissions::hasAnyRoleOrPermission($user, TenantPermissions::LAPORAN, ['create laporan', 'edit laporan'])) {
            abort(403, 'Akses ditolak.');
        }

        if (!$user->warga_id) {
            $this->addError('judul', 'Akun Anda belum dikaitkan dengan data Warga, sehingga tidak dapat membuat laporan.');
            return;
        }

        $this->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        $isPengurus = TenantPermissions::hasAnyRoleOrPermission($user, TenantPermissions::LAPORAN, ['create laporan', 'edit laporan']);

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
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.tenant.laporan.form');
    }
}
