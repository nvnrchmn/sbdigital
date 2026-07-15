<div>
    <div class="mb-8">
        <h2 class="text-3xl font-display font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-600 tracking-tight">
            {{ $tenant ? __('Edit Tenant') : __('Buat Tenant Baru') }}
        </h2>
    </div>

    <x-card class="max-w-4xl mx-auto p-0">
        <form wire:submit="save" class="p-6 md:p-8 space-y-6">
            
            <div class="border-b border-slate-100 pb-4 mb-6">
                <h3 class="font-display font-bold text-lg text-slate-800">Informasi Perumahan</h3>
                <p class="text-sm text-slate-500 mt-1">Data dasar untuk perumahan yang menggunakan sistem.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Perumahan -->
                <div>
                    <label for="nama_perumahan" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Perumahan/Tenant</label>
                    <x-text-input wire:model="nama_perumahan" id="nama_perumahan" type="text" placeholder="Contoh: Perumahan Indah" required />
                    <x-input-error :messages="$errors->get('nama_perumahan')" class="mt-2" />
                </div>

                <!-- ID / Path Tenant -->
                <div>
                    <label for="domain" class="block text-sm font-medium text-slate-700 mb-1.5">ID / Path Perumahan (URL)</label>
                    <div class="flex rounded-lg shadow-sm">
                        <span class="inline-flex items-center px-4 rounded-l-lg border border-r-0 border-slate-300 bg-slate-50 text-slate-500 sm:text-sm font-semibold">
                            {{ request()->getHost() }}:8000/
                        </span>
                        <input wire:model="domain" id="domain" type="text" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-lg border border-slate-300 bg-white focus:ring-4 focus:ring-brand-indigo-500/20 focus:border-brand-indigo-500 sm:text-sm" placeholder="perumahan-indah" {{ $tenant ? 'disabled' : 'required' }}>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">ID ini akan digunakan sebagai alamat akses (tanpa spasi). Tidak dapat diubah setelah dibuat.</p>
                    <x-input-error :messages="$errors->get('domain')" class="mt-2" />
                </div>
            </div>

            <div class="border-b border-slate-100 pb-4 mb-6 mt-8">
                <h3 class="font-display font-bold text-lg text-slate-800">Paket & Limitasi</h3>
                <p class="text-sm text-slate-500 mt-1">Pilih paket langganan untuk perumahan ini.</p>
            </div>

            <div class="grid grid-cols-1 gap-6">
                <!-- Paket Langganan -->
                <div>
                    <label for="plan_id" class="block text-sm font-medium text-slate-700 mb-1.5">Paket Langganan</label>
                    <select wire:model="plan_id" id="plan_id" class="block w-full px-3 py-2 border border-slate-300 rounded-lg bg-white focus:ring-4 focus:ring-brand-indigo-500/20 focus:border-brand-indigo-500 sm:text-sm" required>
                        <option value="">-- Pilih Paket --</option>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}">{{ $plan->name }} (Maks. {{ $plan->max_houses }} Rumah)</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('plan_id')" class="mt-2" />
                </div>
            </div>

            <div class="border-b border-slate-100 pb-4 mb-6 mt-8">
                <h3 class="font-display font-bold text-lg text-slate-800">Akun Administrator</h3>
                <p class="text-sm text-slate-500 mt-1">Informasi login untuk pengurus (ketua RT/RW) di perumahan ini.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Admin -->
                <div>
                    <label for="nama_admin" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Admin</label>
                    <x-text-input wire:model="nama_admin" id="nama_admin" type="text" placeholder="Budi Santoso" required />
                    <x-input-error :messages="$errors->get('nama_admin')" class="mt-2" />
                </div>

                <!-- Email Admin -->
                <div>
                    <label for="email_admin" class="block text-sm font-medium text-slate-700 mb-1.5">Email Admin</label>
                    <x-text-input wire:model="email_admin" id="email_admin" type="email" placeholder="budi@perumahan.com" required />
                    <x-input-error :messages="$errors->get('email_admin')" class="mt-2" />
                </div>

                <!-- Password Admin -->
                <div class="md:col-span-2">
                    <label for="password_admin" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Password Admin
                        @if($tenant)
                            <span class="text-slate-400 font-normal ml-2">(Kosongkan jika tidak ingin mengubah password)</span>
                        @endif
                    </label>
                    <x-text-input wire:model="password_admin" id="password_admin" type="password" placeholder="Minimal 8 karakter" {{ $tenant ? '' : 'required' }} />
                    <x-input-error :messages="$errors->get('password_admin')" class="mt-2" />
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                <x-secondary-button href="{{ route('superadmin.tenants.index') }}" wire:navigate>
                    Batal
                </x-secondary-button>
                <x-primary-button>
                    <span wire:loading.remove>Simpan Tenant</span>
                    <span wire:loading>Menyimpan...</span>
                </x-primary-button>
            </div>
        </form>
    </x-card>
</div>
