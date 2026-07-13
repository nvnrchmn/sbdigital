<div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden w-full max-w-lg mx-auto flex flex-col max-h-[90vh]">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center shrink-0">
        <div>
            <h3 class="font-display font-bold text-lg text-slate-800">
                Proses Keluhan
            </h3>
            <p class="text-xs text-slate-500 mt-0.5">Tinjau laporan dan berikan tanggapan resmi.</p>
        </div>
        <button wire:click="$dispatch('closeModal')" class="text-slate-400 hover:text-slate-600 transition-colors bg-white hover:bg-slate-100 p-1.5 rounded-lg border border-slate-200">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </div>

    <div class="p-6 overflow-y-auto">
        <div class="mb-6 bg-slate-50 border border-slate-100 rounded-xl p-4">
            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Detail Laporan</h4>
            <div class="grid grid-cols-3 gap-y-2 text-sm">
                <div class="text-slate-500">Judul</div>
                <div class="col-span-2 font-medium text-slate-800">{{ $keluhan->judul }}</div>
                
                <div class="text-slate-500">Kategori</div>
                <div class="col-span-2 font-medium text-slate-800">{{ $keluhan->kategori }}</div>
                
                <div class="text-slate-500">Pelapor</div>
                <div class="col-span-2 font-medium text-slate-800">{{ $keluhan->warga->nama_lengkap ?? 'Anonim' }}</div>
            </div>
        </div>

        <form wire:submit="save" class="space-y-5">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Ubah Status</label>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                    <label class="cursor-pointer">
                        <input type="radio" wire:model="status" value="Menunggu" class="peer sr-only">
                        <div class="rounded-xl border border-slate-200 bg-white p-2 text-center hover:bg-slate-50 peer-checked:border-slate-500 peer-checked:bg-slate-50 peer-checked:text-slate-700 transition-all text-xs font-medium">Menunggu</div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" wire:model="status" value="Diproses" class="peer sr-only">
                        <div class="rounded-xl border border-slate-200 bg-white p-2 text-center hover:bg-slate-50 peer-checked:border-sky-500 peer-checked:bg-sky-50 peer-checked:text-sky-700 transition-all text-xs font-medium">Diproses</div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" wire:model="status" value="Selesai" class="peer sr-only">
                        <div class="rounded-xl border border-slate-200 bg-white p-2 text-center hover:bg-slate-50 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-700 transition-all text-xs font-medium">Selesai</div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" wire:model="status" value="Ditolak" class="peer sr-only">
                        <div class="rounded-xl border border-slate-200 bg-white p-2 text-center hover:bg-slate-50 peer-checked:border-rose-500 peer-checked:bg-rose-50 peer-checked:text-rose-700 transition-all text-xs font-medium">Ditolak</div>
                    </label>
                </div>
                <x-input-error :messages="$errors->get('status')" class="mt-1" />
            </div>

            <div class="animate-in fade-in slide-in-from-top-2 duration-300">
                <label for="tanggapan_admin" class="block text-sm font-semibold text-slate-700 mb-1">Tanggapan Resmi</label>
                <textarea wire:model="tanggapan_admin" id="tanggapan_admin" rows="4" class="block w-full px-3 py-2.5 border border-slate-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-slate-50 focus:bg-white transition-colors" placeholder="Tuliskan tanggapan Anda sebagai Pengurus RT..."></textarea>
                <p class="text-xs text-slate-500 mt-1">Tanggapan ini akan terlihat oleh semua warga.</p>
                <x-input-error :messages="$errors->get('tanggapan_admin')" class="mt-1" />
            </div>

            <div class="flex justify-end gap-3 pt-6 mt-4 border-t border-slate-100">
                <button type="button" wire:click="$dispatch('closeModal')" class="px-5 py-2.5 border border-slate-200 rounded-xl shadow-sm text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    <span wire:loading.remove wire:target="save">Simpan Perubahan</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>
            </div>
        </form>
    </div>
</div>
