<div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden w-full max-w-lg mx-auto flex flex-col max-h-[90vh]">
    <!-- Header -->
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center shrink-0">
        <div>
            <h3 class="font-display font-bold text-lg text-slate-800">
                Proses Surat Warga
            </h3>
            <p class="text-xs text-slate-500 mt-0.5">Tinjau dan setujui permohonan surat ini.</p>
        </div>
        <button wire:click="$dispatch('closeModal')" class="text-slate-400 hover:text-slate-600 transition-colors bg-white hover:bg-slate-100 p-1.5 rounded-lg border border-slate-200">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Body -->
    <div class="p-6 overflow-y-auto">
        <div class="mb-6 bg-slate-50 border border-slate-100 rounded-xl p-4">
            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Detail Permohonan</h4>
            <div class="grid grid-cols-3 gap-y-2 text-sm">
                <div class="text-slate-500">Pemohon</div>
                <div class="col-span-2 font-medium text-slate-800">{{ $surat->warga->nama_lengkap ?? 'Anonim' }}</div>
                
                <div class="text-slate-500">Jenis Surat</div>
                <div class="col-span-2 font-medium text-slate-800">{{ $surat->jenis_surat }}</div>
                
                <div class="text-slate-500">Keperluan</div>
                <div class="col-span-2 font-medium text-slate-800">{{ $surat->keperluan }}</div>
                
                <div class="text-slate-500">Tanggal</div>
                <div class="col-span-2 font-medium text-slate-800">{{ $surat->created_at->format('d M Y H:i') }}</div>
            </div>
        </div>

        <form wire:submit="save" class="space-y-5">
            <div>
                <label for="status" class="block text-sm font-semibold text-slate-700 mb-1">Keputusan</label>
                <div class="grid grid-cols-3 gap-3">
                    <label class="cursor-pointer">
                        <input type="radio" wire:model.live="status" value="Menunggu" class="peer sr-only">
                        <div class="rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-center hover:bg-slate-50 peer-checked:border-amber-500 peer-checked:bg-amber-50 peer-checked:text-amber-700 transition-all text-sm font-medium">Menunggu</div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" wire:model.live="status" value="Disetujui" class="peer sr-only">
                        <div class="rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-center hover:bg-slate-50 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-700 transition-all text-sm font-medium">Disetujui</div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" wire:model.live="status" value="Ditolak" class="peer sr-only">
                        <div class="rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-center hover:bg-slate-50 peer-checked:border-rose-500 peer-checked:bg-rose-50 peer-checked:text-rose-700 transition-all text-sm font-medium">Ditolak</div>
                    </label>
                </div>
                <x-input-error :messages="$errors->get('status')" class="mt-1" />
            </div>

            @if($status === 'Disetujui')
            <div class="animate-in fade-in slide-in-from-top-2 duration-300">
                <label for="nomor_surat" class="block text-sm font-semibold text-slate-700 mb-1">Nomor Surat <span class="text-rose-500">*</span></label>
                <input wire:model="nomor_surat" id="nomor_surat" type="text" class="block w-full px-3 py-2.5 border border-slate-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-slate-50 focus:bg-white transition-colors" placeholder="Cth: 001/RT-01/VII/2026" required>
                <p class="text-xs text-slate-500 mt-1">Nomor surat ini akan tercetak pada dokumen PDF surat pengantar.</p>
                <x-input-error :messages="$errors->get('nomor_surat')" class="mt-1" />
            </div>
            @endif

            @if($status === 'Ditolak')
            <div class="animate-in fade-in slide-in-from-top-2 duration-300">
                <label for="keterangan_admin" class="block text-sm font-semibold text-slate-700 mb-1">Alasan Penolakan</label>
                <textarea wire:model="keterangan_admin" id="keterangan_admin" rows="3" class="block w-full px-3 py-2.5 border border-slate-300 rounded-xl focus:ring-rose-500 focus:border-rose-500 sm:text-sm bg-slate-50 focus:bg-white transition-colors" placeholder="Jelaskan mengapa permohonan ini ditolak (Opsional)"></textarea>
                <x-input-error :messages="$errors->get('keterangan_admin')" class="mt-1" />
            </div>
            @endif

            <div class="flex justify-end gap-3 pt-6 mt-4 border-t border-slate-100">
                <button type="button" wire:click="$dispatch('closeModal')" class="px-5 py-2.5 border border-slate-200 rounded-xl shadow-sm text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    <span wire:loading.remove wire:target="save">Simpan Keputusan</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>
            </div>
        </form>
    </div>
</div>
