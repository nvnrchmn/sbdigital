<div>
    <div class="mb-8">
        <h2 class="text-3xl font-display font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-600 tracking-tight">
            {{ $announcement ? __('Edit Siaran Global') : __('Buat Siaran Baru') }}
        </h2>
    </div>

    <x-card class="max-w-4xl mx-auto p-0">
        <form wire:submit="save" class="p-6 md:p-8 space-y-6">
            
            <div class="border-b border-slate-100 pb-4 mb-6">
                <h3 class="font-display font-bold text-lg text-slate-800">Konten Siaran</h3>
                <p class="text-sm text-slate-500 mt-1">Siaran yang aktif akan muncul di dashboard seluruh tenant.</p>
            </div>

            <div class="grid grid-cols-1 gap-6">
                <!-- Judul -->
                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 mb-1.5">Judul Siaran</label>
                    <x-text-input wire:model="title" id="title" type="text" placeholder="Misal: Pemeliharaan Server Malam Ini" required />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <!-- Isi Konten -->
                <div>
                    <label for="content" class="block text-sm font-medium text-slate-700 mb-1.5">Isi Pengumuman</label>
                    <textarea wire:model="content" id="content" rows="6" class="flex w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm placeholder:text-slate-400 focus:outline-none focus:border-brand-indigo-500 focus:ring-4 focus:ring-brand-indigo-500/20 disabled:cursor-not-allowed disabled:opacity-50 transition-shadow" placeholder="Tuliskan pesan lengkap di sini..." required></textarea>
                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                </div>

                <!-- Status -->
                <div class="flex items-center mt-2">
                    <label class="relative flex items-center cursor-pointer">
                        <input wire:model="is_active" type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-brand-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-indigo-600"></div>
                        <span class="ml-3 text-sm font-medium text-slate-700">Tampilkan Siaran Ini (Aktif)</span>
                    </label>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex justify-end gap-3 mt-8">
                <x-secondary-button href="{{ route('superadmin.announcements.index') }}" wire:navigate>
                    Batal
                </x-secondary-button>
                <x-primary-button>
                    <span wire:loading.remove>Simpan & Siarkan</span>
                    <span wire:loading>Menyimpan...</span>
                </x-primary-button>
            </div>
        </form>
    </x-card>
</div>
