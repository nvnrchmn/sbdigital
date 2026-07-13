<div class="p-8">
    <div class="flex items-center gap-3 mb-6">
        <div class="h-10 w-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <div>
            <h2 class="text-xl font-display font-bold text-slate-900">{{ $warga ? 'Edit Data Warga' : 'Tambah Warga Baru' }}</h2>
            <p class="text-xs text-slate-500 mt-0.5">Lengkapi formulir pendataan warga di bawah ini.</p>
        </div>
    </div>

    <form wire:submit="save">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label for="nik" class="block text-sm font-medium text-slate-700 mb-1.5">NIK <span class="text-red-500">*</span></label>
                <input id="nik" wire:model="nik" type="text" class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 sm:text-sm" placeholder="Nomor Induk Kependudukan" />
                @error('nik') <span class="text-xs text-red-500 mt-1.5 block font-medium flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="nama_lengkap" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                <input id="nama_lengkap" wire:model="nama_lengkap" type="text" class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 sm:text-sm" placeholder="Nama sesuai KTP" />
                @error('nama_lengkap') <span class="text-xs text-red-500 mt-1.5 block font-medium flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="id_rumah" class="block text-sm font-medium text-slate-700 mb-1.5">Pilih Rumah</label>
                <select id="id_rumah" wire:model="id_rumah" class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 sm:text-sm">
                    <option value="">-- Pilih Rumah --</option>
                    @foreach($rumahs as $rumah)
                        <option value="{{ $rumah->id }}">{{ $rumah->nomor_blok }} - {{\Illuminate\Support\Str::limit($rumah->keterangan, 30)}}</option>
                    @endforeach
                </select>
                @error('id_rumah') <span class="text-xs text-red-500 mt-1.5 block font-medium flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="no_hp" class="block text-sm font-medium text-slate-700 mb-1.5">No. HP (Opsional)</label>
                <input id="no_hp" wire:model="no_hp" type="text" class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 sm:text-sm" placeholder="Contoh: 0812xxxxxx" />
                @error('no_hp') <span class="text-xs text-red-500 mt-1.5 block font-medium flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span> @enderror
            </div>

            <div class="md:col-span-2">
                <label for="status_warga" class="block text-sm font-medium text-slate-700 mb-1.5">Status Hunian <span class="text-red-500">*</span></label>
                <div class="relative">
                    <select id="status_warga" wire:model="status_warga" class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 sm:text-sm appearance-none">
                        <option value="Tetap">Warga Tetap</option>
                        <option value="Kontrak">Warga Kontrak / Kos</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                @error('status_warga') <span class="text-xs text-red-500 mt-1.5 block font-medium flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 mt-8 pt-5 border-t border-slate-100">
            <button type="button" wire:click="$dispatch('closeModal')" class="px-5 py-2.5 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-slate-900 transition-colors">
                Batal
            </button>
            <button type="submit" wire:loading.attr="disabled" class="px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl hover:shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-0.5 transition-all duration-300 disabled:opacity-70 flex items-center gap-2">
                <span wire:loading.remove>Simpan Data</span>
                <span wire:loading class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Menyimpan...
                </span>
            </button>
        </div>
    </form>
</div>
