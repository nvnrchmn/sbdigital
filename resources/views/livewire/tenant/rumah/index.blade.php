<div>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h2
                class="text-3xl font-display font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-600 tracking-tight">
                Data Rumah</h2>
            <p class="text-slate-500 text-sm mt-1">Kelola data hunian dan kavling warga di tenant Anda.</p>
        </div>
        @if (auth()->user()->hasAnyRole(['Tenant Owner', 'Ketua RT', 'Wakil Ketua', 'Sekretaris']))
            <x-primary-button wire:click="$dispatch('openModal', { component: 'tenant.rumah.form' })">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14" />
                    <path d="M12 5v14" />
                </svg>
                Tambah Rumah
            </x-primary-button>
        @endif
    </div>

    <x-card class="p-0 overflow-hidden mb-6">
        <div class="p-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/30">
            <div class="relative w-full max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <input wire:model.live="search" type="text"
                    class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-lg leading-5 bg-white placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-brand-indigo-500/20 focus:border-brand-indigo-500 sm:text-sm transition-shadow duration-200"
                    placeholder="Cari nomor blok..." />
            </div>
        </div>

        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-sm text-left whitespace-nowrap">
                <thead
                    class="bg-slate-50/50 text-slate-500 border-b border-slate-100/60 text-xs uppercase font-semibold tracking-wider">
                    <tr>
                        <th class="px-6 py-4">No Blok</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/60">
                    @forelse($rumahs as $rumah)
                        <tr class="hover:bg-slate-50/50 transition-colors duration-200 group">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div
                                        class="h-10 w-10 flex-shrink-0 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center font-bold">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                            <polyline points="9 22 9 12 15 12 15 22" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-slate-900">{{ $rumah->nomor_blok }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="text-slate-500 line-clamp-1 max-w-md">{{ $rumah->keterangan ?: '-' }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div
                                    class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    @if (auth()->user()->hasAnyRole(['Tenant Owner', 'Ketua RT', 'Wakil Ketua', 'Sekretaris']))
                                        <button
                                            wire:click="$dispatch('openModal', { component: 'tenant.rumah.form', arguments: { rumah: {{ $rumah->id }} } })"
                                            class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-slate-400 hover:text-brand-indigo-600 hover:bg-brand-indigo-50 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                                            </svg>
                                        </button>
                                        @if (auth()->user()->hasRole('Tenant Owner'))
                                            <button wire:click="delete({{ $rumah->id }})"
                                                wire:confirm="Yakin ingin menghapus rumah ini? Semua data terkait akan ikut terhapus."
                                                class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M3 6h18" />
                                                    <path
                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                                    <line x1="10" y1="11" x2="10" y2="17" />
                                                    <line x1="14" y1="11" x2="14" y2="17" />
                                                </svg>
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center">
                                <div
                                    class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 text-slate-400 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                        <polyline points="9 22 9 12 15 12 15 22" />
                                    </svg>
                                </div>
                                <p class="text-slate-500 text-sm">Tidak ada data rumah yang ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card List View (Accordion) -->
        <div class="md:hidden divide-y divide-slate-100/60 bg-white">
            @forelse($rumahs as $rumah)
                <div x-data="{ expanded: false }" class="p-4 hover:bg-slate-50/50 transition-colors duration-200">
                    <!-- Card Header (Always Visible) -->
                    <div @click="expanded = !expanded" class="flex justify-between items-center cursor-pointer">
                        <div class="flex items-center">
                            <div
                                class="h-10 w-10 flex-shrink-0 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center font-bold">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                    <polyline points="9 22 9 12 15 12 15 22" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-semibold text-slate-900">Blok {{ $rumah->nomor_blok }}</div>
                                <div class="text-xs text-slate-500 mt-0.5 line-clamp-1">
                                    {{ $rumah->keterangan ?: 'Tidak ada keterangan' }}</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-slate-400 transition-transform duration-300"
                                :class="{ 'rotate-180': expanded }" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <!-- Card Body (Accordion Content) -->
                    <div x-show="expanded" style="display: none;" class="mt-4 pt-4 border-t border-slate-100">
                        <div class="mb-4">
                            <span class="block text-[10px] uppercase font-semibold text-slate-400 mb-1">Keterangan
                                Detail</span>
                            <span class="text-sm text-slate-800">{{ $rumah->keterangan ?: '-' }}</span>
                        </div>

                        <div class="flex justify-end gap-2">
                            @if (auth()->user()->hasAnyRole(['Tenant Owner', 'Ketua RT', 'Wakil Ketua', 'Sekretaris']))
                                <button
                                    wire:click="$dispatch('openModal', { component: 'tenant.rumah.form', arguments: { rumah: {{ $rumah->id }} } })"
                                    class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1.5 h-9 px-4 rounded-xl text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-100 transition-colors text-xs font-semibold">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                                    </svg>
                                    Edit
                                </button>
                            @endif
                            @if (auth()->user()->hasRole('Tenant Owner'))
                                <button wire:click="delete({{ $rumah->id }})"
                                    wire:confirm="Yakin ingin menghapus rumah ini?"
                                    class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1.5 h-9 px-4 rounded-xl text-red-700 bg-red-50 hover:bg-red-100 border border-red-100 transition-colors text-xs font-semibold">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 6h18" />
                                        <path
                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                        <line x1="10" y1="11" x2="10" y2="17" />
                                        <line x1="14" y1="11" x2="14" y2="17" />
                                    </svg>
                                    Hapus
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center">
                    <div
                        class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-slate-50 text-slate-400 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                            <polyline points="9 22 9 12 15 12 15 22" />
                        </svg>
                    </div>
                    <p class="text-slate-500 text-sm">Tidak ada data rumah ditemukan.</p>
                </div>
            @endforelse
        </div>

        <div class="p-4 border-t border-slate-100 bg-slate-50/30">
            {{ $rumahs->links() }}
        </div>
    </x-card>
</div>
