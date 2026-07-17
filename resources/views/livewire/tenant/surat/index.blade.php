<div>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-display font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-600 tracking-tight">Surat Pengantar RT/RW</h2>
            <p class="text-slate-500 text-sm mt-1">Layanan pembuatan surat pengantar secara mandiri dan cepat.</p>
        </div>
        @if(Auth::user()->warga_id || Auth::user()->can('create surat') || Auth::user()->hasRole('Tenant Owner'))
        <button wire:click="$dispatch('openModal', { component: 'tenant.surat.form' })" class="inline-flex items-center justify-center gap-2 rounded-xl font-sans font-semibold transition-all duration-300 disabled:opacity-50 bg-gradient-to-br from-indigo-500 to-purple-600 text-white hover:shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-0.5 h-11 px-6 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
            Ajukan Surat
        </button>
        @endif
    </div>

    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 mb-8">
        <div class="relative w-full max-w-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" /></svg>
            </div>
            <input wire:model.live="search" type="text" class="block w-full pl-10 pr-3 py-3 border border-slate-200/60 rounded-xl leading-5 bg-white/60 backdrop-blur-xl shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-shadow duration-200" placeholder="Cari nama, keperluan..." />
        </div>
        
        <div class="relative w-full sm:w-48">
            <select wire:model.live="filterStatus" class="block w-full pl-3 pr-10 py-3 border border-slate-200/60 rounded-xl leading-5 bg-white/60 backdrop-blur-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm appearance-none transition-shadow duration-200">
                <option value="">Semua Status</option>
                <option value="Menunggu">Menunggu</option>
                <option value="Disetujui">Disetujui</option>
                <option value="Ditolak">Ditolak</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($surats as $surat)
        <div class="bg-white/80 backdrop-blur-xl border border-white/60 shadow-sm hover:shadow-md transition-all duration-300 rounded-2xl overflow-hidden flex flex-col group relative p-6">
            <div class="flex justify-between items-start mb-4">
                <div class="flex-1">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                        @if($surat->status === 'Menunggu') bg-amber-100 text-amber-800
                        @elseif($surat->status === 'Disetujui') bg-emerald-100 text-emerald-800
                        @else bg-rose-100 text-rose-800
                        @endif">
                        {{ $surat->status }}
                    </span>
                    <h3 class="font-display font-bold text-lg text-slate-900 leading-tight mt-2">{{ $surat->jenis_surat }}</h3>
                </div>
                
                <!-- Opsi Pengeditan -->
                <div class="flex gap-1.5 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    @if($surat->status === 'Menunggu' && (Auth::user()->can('edit surat') || Auth::user()->hasRole('Tenant Owner') || Auth::user()->warga_id === $surat->warga_id))
                    <button wire:click="$dispatch('openModal', { component: 'tenant.surat.form', arguments: { surat: {{ $surat->id }} } })" class="h-8 w-8 rounded-full bg-slate-100 text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 flex items-center justify-center transition-colors" title="Edit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                    </button>
                    @endif

                    @if($surat->status === 'Menunggu' && (Auth::user()->can('delete surat') || Auth::user()->hasRole('Tenant Owner') || Auth::user()->warga_id === $surat->warga_id))
                    <button wire:click="delete({{ $surat->id }})" wire:confirm="Hapus pengajuan ini?" class="h-8 w-8 rounded-full bg-slate-100 text-slate-600 hover:bg-rose-50 hover:text-rose-600 flex items-center justify-center transition-colors" title="Hapus">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                    </button>
                    @endif
                </div>
            </div>

            <p class="text-sm text-slate-600 mb-4 line-clamp-2" title="{{ $surat->keperluan }}">{{ $surat->keperluan }}</p>

            <div class="space-y-2 mt-auto">
                <div class="flex items-center text-xs text-slate-500">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span class="font-medium text-slate-700">{{ $surat->warga->nama_lengkap ?? 'Anonim' }}</span>
                </div>
                <div class="flex items-center text-xs text-slate-500">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Diajukan {{ $surat->created_at->format('d M Y') }}
                </div>
                
                @if($surat->nomor_surat)
                <div class="flex items-center text-xs text-slate-500">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                    No: <strong class="ml-1 text-slate-700">{{ $surat->nomor_surat }}</strong>
                </div>
                @endif
            </div>

            @if($isPengurus || $surat->status === 'Disetujui' || $surat->status === 'Ditolak')
            <div class="pt-4 mt-4 border-t border-slate-100 flex gap-2">
                @if($isPengurus && $surat->status === 'Menunggu')
                <button wire:click="$dispatch('openModal', { component: 'tenant.surat.approve', arguments: { surat: {{ $surat->id }} } })" class="flex-1 px-3 py-2 text-xs font-semibold text-center text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors">
                    Proses
                </button>
                @endif

                @if($surat->status === 'Disetujui')
                <a href="{{ route('tenant.surat.cetak', $surat->id) }}" target="_blank" class="flex-1 inline-flex items-center justify-center px-3 py-2 text-xs font-semibold text-white bg-slate-800 hover:bg-slate-700 rounded-lg transition-colors shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1.5"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><path d="M6 14h12v8H6z"/></svg>
                    Cetak PDF
                </a>
                @endif

                @if($surat->status === 'Ditolak' && $surat->keterangan_admin)
                <div class="flex-1 w-full text-xs text-rose-600 bg-rose-50 p-2 rounded-lg italic">
                    "{{ $surat->keterangan_admin }}"
                </div>
                @endif
            </div>
            @endif
        </div>
        @empty
        <div class="col-span-full py-16 text-center text-slate-500 bg-white/40 backdrop-blur-sm border border-slate-200/60 rounded-2xl border-dashed">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 text-slate-400 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><line x1="10" x2="8" y1="9" y2="9"/></svg>
            </div>
            <p class="text-sm font-medium text-slate-700 mb-1">Belum ada pengajuan surat.</p>
            <p class="text-xs text-slate-500">Daftar permohonan surat pengantar akan muncul di sini.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $surats->links() }}
    </div>
</div>
