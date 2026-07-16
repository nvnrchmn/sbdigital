<div class="p-8">
    <div class="flex items-center gap-3 mb-6">
        <div class="h-10 w-10 bg-brand-indigo-50 text-brand-indigo-600 rounded-xl flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect width="20" height="14" x="2" y="5" rx="2" />
                <line x1="2" x2="22" y1="10" y2="10" />
            </svg>
        </div>
        <div>
            <h2 class="text-xl font-display font-bold text-slate-900">
                {{ $iuran ? 'Edit Iuran' : 'Buat Tagihan Iuran Baru' }}</h2>
            <p class="text-xs text-slate-500 mt-0.5">Isi detail pembayaran atau tagihan dengan lengkap.</p>
        </div>
    </div>

    <form wire:submit="save">
        <div class="space-y-5">
            <div>
                <label for="id_rumah" class="block text-sm font-medium text-slate-700 mb-1.5">Rumah (Blok) <span
                        class="text-red-500">*</span></label>
                <div class="relative">
                    <select id="id_rumah" wire:model="id_rumah"
                        class="block w-full px-3 py-2 border border-slate-300 rounded-lg bg-white focus:ring-4 focus:ring-brand-indigo-500/20 focus:border-brand-indigo-500 transition-all duration-200 sm:text-sm appearance-none">
                        <option value="">-- Pilih Rumah --</option>
                        @foreach ($rumahs as $rumah)
                            <option value="{{ $rumah->id }}">{{ $rumah->nomor_blok }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('id_rumah')" class="mt-2" />
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label for="bulan" class="block text-sm font-medium text-slate-700 mb-1.5">Bulan <span
                            class="text-red-500">*</span></label>
                    <div class="relative">
                        <select id="bulan" wire:model="bulan"
                            class="block w-full px-3 py-2 border border-slate-300 rounded-lg bg-white focus:ring-4 focus:ring-brand-indigo-500/20 focus:border-brand-indigo-500 transition-all duration-200 sm:text-sm appearance-none">
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}">
                                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
                            @endfor
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('bulan')" class="mt-2" />
                </div>
                <div>
                    <label for="tahun" class="block text-sm font-medium text-slate-700 mb-1.5">Tahun <span
                            class="text-red-500">*</span></label>
                    <x-text-input id="tahun" wire:model="tahun" type="number" />
                    <x-input-error :messages="$errors->get('tahun')" class="mt-2" />
                </div>
            </div>

            <div>
                <label for="nominal" class="block text-sm font-medium text-slate-700 mb-1.5">Nominal (Rp) <span
                        class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <span class="text-slate-500 sm:text-sm">Rp</span>
                    </div>
                    <input id="nominal" wire:model="nominal" type="number"
                        class="block w-full pl-12 pr-4 py-2 border border-slate-300 rounded-lg bg-white focus:ring-4 focus:ring-brand-indigo-500/20 focus:border-brand-indigo-500 transition-all duration-200 sm:text-sm"
                        placeholder="50000" />
                </div>
                <x-input-error :messages="$errors->get('nominal')" class="mt-2" />
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-slate-700 mb-1.5">Status <span
                        class="text-red-500">*</span></label>
                <div class="relative">
                    <select id="status" wire:model="status"
                        class="block w-full px-3 py-2 border border-slate-300 rounded-lg bg-white focus:ring-4 focus:ring-brand-indigo-500/20 focus:border-brand-indigo-500 transition-all duration-200 sm:text-sm appearance-none">
                        <option value="Pending">Pending (Belum Dibayar)</option>
                        <option value="Lunas">Lunas</option>
                        <option value="Ditolak">Ditolak</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('status')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 mt-8 pt-5 border-t border-slate-100">
            <x-secondary-button wire:click="$dispatch('close-modal')">
                Batal
            </x-secondary-button>
            <x-primary-button>
                <span wire:loading.remove>Simpan Data</span>
                <span wire:loading class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Menyimpan...
                </span>
            </x-primary-button>
        </div>
    </form>
</div>
