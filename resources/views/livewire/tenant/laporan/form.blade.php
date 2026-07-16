<div class="p-8">
    <div class="flex items-center gap-3 mb-6">
        <div class="h-10 w-10 bg-brand-indigo-50 text-brand-indigo-600 rounded-xl flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                <polyline points="14 2 14 8 20 8" />
                <line x1="16" x2="8" y1="13" y2="13" />
                <line x1="16" x2="8" y1="17" y2="17" />
                <line x1="10" x2="8" y1="9" y2="9" />
            </svg>
        </div>
        <div>
            <h2 class="text-xl font-display font-bold text-slate-900">
                {{ $laporan ? 'Edit Laporan' : 'Buat Laporan Baru' }}</h2>
            <p class="text-xs text-slate-500 mt-0.5">Sampaikan laporan, usulan, atau keluhan Anda.</p>
        </div>
    </div>

    <form wire:submit="save">
        <div class="space-y-5">
            <div>
                <label for="judul" class="block text-sm font-medium text-slate-700 mb-1.5">Judul Laporan / Keluhan
                    <span class="text-red-500">*</span></label>
                <x-text-input id="judul" wire:model="judul" type="text"
                    placeholder="Contoh: Lampu jalan mati di Blok A" />
                <x-input-error :messages="$errors->get('judul')" class="mt-2" />
            </div>

            <div>
                <label for="deskripsi" class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi Detail <span
                        class="text-red-500">*</span></label>
                <textarea id="deskripsi" wire:model="deskripsi" rows="5"
                    class="flex w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm placeholder:text-slate-400 focus:outline-none focus:border-brand-indigo-500 focus:ring-4 focus:ring-brand-indigo-500/20 disabled:cursor-not-allowed disabled:opacity-50 transition-shadow"
                    placeholder="Jelaskan detail kronologi, lokasi, dan laporan Anda secara lengkap..."></textarea>
                <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 mt-8 pt-5 border-t border-slate-100">
            <x-secondary-button wire:click="$dispatch('close-modal')">
                Batal
            </x-secondary-button>
            <x-primary-button wire:loading.attr="disabled">
                <span wire:loading.remove>Kirim Laporan</span>
                <span wire:loading class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Memproses...
                </span>
            </x-primary-button>
        </div>
    </form>
</div>
