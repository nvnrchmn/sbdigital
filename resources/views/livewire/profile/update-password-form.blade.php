<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section>
    <header>
        <h2 class="text-xl font-display font-bold text-slate-900">
            {{ __('Perbarui Kata Sandi') }}
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            {{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.') }}
        </p>
    </header>

    <form wire:submit="updatePassword" class="mt-6 space-y-6">
        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-slate-700 mb-1.5">{{ __('Kata Sandi Saat Ini') }}</label>
            <input wire:model="current_password" id="update_password_current_password" name="current_password" type="password" class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 sm:text-sm" autocomplete="current-password" />
            <x-input-error :messages="$errors->get('current_password')" class="mt-2 text-xs text-red-500" />
        </div>

        <div>
            <label for="update_password_password" class="block text-sm font-medium text-slate-700 mb-1.5">{{ __('Kata Sandi Baru') }}</label>
            <input wire:model="password" id="update_password_password" name="password" type="password" class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 sm:text-sm" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-500" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-slate-700 mb-1.5">{{ __('Konfirmasi Kata Sandi Baru') }}</label>
            <input wire:model="password_confirmation" id="update_password_password_confirmation" name="password_confirmation" type="password" class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 sm:text-sm" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs text-red-500" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="inline-flex justify-center items-center py-2.5 px-6 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-slate-800 hover:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 transition-colors">
                {{ __('Ubah Kata Sandi') }}
            </button>

            <x-action-message class="me-3 text-sm text-emerald-600 font-medium" on="password-updated">
                {{ __('Tersimpan.') }}
            </x-action-message>
        </div>
    </form>
</section>
