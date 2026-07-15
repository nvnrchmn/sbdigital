<div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden w-full max-w-lg mx-auto flex flex-col max-h-[90vh]">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center shrink-0">
        <div>
            <h3 class="font-display font-bold text-lg text-slate-800">
                {{ $keluhan ? 'Edit Laporan' : 'Buat Laporan Baru' }}
            </h3>
            <p class="text-xs text-slate-500 mt-0.5">Sampaikan keluhan atau masalah di lingkungan.</p>
        </div>
        <button wire:click="$dispatch('closeModal')" class="text-slate-400 hover:text-slate-600 transition-colors bg-white hover:bg-slate-100 p-1.5 rounded-lg border border-slate-200">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </div>

    <div class="p-6 overflow-y-auto">
        <form wire:submit="save" class="space-y-5">
            <div>
                <label for="judul" class="block text-sm font-semibold text-slate-700 mb-1">Judul Laporan</label>
                <x-text-input wire:model="judul" id="judul" type="text" placeholder="Cth: Lampu Taman Utama Mati" required />
                <x-input-error :messages="$errors->get('judul')" class="mt-1" />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="kategori" class="block text-sm font-semibold text-slate-700 mb-1">Kategori</label>
                    <select wire:model="kategori" id="kategori" class="block w-full px-3 py-2 border border-slate-300 rounded-lg bg-white focus:ring-4 focus:ring-brand-indigo-500/20 focus:border-brand-indigo-500 transition-all duration-200 sm:text-sm" required>
                        <option value="Fasilitas Umum">Fasilitas Umum</option>
                        <option value="Keamanan">Keamanan</option>
                        <option value="Kebersihan">Kebersihan</option>
                        <option value="Sosial">Sosial</option>
                        <option value="Lain-lain">Lain-lain</option>
                    </select>
                    <x-input-error :messages="$errors->get('kategori')" class="mt-1" />
                </div>
                <div>
                    <label for="lokasi" class="block text-sm font-semibold text-slate-700 mb-1">Lokasi Kejadian <span class="text-slate-400 font-normal">(Opsional)</span></label>
                    <x-text-input wire:model="lokasi" id="lokasi" type="text" placeholder="Cth: Depan Blok C2" />
                    <x-input-error :messages="$errors->get('lokasi')" class="mt-1" />
                </div>
            </div>

            <div>
                <label for="deskripsi" class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi Keluhan</label>
                <textarea wire:model="deskripsi" id="deskripsi" rows="4" class="flex w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm placeholder:text-slate-400 focus:outline-none focus:border-brand-indigo-500 focus:ring-4 focus:ring-brand-indigo-500/20 disabled:cursor-not-allowed disabled:opacity-50 transition-shadow" placeholder="Jelaskan secara rinci masalah yang terjadi..." required></textarea>
                <x-input-error :messages="$errors->get('deskripsi')" class="mt-1" />
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Foto Bukti <span class="text-slate-400 font-normal">(Opsional)</span></label>
                
                @if ($foto)
                    <div class="mb-3 relative rounded-xl overflow-hidden border border-slate-200">
                        <img src="{{ $foto->temporaryUrl() }}" class="w-full h-48 object-cover">
                        <button type="button" wire:click="$set('foto', null)" class="absolute top-2 right-2 bg-rose-500 text-white rounded-full p-1 shadow-md hover:bg-rose-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                @elseif($existingFoto)
                    <div class="mb-3 relative rounded-xl overflow-hidden border border-slate-200">
                        <img src="{{ Storage::url($existingFoto) }}" class="w-full h-48 object-cover">
                    </div>
                @endif

                <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-24 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-6 h-6 mb-2 text-slate-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/></svg>
                            <p class="mb-1 text-xs text-slate-500"><span class="font-semibold">Klik untuk unggah</span> foto dari perangkat</p>
                        </div>
                        <input id="dropzone-file" type="file" wire:model="foto" class="hidden" accept="image/*" />
                    </label>
                </div>
                <div wire:loading wire:target="foto" class="text-xs text-brand-indigo-600 mt-2 font-medium">Mengunggah foto...</div>
                <x-input-error :messages="$errors->get('foto')" class="mt-1" />
            </div>

            <div class="flex justify-end gap-3 pt-6 mt-4 border-t border-slate-100">
                <x-secondary-button wire:click="$dispatch('closeModal')">
                    Batal
                </x-secondary-button>
                <x-primary-button wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="save">Kirim Laporan</span>
                    <span wire:loading wire:target="save">Mengirim...</span>
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
