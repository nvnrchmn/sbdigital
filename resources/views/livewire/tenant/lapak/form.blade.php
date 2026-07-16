<div
    class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden w-full max-w-lg mx-auto flex flex-col max-h-[90vh]">
    <!-- Header -->
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center shrink-0">
        <div>
            <h3 class="font-display font-bold text-lg text-slate-800">
                {{ $produk ? 'Edit Produk' : 'Tambah Produk Lapak' }}
            </h3>
            <p class="text-xs text-slate-500 mt-0.5">Isi informasi barang atau jasa yang ingin ditawarkan.</p>
        </div>
        <button wire:click="$dispatch('close-modal')"
            class="text-slate-400 hover:text-slate-600 transition-colors bg-white hover:bg-slate-100 p-1.5 rounded-lg border border-slate-200">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Body -->
    <div class="p-6 overflow-y-auto">
        <form wire:submit="save" class="space-y-5">
            <div>
                <label for="nama_produk" class="block text-sm font-semibold text-slate-700 mb-1">Nama Produk /
                    Jasa</label>
                <x-text-input wire:model="nama_produk" id="nama_produk" type="text"
                    placeholder="Misal: Kue Nastar Kering, Jasa Servis AC" required />
                <x-input-error :messages="$errors->get('nama_produk')" class="mt-1" />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="kategori" class="block text-sm font-semibold text-slate-700 mb-1">Kategori</label>
                    <select wire:model="kategori" id="kategori"
                        class="block w-full px-3 py-2 border border-slate-300 rounded-lg bg-white focus:ring-4 focus:ring-brand-indigo-500/20 focus:border-brand-indigo-500 transition-all duration-200 sm:text-sm"
                        required>
                        <option value="Makanan & Minuman">Makanan & Minuman</option>
                        <option value="Jasa">Jasa</option>
                        <option value="Barang Bekas">Barang Bekas</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                    <x-input-error :messages="$errors->get('kategori')" class="mt-1" />
                </div>
                <div>
                    <label for="harga" class="block text-sm font-semibold text-slate-700 mb-1">Harga (Rp)</label>
                    <x-text-input wire:model="harga" id="harga" type="number" min="0"
                        placeholder="Misal: 50000" required />
                    <x-input-error :messages="$errors->get('harga')" class="mt-1" />
                </div>
            </div>

            <div>
                <label for="deskripsi" class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi</label>
                <textarea wire:model="deskripsi" id="deskripsi" rows="3"
                    class="flex w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm placeholder:text-slate-400 focus:outline-none focus:border-brand-indigo-500 focus:ring-4 focus:ring-brand-indigo-500/20 disabled:cursor-not-allowed disabled:opacity-50 transition-shadow"
                    placeholder="Jelaskan kondisi barang atau rincian jasa yang ditawarkan..."></textarea>
                <x-input-error :messages="$errors->get('deskripsi')" class="mt-1" />
            </div>

            <div>
                <label for="foto" class="block text-sm font-semibold text-slate-700 mb-1">Foto Produk
                    (Opsional)</label>

                @if ($foto)
                    <div class="mt-2 mb-4 relative rounded-xl overflow-hidden border border-slate-200">
                        <img src="{{ $foto->temporaryUrl() }}" class="w-full h-40 object-cover">
                        <button type="button" wire:click="$set('foto', null)"
                            class="absolute top-2 right-2 bg-red-600/80 backdrop-blur-sm text-white p-1 rounded-lg hover:bg-red-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                @elseif ($existingFoto)
                    <div class="mt-2 mb-4 rounded-xl overflow-hidden border border-slate-200 relative">
                        <img src="{{ Storage::url($existingFoto) }}" class="w-full h-40 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent flex items-end p-2">
                            <span class="text-xs text-white font-medium">Foto Saat Ini</span>
                        </div>
                    </div>
                @endif

                <input wire:model="foto" id="foto" type="file" accept="image/*"
                    class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-brand-indigo-50 file:text-brand-indigo-700 hover:file:bg-brand-indigo-100 transition-colors cursor-pointer border border-slate-200 rounded-xl p-2 bg-slate-50">
                <p class="text-xs text-slate-500 mt-1.5">Format: JPG, PNG. Maksimal 2MB.</p>
                <x-input-error :messages="$errors->get('foto')" class="mt-1" />

                <div wire:loading wire:target="foto"
                    class="text-xs text-brand-indigo-600 mt-2 font-medium flex items-center gap-1.5">
                    <svg class="animate-spin h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Mengunggah...
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-6 mt-4 border-t border-slate-100">
                <x-secondary-button wire:click="$dispatch('close-modal')">
                    Batal
                </x-secondary-button>
                <x-primary-button wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="save, foto">Simpan</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                    <span wire:loading wire:target="foto">Tunggu...</span>
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
