<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        if (tenant()) {
            $this->redirectIntended(default: route('tenant.dashboard', absolute: false), navigate: true);
        } else {
            if (Auth::user()->hasRole('Super Admin')) {
                $this->redirectIntended(default: route('superadmin.dashboard', absolute: false), navigate: true);
            } else {
                $this->redirectIntended(default: route('profile', absolute: false), navigate: true);
            }
        }
    }
}; ?>

<div>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-display font-bold text-slate-900">Selamat Datang Kembali!</h2>
        <p class="text-sm text-slate-500 mt-2">Masuk untuk mengelola data warga Anda.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-5">
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Alamat Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                </div>
                <input wire:model="form.email" id="email" type="email" required autofocus autocomplete="username" class="block w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl bg-white focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 sm:text-sm" placeholder="nama@email.com" />
            </div>
            <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-xs text-red-500" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                @if (tenant() ? Route::has('tenant.password.request') : Route::has('password.request'))
                    <a class="text-xs font-semibold text-indigo-600 hover:text-indigo-500 transition-colors" href="{{ tenant() ? route('tenant.password.request') : route('password.request') }}" wire:navigate>
                        Lupa password?
                    </a>
                @endif
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
                <input wire:model="form.password" id="password" type="password" required autocomplete="current-password" class="block w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl bg-white focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 sm:text-sm" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-xs text-red-500" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input wire:model="form.remember" id="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300 rounded transition-colors">
            <label for="remember" class="ml-2 block text-sm text-slate-600">
                Ingat Saya
            </label>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                <span wire:loading.remove>Masuk ke Akun</span>
                <span wire:loading class="flex items-center gap-2">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Memproses...
                </span>
            </button>
        </div>
        
        <div class="text-center text-sm text-slate-500 mt-6">
            Belum punya akun? 
            <a href="{{ tenant() ? route('tenant.register') : route('register') }}" wire:navigate class="font-semibold text-indigo-600 hover:text-indigo-500 transition-colors">Daftar sekarang</a>
        </div>
    </form>
</div>
