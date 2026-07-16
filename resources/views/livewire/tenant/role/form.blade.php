<div class="p-8">
    <div class="flex items-center gap-3 mb-6">
        <div class="h-10 w-10 bg-brand-indigo-50 text-brand-indigo-600 rounded-xl flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
            </svg>
        </div>
        <div>
            <h2 class="text-xl font-display font-bold text-slate-900">Atur Role Pengguna</h2>
            <p class="text-xs text-slate-500 mt-0.5">Kelola hak akses dan wewenang pengguna (RBAC).</p>
        </div>
    </div>

    <form wire:submit="save">
        <div class="mb-6 p-4 bg-slate-50/50 rounded-xl border border-slate-100 flex items-center gap-4">
            <div
                class="h-12 w-12 bg-white rounded-full border border-slate-200 flex items-center justify-center text-slate-500 font-bold shadow-sm">
                {{ substr($name, 0, 1) }}
            </div>
            <div>
                <h3 class="text-sm font-semibold text-slate-900">{{ $name }}</h3>
                <p class="text-xs text-slate-500">{{ $email }}</p>
            </div>
        </div>

        <div class="space-y-4">
            <label class="block text-sm font-medium text-slate-700">Pilih Role / Hak Akses <span
                    class="text-red-500">*</span></label>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach ($availableRoles as $role)
                    <label
                        class="relative flex items-start p-4 cursor-pointer rounded-xl border {{ in_array($role->name, $selectedRoles) ? 'bg-brand-indigo-50/50 border-brand-indigo-200 shadow-sm' : 'bg-white border-slate-200 hover:bg-slate-50' }} transition-all duration-200 group">
                        <div class="flex items-center h-5">
                            <input type="checkbox" wire:model="selectedRoles" value="{{ $role->name }}"
                                class="h-4 w-4 text-brand-indigo-600 focus:ring-brand-indigo-500 border-slate-300 rounded transition-colors" />
                        </div>
                        <div class="ml-3 text-sm flex-1">
                            <span
                                class="font-semibold {{ in_array($role->name, $selectedRoles) ? 'text-brand-indigo-900' : 'text-slate-700' }} block">{{ $role->name }}</span>
                            <span class="text-xs text-slate-500 block mt-0.5">
                                @if ($role->name === 'Tenant Owner')
                                    Memiliki akses penuh ke seluruh sistem dan pengaturan tenant.
                                @elseif($role->name === 'Ketua RT')
                                    Dapat mengelola warga, keuangan, laporan, dan pengumuman.
                                @elseif($role->name === 'Sekretaris')
                                    Dapat mengelola data warga, administrasi, dan laporan.
                                @elseif($role->name === 'Bendahara')
                                    Dapat mengelola pencatatan keuangan dan iuran warga.
                                @else
                                    Hak akses standar sebagai warga perumahan.
                                @endif
                            </span>
                        </div>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 mt-8 pt-5 border-t border-slate-100">
            <x-secondary-button wire:click="$dispatch('close-modal')">
                Batal
            </x-secondary-button>
            <x-primary-button wire:loading.attr="disabled">
                <span wire:loading.remove>Simpan Perubahan</span>
                <span wire:loading class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Menyimpan...
                </span>
            </x-primary-button>
        </div>
    </form>
</div>
