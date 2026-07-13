<div class="p-8">
    <div class="flex items-center gap-3 mb-6">
        <div class="h-10 w-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
        </div>
        <div>
            <h2 class="text-xl font-display font-bold text-slate-900">{{ $pengumumanId ? 'Edit Pengumuman' : 'Buat Pengumuman Baru' }}</h2>
            <p class="text-xs text-slate-500 mt-0.5">Sampaikan informasi penting kepada warga.</p>
        </div>
    </div>

    <form wire:submit="save">
        <div class="space-y-5">
            <div>
                <label for="judul" class="block text-sm font-medium text-slate-700 mb-1.5">Judul Pengumuman <span class="text-red-500">*</span></label>
                <input id="judul" wire:model="judul" type="text" class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 sm:text-sm" placeholder="Contoh: Kerja Bakti Rutin" />
                @error('judul') <span class="text-xs text-red-500 mt-1.5 block font-medium flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="isi" class="block text-sm font-medium text-slate-700 mb-1.5">Isi Pengumuman <span class="text-red-500">*</span></label>
                <textarea id="isi" wire:model="isi" rows="6" class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 sm:text-sm" placeholder="Tuliskan detail informasi yang ingin disampaikan..."></textarea>
                @error('isi') <span class="text-xs text-red-500 mt-1.5 block font-medium flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center mt-2">
                <input id="prioritas" wire:model="prioritas" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300 rounded" />
                <label for="prioritas" class="ml-2 block text-sm text-slate-700">
                    Tandai sebagai pengumuman Penting / Prioritas
                </label>
            </div>
            @error('prioritas') <span class="text-xs text-red-500 mt-1 block font-medium">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center justify-end gap-3 mt-8 pt-5 border-t border-slate-100">
            <button type="button" wire:click="$dispatch('closeModal')" class="px-5 py-2.5 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-slate-900 transition-colors">
                Batal
            </button>
            <button type="submit" wire:loading.attr="disabled" class="px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl hover:shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-0.5 transition-all duration-300 disabled:opacity-70 flex items-center gap-2">
                <span wire:loading.remove>Simpan & Bagikan</span>
                <span wire:loading class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Menyimpan...
                </span>
            </button>
        </div>
    </form>
</div>
