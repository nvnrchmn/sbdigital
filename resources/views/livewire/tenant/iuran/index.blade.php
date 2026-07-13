<div>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-display font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-600 tracking-tight">Keuangan & Iuran</h2>
            <p class="text-slate-500 text-sm mt-1">Pencatatan kas dan manajemen tagihan iuran bulanan warga.</p>
        </div>
        @can('create iuran')
        <button wire:click="$dispatch('openModal', { component: 'tenant.iuran.form' })" class="inline-flex items-center justify-center gap-2 rounded-xl font-sans font-semibold transition-all duration-300 disabled:opacity-50 bg-gradient-to-br from-indigo-500 to-purple-600 text-white hover:shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-0.5 h-11 px-6 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
            Buat Tagihan / Catat Iuran
        </button>
        @endcan
    </div>

    <div class="bg-white/60 backdrop-blur-xl border border-white/40 shadow-sm rounded-2xl overflow-hidden mb-6">
        <div class="p-4 border-b border-slate-100/60 flex flex-col sm:flex-row items-center gap-4">
            <div class="relative w-full max-w-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" /></svg>
                </div>
                <input wire:model.live="search" type="text" class="block w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-xl leading-5 bg-white/50 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-shadow duration-200" placeholder="Cari nomor blok..." />
            </div>
            
            <div class="relative w-full sm:w-48">
                <select wire:model.live="filterStatus" class="block w-full pl-3 pr-10 py-2.5 border border-slate-200 rounded-xl leading-5 bg-white/50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm appearance-none transition-shadow duration-200">
                    <option value="">Semua Status</option>
                    <option value="Pending">Pending</option>
                    <option value="Lunas">Lunas</option>
                    <option value="Ditolak">Ditolak</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
        </div>

        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-sm text-left whitespace-nowrap">
                <thead class="bg-slate-50/50 text-slate-500 border-b border-slate-100/60 text-xs uppercase font-semibold tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Blok Rumah</th>
                        <th class="px-6 py-4">Periode</th>
                        <th class="px-6 py-4">Nominal</th>
                        <th class="px-6 py-4">Dibayar Oleh</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/60">
                    @forelse($iurans as $iuran)
                    <tr class="hover:bg-slate-50/50 transition-colors duration-200 group">
                        <td class="px-6 py-4 font-medium text-slate-900">
                            <span class="inline-flex items-center gap-1.5">
                                <svg class="text-slate-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                {{ $iuran->rumah->nomor_blok ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-700">
                            {{ \Carbon\Carbon::create()->month($iuran->bulan)->translatedFormat('F') }} {{ $iuran->tahun }}
                        </td>
                        <td class="px-6 py-4 font-mono font-medium text-slate-900">
                            Rp {{ number_format($iuran->nominal, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="h-6 w-6 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center text-xs font-bold">
                                    {{ $iuran->warga ? substr($iuran->warga->nama_lengkap, 0, 1) : '?' }}
                                </div>
                                <span class="text-slate-600">{{ $iuran->warga->nama_lengkap ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($iuran->status === 'Lunas')
                                <span class="inline-flex items-center rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-0.5 text-xs font-semibold shadow-sm"><span class="w-1.5 h-1.5 rounded-full mr-1.5 bg-emerald-500"></span>Lunas</span>
                            @elseif($iuran->status === 'Pending')
                                <span class="inline-flex items-center rounded-full bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-0.5 text-xs font-semibold shadow-sm"><span class="w-1.5 h-1.5 rounded-full mr-1.5 bg-amber-500 animate-pulse"></span>Pending</span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-rose-50 text-rose-700 border border-rose-200 px-2.5 py-0.5 text-xs font-semibold shadow-sm"><span class="w-1.5 h-1.5 rounded-full mr-1.5 bg-rose-500"></span>Ditolak</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                @can('approve iuran')
                                    @if($iuran->status === 'Pending')
                                        <button wire:click="approve({{ $iuran->id }})" wire:confirm="Konfirmasi pelunasan iuran ini?" class="inline-flex items-center justify-center h-8 px-3 rounded-lg text-emerald-600 hover:text-emerald-700 hover:bg-emerald-50 font-medium text-xs transition-colors border border-emerald-100 hover:border-emerald-200 shadow-sm">
                                            Approve
                                        </button>
                                    @endif
                                @endcan
                                @can('edit iuran')
                                    <button wire:click="$dispatch('openModal', { component: 'tenant.iuran.form', arguments: { iuran: {{ $iuran->id }} } })" class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                                    </button>
                                @endcan
                                @can('delete iuran')
                                    <button wire:click="delete({{ $iuran->id }})" wire:confirm="Yakin ingin menghapus data iuran ini?" class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                    </button>
                                @endcan
                                @cannot('approve iuran')
                                    @if($iuran->status === 'Pending')
                                        @if($iuran->checkout_url)
                                            <a href="{{ $iuran->checkout_url }}" target="_blank" class="inline-flex items-center justify-center h-8 px-3 rounded-lg text-indigo-600 hover:text-white hover:bg-indigo-600 font-medium text-xs transition-colors border border-indigo-200 hover:border-indigo-600 shadow-sm">
                                                Bayar
                                            </a>
                                        @else
                                            <span class="text-xs text-slate-400 italic mt-2">Menyiapkan pembayaran...</span>
                                        @endif
                                    @endif
                                @endcannot
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 text-slate-400 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                            </div>
                            <p class="text-slate-500 text-sm">Tidak ada data iuran yang ditemukan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card List View (Accordion) -->
        <div class="md:hidden divide-y divide-slate-100/60 bg-white">
            @forelse($iurans as $iuran)
            <div x-data="{ expanded: false }" class="p-4 hover:bg-slate-50/50 transition-colors duration-200">
                <!-- Card Header (Always Visible) -->
                <div @click="expanded = !expanded" class="flex justify-between items-center cursor-pointer">
                    <div class="flex items-center">
                        <div class="h-10 w-10 flex-shrink-0 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        </div>
                        <div class="ml-3">
                            <div class="text-sm font-semibold text-slate-900">Rp {{ number_format($iuran->nominal, 0, ',', '.') }}</div>
                            <div class="text-xs text-slate-500 mt-0.5 line-clamp-1">{{ \Carbon\Carbon::create()->month($iuran->bulan)->translatedFormat('F') }} {{ $iuran->tahun }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        @if($iuran->status === 'Lunas')
                            <span class="inline-flex items-center rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-0.5 text-[10px] font-semibold"><span class="w-1.5 h-1.5 rounded-full mr-1.5 bg-emerald-500"></span>Lunas</span>
                        @elseif($iuran->status === 'Pending')
                            <span class="inline-flex items-center rounded-full bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-0.5 text-[10px] font-semibold"><span class="w-1.5 h-1.5 rounded-full mr-1.5 bg-amber-500 animate-pulse"></span>Pending</span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-rose-50 text-rose-700 border border-rose-200 px-2.5 py-0.5 text-[10px] font-semibold"><span class="w-1.5 h-1.5 rounded-full mr-1.5 bg-rose-500"></span>Ditolak</span>
                        @endif
                        <svg class="w-5 h-5 text-slate-400 transition-transform duration-300" :class="{'rotate-180': expanded}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                
                <!-- Card Body (Accordion Content) -->
                <div x-show="expanded" style="display: none;" class="mt-4 pt-4 border-t border-slate-100">
                    <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                        <div class="bg-slate-50 p-3 rounded-lg border border-slate-100">
                            <span class="block text-[10px] uppercase font-semibold text-slate-400 mb-1">Blok Rumah</span>
                            <span class="text-slate-800 font-medium">{{ $iuran->rumah->nomor_blok ?? '-' }}</span>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-lg border border-slate-100">
                            <span class="block text-[10px] uppercase font-semibold text-slate-400 mb-1">Dibayar Oleh</span>
                            <span class="text-slate-800 font-medium">{{ $iuran->warga->nama_lengkap ?? '-' }}</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-end gap-2">
                        @can('approve iuran')
                            @if($iuran->status === 'Pending')
                                <button wire:click="approve({{ $iuran->id }})" wire:confirm="Konfirmasi pelunasan iuran ini?" class="flex-1 sm:flex-none inline-flex items-center justify-center h-9 px-4 rounded-xl text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-100 transition-colors text-xs font-semibold">
                                    Approve
                                </button>
                            @endif
                        @endcan
                        @can('edit iuran')
                            <button wire:click="$dispatch('openModal', { component: 'tenant.iuran.form', arguments: { iuran: {{ $iuran->id }} } })" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1.5 h-9 px-4 rounded-xl text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-100 transition-colors text-xs font-semibold">
                                Edit
                            </button>
                        @endcan
                        @can('delete iuran')
                            <button wire:click="delete({{ $iuran->id }})" wire:confirm="Yakin ingin menghapus data iuran ini?" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1.5 h-9 px-4 rounded-xl text-red-700 bg-red-50 hover:bg-red-100 border border-red-100 transition-colors text-xs font-semibold">
                                Hapus
                            </button>
                        @endcan
                        @cannot('approve iuran')
                            @if($iuran->status === 'Pending')
                                @if($iuran->checkout_url)
                                    <a href="{{ $iuran->checkout_url }}" target="_blank" class="flex-1 sm:flex-none inline-flex items-center justify-center h-9 px-4 rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 transition-colors text-xs font-semibold">
                                        Bayar
                                    </a>
                                @else
                                    <span class="text-xs text-slate-400 italic">Menyiapkan pembayaran...</span>
                                @endif
                            @endif
                        @endcannot
                    </div>
                </div>
            </div>
            @empty
            <div class="p-8 text-center">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-slate-50 text-slate-400 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                </div>
                <p class="text-slate-500 text-sm">Tidak ada data iuran ditemukan.</p>
            </div>
            @endforelse
        </div>
        
        <div class="p-4 border-t border-slate-100/60 bg-slate-50/30">
            {{ $iurans->links() }}
        </div>
    </div>
</div>
