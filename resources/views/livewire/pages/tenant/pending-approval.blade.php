<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect(route('tenant.login', absolute: false), navigate: true);
    }

    public function with(): array
    {
        $warga = Auth::user()->warga;

        return [
            'status' => $warga?->status_persetujuan ?? 'pending',
        ];
    }
}; ?>

<div class="text-center">
    @if ($status === 'ditolak')
        <div class="mx-auto flex items-center justify-center w-14 h-14 rounded-full bg-red-50 text-red-500 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10" />
                <line x1="15" y1="9" x2="9" y2="15" />
                <line x1="9" y1="9" x2="15" y2="15" />
            </svg>
        </div>
        <h2 class="text-lg font-semibold text-slate-900 mb-2">Pendaftaran Belum Disetujui</h2>
        <p class="text-sm text-slate-500 mb-6">
            Mohon maaf, pendaftaran Anda sebagai warga belum bisa disetujui oleh pengurus.
            Silakan hubungi pengurus RT/RW setempat untuk informasi lebih lanjut.
        </p>
    @else
        <div class="mx-auto flex items-center justify-center w-14 h-14 rounded-full bg-amber-50 text-amber-500 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10" />
                <polyline points="12 6 12 12 16 14" />
            </svg>
        </div>
        <h2 class="text-lg font-semibold text-slate-900 mb-2">Menunggu Persetujuan Pengurus</h2>
        <p class="text-sm text-slate-500 mb-6">
            Terima kasih sudah mendaftar. Data Anda sedang ditinjau oleh pengurus RT/RW.
            Anda akan bisa mengakses aplikasi setelah pendaftaran disetujui.
        </p>
    @endif

    <button wire:click="logout" type="submit"
        class="text-sm text-slate-500 underline hover:text-slate-800 transition-colors">
        Keluar
    </button>
</div>
