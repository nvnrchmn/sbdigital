<div class="p-8">
    <div class="flex items-center gap-3 mb-6">
        <div class="h-10 w-10 bg-brand-indigo-50 text-brand-indigo-600 rounded-xl flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                <polyline points="9 22 9 12 15 12 15 22" />
            </svg>
        </div>
        <div>
            <h2 class="text-xl font-display font-bold text-slate-900">
                {{ $rumah ? 'Edit Data Rumah' : 'Tambah Rumah Baru' }}</h2>
            <p class="text-xs text-slate-500 mt-0.5">Lengkapi formulir di bawah ini dengan benar.</p>
        </div>
    </div>

    <form wire:submit="save">
        <div class="space-y-5">
            <div>
                <label for="nomor_blok" class="block text-sm font-medium text-slate-700 mb-1.5">Nomor Blok / Rumah <span
                        class="text-red-500">*</span></label>
                <x-text-input id="nomor_blok" wire:model="nomor_blok" type="text"
                    placeholder="Contoh: Blok A1 No. 05" />
                <x-input-error :messages="$errors->get('nomor_blok')" class="mt-2" />
            </div>

            <div>
                <label for="keterangan" class="block text-sm font-medium text-slate-700 mb-1.5">Keterangan
                    (Opsional)</label>
                <textarea id="keterangan" wire:model="keterangan" rows="3"
                    class="flex w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm placeholder:text-slate-400 focus:outline-none focus:border-brand-indigo-500 focus:ring-4 focus:ring-brand-indigo-500/20 disabled:cursor-not-allowed disabled:opacity-50 transition-shadow"
                    placeholder="Keterangan tambahan (mis. disewakan, kosong, dll)"></textarea>
                <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 mt-8 pt-5 border-t border-slate-100">
            <x-secondary-button wire:click="$dispatch('close-modal')">
                Batal
            </x-secondary-button>
            <x-primary-button wire:loading.attr="disabled">
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
