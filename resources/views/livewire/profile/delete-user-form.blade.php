<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="space-y-6">
    <header>
        <h2 class="text-xl font-display font-bold text-slate-900">
            {{ __('Hapus Akun') }}
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            {{ __('Sekali akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Harap unduh data atau informasi yang ingin Anda simpan terlebih dahulu.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex justify-center items-center py-2.5 px-6 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 transition-colors"
    >{{ __('Hapus Akun') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="p-6">

            <h2 class="text-xl font-display font-bold text-slate-900">
                {{ __('Apakah Anda yakin ingin menghapus akun Anda?') }}
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                {{ __('Sekali akun dihapus, semua datanya akan musnah permanen. Masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda benar-benar ingin menghapus akun ini.') }}
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">{{ __('Kata Sandi') }}</label>

                <input wire:model="password" id="password" name="password" type="password" class="block w-full sm:w-3/4 px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 sm:text-sm" placeholder="{{ __('Kata Sandi') }}" />

                <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-500" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="inline-flex justify-center items-center py-2.5 px-6 border border-slate-300 rounded-xl shadow-sm text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-colors">
                    {{ __('Batal') }}
                </button>

                <button type="submit" class="inline-flex justify-center items-center py-2.5 px-6 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 transition-colors">
                    {{ __('Hapus Akun Saya') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
