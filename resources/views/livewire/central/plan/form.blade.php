<div>
    <div class="mb-8">
        <h2 class="text-3xl font-display font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-600 tracking-tight">
            {{ $plan ? __('Edit Paket') : __('Buat Paket Baru') }}
        </h2>
    </div>

    <x-card class="max-w-4xl mx-auto p-0">
        <form wire:submit="save" class="p-6 md:p-8 space-y-6">
            
            <div class="border-b border-slate-100 pb-4 mb-6">
                <h3 class="font-display font-bold text-lg text-slate-800">Informasi Paket</h3>
                <p class="text-sm text-slate-500 mt-1">Atur batasan kapasitas dan fitur untuk paket ini.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Paket -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Paket</label>
                    <x-text-input wire:model="name" id="name" type="text" placeholder="Misal: Basic, Premium" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi Singkat</label>
                    <textarea wire:model="description" id="description" rows="3" class="flex w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm placeholder:text-slate-400 focus:outline-none focus:border-brand-indigo-500 focus:ring-4 focus:ring-brand-indigo-500/20 disabled:cursor-not-allowed disabled:opacity-50 transition-shadow" placeholder="Jelaskan paket ini secara singkat..."></textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <!-- Max Houses -->
                <div class="md:col-span-2">
                    <label for="max_houses" class="block text-sm font-medium text-slate-700 mb-1.5">Batas Maksimal Rumah</label>
                    <x-text-input wire:model="max_houses" id="max_houses" type="number" min="1" class="md:w-1/2" placeholder="Misal: 50" required />
                    <p class="text-xs text-slate-500 mt-1.5">Perumahan tidak bisa menambahkan data rumah melebihi angka ini.</p>
                    <x-input-error :messages="$errors->get('max_houses')" class="mt-2" />
                </div>

                <!-- Harga -->
                <div class="md:col-span-1">
                    <label for="price" class="block text-sm font-medium text-slate-700 mb-1.5">Harga Paket (Rp)</label>
                    <x-text-input wire:model="price" id="price" type="number" min="0" placeholder="Misal: 100000" required />
                    <p class="text-xs text-slate-500 mt-1.5">Masukkan angka 0 jika ini adalah paket gratis.</p>
                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                </div>

                <!-- Siklus Tagihan -->
                <div class="md:col-span-1">
                    <label for="billing_cycle" class="block text-sm font-medium text-slate-700 mb-1.5">Siklus Tagihan</label>
                    <select wire:model="billing_cycle" id="billing_cycle" class="flex h-10 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:outline-none focus:border-brand-indigo-500 focus:ring-4 focus:ring-brand-indigo-500/20 transition-shadow" required>
                        <option value="monthly">Bulanan (Monthly)</option>
                        <option value="yearly">Tahunan (Yearly)</option>
                    </select>
                    <x-input-error :messages="$errors->get('billing_cycle')" class="mt-2" />
                </div>
            </div>

            <div class="border-b border-slate-100 pb-4 mb-6 mt-8">
                <h3 class="font-display font-bold text-lg text-slate-800">Akses Modul/Fitur</h3>
                <p class="text-sm text-slate-500 mt-1">Pilih fitur apa saja yang dapat diakses oleh Tenant yang berlangganan paket ini.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @php
                    $availableFeatures = [
                        'pengumuman' => 'Pengumuman / Siaran Warga',
                        'iuran' => 'Manajemen Iuran & Keuangan',
                        'laporan' => 'Laporan Kas Warga',
                        'warga' => 'Manajemen Data Warga Lengkap',
                        'lapak' => 'Lapak Warga (Marketplace Internal)',
                        'surat' => 'Surat Pengantar RT/RW',
                        'keluhan' => 'Lapor RT (Ticketing Keluhan)',
                        'polling' => 'E-Voting / Polling Warga',
                    ];
                @endphp

                @foreach($availableFeatures as $key => $label)
                    <label class="relative flex items-start p-4 cursor-pointer rounded-xl border border-slate-200 hover:bg-slate-50 transition-colors {{ in_array($key, $features) ? 'bg-brand-indigo-50/50 border-brand-indigo-200' : '' }}">
                        <div class="flex items-center h-5">
                            <input wire:model="features" type="checkbox" value="{{ $key }}" class="w-5 h-5 text-brand-indigo-600 bg-white border-slate-300 rounded focus:ring-brand-indigo-500 focus:ring-2">
                        </div>
                        <div class="ml-3 text-sm flex-1">
                            <span class="font-medium text-slate-900 block">{{ $label }}</span>
                        </div>
                    </label>
                @endforeach
            </div>

            <div class="pt-6 border-t border-slate-100 flex justify-end gap-3 mt-8">
                <x-secondary-button href="{{ route('superadmin.plans.index') }}" wire:navigate>
                    Batal
                </x-secondary-button>
                <x-primary-button>
                    <span wire:loading.remove>Simpan Paket</span>
                    <span wire:loading>Menyimpan...</span>
                </x-primary-button>
            </div>
        </form>
    </x-card>
</div>
