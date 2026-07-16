<div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden w-full max-w-lg mx-auto flex flex-col max-h-[90vh]">
    <!-- Header -->
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center shrink-0">
        <div>
            <h3 class="font-display font-bold text-lg text-slate-800">
                {{ $surat ? 'Edit Permohonan' : 'Ajukan Surat Pengantar' }}
            </h3>
            <p class="text-xs text-slate-500 mt-0.5">Isi data permohonan surat dengan benar.</p>
        </div>
        <button wire:click="$dispatch('close-modal')" class="text-slate-400 hover:text-slate-600 transition-colors bg-white hover:bg-slate-100 p-1.5 rounded-lg border border-slate-200">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Body -->
    <div class="p-6 overflow-y-auto">
        <form wire:submit="save" class="space-y-5">
            <div>
                <label for="jenis_surat" class="block text-sm font-semibold text-slate-700 mb-1">Jenis Surat</label>
                <select wire:model="jenis_surat" id="jenis_surat" class="block w-full px-3 py-2.5 border border-slate-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-slate-50 focus:bg-white transition-colors" required>
                    <option value="Pengantar Pembuatan KTP">Pengantar Pembuatan KTP</option>
                    <option value="Pengantar Domisili">Pengantar Domisili</option>
                    <option value="Pengantar SKCK">Pengantar SKCK</option>
                    <option value="Pengantar Nikah">Pengantar Nikah</option>
                    <option value="Pengantar Akta Kelahiran">Pengantar Akta Kelahiran</option>
                    <option value="Pengantar Keterangan Usaha">Pengantar Keterangan Usaha</option>
                    <option value="Lain-lain">Lain-lain</option>
                </select>
                <x-input-error :messages="$errors->get('jenis_surat')" class="mt-1" />
            </div>

            <div>
                <label for="keperluan" class="block text-sm font-semibold text-slate-700 mb-1">Keperluan Lengkap</label>
                <textarea wire:model="keperluan" id="keperluan" rows="4" class="block w-full px-3 py-2.5 border border-slate-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-slate-50 focus:bg-white transition-colors" placeholder="Jelaskan secara singkat keperluan Anda, misal: Untuk persyaratan melamar pekerjaan di PT XYZ..." required></textarea>
                <x-input-error :messages="$errors->get('keperluan')" class="mt-1" />
            </div>

            <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-4 flex gap-3 text-sm text-indigo-800">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 text-indigo-500 mt-0.5"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                <p>Permohonan ini akan masuk ke antrean Ketua RT/Sekretaris. Data diri Anda (NIK, Nama, Tempat Tanggal Lahir) akan diambil otomatis dari profil Warga Anda saat surat dicetak.</p>
            </div>

            <div class="flex justify-end gap-3 pt-6 mt-4 border-t border-slate-100">
                <button type="button" wire:click="$dispatch('close-modal')" class="px-5 py-2.5 border border-slate-200 rounded-xl shadow-sm text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    <span wire:loading.remove wire:target="save">Simpan Permohonan</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>
            </div>
        </form>
    </div>
</div>
