<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    
    // Warga fields
    public string $nik = '';
    public string $nomor_blok = '';
    public string $status_warga = 'Tetap';
    public string $no_hp = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $userConfig = $validated;
        
        if (tenant()) {
            $validatedTenant = $this->validate([
                'nik' => [
                    'required',
                    'string',
                    'max:16',
                    // FIX (c): kolom `nik` di database TERENKRIPSI (cast 'encrypted' di
                    // model Warga), jadi rule unique:warga,nik lama tidak pernah benar-benar
                    // mendeteksi NIK duplikat (ciphertext-nya selalu beda walau NIK sama).
                    // Cek yang benar harus lewat nik_hash (HMAC deterministik), sama seperti
                    // yang dipakai model Warga sendiri.
                    function ($attribute, $value, $fail) {
                        $hash = hash_hmac('sha256', $value, config('app.key'));

                        if (\App\Models\Warga::where('nik_hash', $hash)->exists()) {
                            $fail('NIK ini sudah terdaftar. Silakan hubungi pengurus jika ini adalah kesalahan.');
                        }
                    },
                ],
                'nomor_blok' => ['required', 'string', 'max:255'],
                'status_warga' => ['required', 'in:Tetap,Kontrak'],
                'no_hp' => ['nullable', 'string', 'max:20'],
            ]);
            
            $rumah = \App\Models\Rumah::firstOrCreate(['nomor_blok' => $validatedTenant['nomor_blok']]);
            
            $warga = \App\Models\Warga::create([
                'nik' => $validatedTenant['nik'],
                'nama_lengkap' => $validated['name'],
                'id_rumah' => $rumah->id,
                'no_hp' => $validatedTenant['no_hp'],
                'status_warga' => $validatedTenant['status_warga'],
                // FIX (a): warga hasil registrasi mandiri (bukan input manual pengurus)
                // wajib ditinjau dulu sebelum bisa dipakai untuk login ke dashboard.
                // Lihat App\Http\Middleware\EnsureWargaIsApproved.
                'status_persetujuan' => 'pending',
            ]);
            
            $userConfig['warga_id'] = $warga->id;
        }

        $user = User::create($userConfig);

        if (tenant()) {
            $user->assignRole('Warga');
        }

        event(new Registered($user));

        Auth::login($user);

        if (tenant()) {
            $this->redirect(route('tenant.dashboard', absolute: false), navigate: true);
        } else {
            $this->redirect(route('dashboard', absolute: false), navigate: true);
        }
    }
}; ?>

<div>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-display font-bold text-slate-900">Buat Akun Baru</h2>
        <p class="text-sm text-slate-500 mt-2">Daftar untuk mulai mengelola data di SB Digital.</p>
    </div>

    <form wire:submit="register" class="space-y-5">
        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <input wire:model="name" id="name" type="text" required autofocus autocomplete="name" class="block w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl bg-white focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 sm:text-sm" placeholder="Masukkan nama Anda" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs text-red-500" />
        </div>

        @if(tenant())
        <!-- Warga Specific Fields -->
        <div class="pt-4 pb-2 border-t border-slate-100">
            <h3 class="text-sm font-semibold text-slate-900 mb-4">Informasi Warga</h3>
            
            <div class="space-y-5">
                <div>
                    <label for="nik" class="block text-sm font-medium text-slate-700 mb-1.5">NIK <span class="text-red-500">*</span></label>
                    <input wire:model="nik" id="nik" type="text" required class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 sm:text-sm" placeholder="Nomor Induk Kependudukan" />
                    <x-input-error :messages="$errors->get('nik')" class="mt-2 text-xs text-red-500" />
                </div>

                <div>
                    <label for="nomor_blok" class="block text-sm font-medium text-slate-700 mb-1.5">Nomor Blok / Rumah <span class="text-red-500">*</span></label>
                    <input wire:model="nomor_blok" id="nomor_blok" type="text" required class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 sm:text-sm" placeholder="Misal: Blok A1 No. 5" />
                    <x-input-error :messages="$errors->get('nomor_blok')" class="mt-2 text-xs text-red-500" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="status_warga" class="block text-sm font-medium text-slate-700 mb-1.5">Status <span class="text-red-500">*</span></label>
                        <select wire:model="status_warga" id="status_warga" class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 sm:text-sm">
                            <option value="Tetap">Tetap</option>
                            <option value="Kontrak">Kontrak</option>
                        </select>
                        <x-input-error :messages="$errors->get('status_warga')" class="mt-2 text-xs text-red-500" />
                    </div>

                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-slate-700 mb-1.5">No HP</label>
                        <input wire:model="no_hp" id="no_hp" type="text" class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 sm:text-sm" placeholder="0812..." />
                        <x-input-error :messages="$errors->get('no_hp')" class="mt-2 text-xs text-red-500" />
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Alamat Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                </div>
                <input wire:model="email" id="email" type="email" required autocomplete="username" class="block w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl bg-white focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 sm:text-sm" placeholder="nama@email.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-500" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
                <input wire:model="password" id="password" type="password" required autocomplete="new-password" class="block w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl bg-white focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 sm:text-sm" placeholder="Buat password (min. 8 karakter)" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-500" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1.5">Konfirmasi Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <input wire:model="password_confirmation" id="password_confirmation" type="password" required autocomplete="new-password" class="block w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl bg-white focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 sm:text-sm" placeholder="Ulangi password di atas" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs text-red-500" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                <span wire:loading.remove>Daftar Sekarang</span>
                <span wire:loading class="flex items-center gap-2">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Mendaftar...
                </span>
            </button>
        </div>

        <div class="text-center text-sm text-slate-500 mt-6">
            Sudah punya akun? 
            <a href="{{ tenant() ? route('tenant.login') : route('login') }}" wire:navigate class="font-semibold text-indigo-600 hover:text-indigo-500 transition-colors">Masuk di sini</a>
        </div>
    </form>
</div>
