<div
    class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden w-full max-w-lg mx-auto flex flex-col max-h-[90vh]">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center shrink-0">
        <div>
            <h3 class="font-display font-bold text-lg text-slate-800">
                {{ $poll ? 'Edit Polling' : 'Buat Polling Baru' }}
            </h3>
            <p class="text-xs text-slate-500 mt-0.5">Jaring aspirasi warga secara transparan.</p>
        </div>
        <button wire:click="$dispatch('close-modal')"
            class="text-slate-400 hover:text-slate-600 transition-colors bg-white hover:bg-slate-100 p-1.5 rounded-lg border border-slate-200">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div class="p-6 overflow-y-auto">
        <form wire:submit="save" class="space-y-5">
            <div>
                <label for="judul" class="block text-sm font-semibold text-slate-700 mb-1">Topik Polling</label>
                <x-text-input wire:model="judul" id="judul" type="text"
                    placeholder="Cth: Pemilihan Warna Cat Gapura Utama" required />
                <x-input-error :messages="$errors->get('judul')" class="mt-1" />
            </div>

            <div>
                <label for="deskripsi" class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi / Penjelasan
                    <span class="text-slate-400 font-normal">(Opsional)</span></label>
                <textarea wire:model="deskripsi" id="deskripsi" rows="3"
                    class="flex w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm placeholder:text-slate-400 focus:outline-none focus:border-brand-indigo-500 focus:ring-4 focus:ring-brand-indigo-500/20 disabled:cursor-not-allowed disabled:opacity-50 transition-shadow"
                    placeholder="Jelaskan detail dari polling ini..."></textarea>
                <x-input-error :messages="$errors->get('deskripsi')" class="mt-1" />
            </div>

            <div>
                <label for="tgl_selesai" class="block text-sm font-semibold text-slate-700 mb-1">Batas Waktu Polling
                    <span class="text-slate-400 font-normal">(Opsional)</span></label>
                <x-text-input wire:model="tgl_selesai" id="tgl_selesai" type="datetime-local" />
                <p class="text-xs text-slate-500 mt-1">Jika dikosongkan, polling harus ditutup manual oleh admin.</p>
                <x-input-error :messages="$errors->get('tgl_selesai')" class="mt-1" />
            </div>

            <div class="border-t border-slate-100 pt-5 mt-5">
                <div class="flex justify-between items-center mb-3">
                    <label class="block text-sm font-semibold text-slate-700">Opsi Pilihan</label>
                    <button type="button" wire:click="addOpsi"
                        class="text-xs font-semibold text-brand-indigo-600 hover:text-brand-indigo-700 bg-brand-indigo-50 hover:bg-brand-indigo-100 px-3 py-1.5 rounded-lg transition-colors flex items-center">
                        <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Tambah Opsi
                    </button>
                </div>

                <div class="space-y-3">
                    @foreach ($opsi as $index => $ops)
                        <div class="flex gap-2 items-start" wire:key="opsi-{{ $index }}">
                            <div class="flex-1">
                                <x-text-input wire:model="opsi.{{ $index }}" type="text"
                                    placeholder="Opsi {{ $index + 1 }}" required />
                                <x-input-error :messages="$errors->get('opsi.' . $index)" class="mt-1" />
                            </div>
                            @if (count($opsi) > 2)
                                <button type="button" wire:click="removeOpsi({{ $index }})"
                                    class="p-2.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-colors border border-transparent hover:border-rose-200"
                                    title="Hapus opsi ini">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>
                <x-input-error :messages="$errors->get('opsi')" class="mt-2" />
            </div>

            <div class="flex justify-end gap-3 pt-6 mt-4 border-t border-slate-100">
                <x-secondary-button wire:click="$dispatch('close-modal')">
                    Batal
                </x-secondary-button>
                <x-primary-button wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="save">Simpan Polling</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
