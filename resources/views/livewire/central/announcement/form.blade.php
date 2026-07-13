<div>
    <x-slot name="header">
        <h2 class="font-display font-bold text-xl text-slate-800 leading-tight">
            {{ $announcement ? __('Edit Siaran Global') : __('Buat Siaran Baru') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <form wire:submit="save" class="p-6 md:p-8 space-y-6">
            
            <div class="border-b border-slate-200 pb-4 mb-6">
                <h3 class="font-display font-bold text-lg text-slate-800">Konten Siaran</h3>
                <p class="text-sm text-slate-500 mt-1">Siaran yang aktif akan muncul di dashboard seluruh tenant.</p>
            </div>

            <div class="grid grid-cols-1 gap-6">
                <!-- Judul -->
                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 mb-1.5">Judul Siaran</label>
                    <input wire:model="title" id="title" type="text" class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 sm:text-sm" placeholder="Misal: Pemeliharaan Server Malam Ini" required>
                    <x-input-error :messages="$errors->get('title')" class="mt-2 text-xs text-red-500" />
                </div>

                <!-- Isi Konten -->
                <div>
                    <label for="content" class="block text-sm font-medium text-slate-700 mb-1.5">Isi Pengumuman</label>
                    <textarea wire:model="content" id="content" rows="6" class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 sm:text-sm" placeholder="Tuliskan pesan lengkap di sini..." required></textarea>
                    <x-input-error :messages="$errors->get('content')" class="mt-2 text-xs text-red-500" />
                </div>

                <!-- Status -->
                <div class="flex items-center mt-2">
                    <label class="relative flex items-center cursor-pointer">
                        <input wire:model="is_active" type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        <span class="ml-3 text-sm font-medium text-slate-700">Tampilkan Siaran Ini (Aktif)</span>
                    </label>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-200 flex justify-end gap-3 mt-8">
                <a href="{{ route('superadmin.announcements.index') }}" wire:navigate class="inline-flex justify-center items-center py-2.5 px-6 border border-slate-300 rounded-xl shadow-sm text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-colors">
                    Batal
                </a>
                <button type="submit" class="inline-flex justify-center items-center py-2.5 px-6 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    <span wire:loading.remove>Simpan & Siarkan</span>
                    <span wire:loading>Menyimpan...</span>
                </button>
            </div>
        </form>
    </div>
</div>
