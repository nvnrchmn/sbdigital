<div>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-display font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-600 tracking-tight">Laporan & Keluhan</h2>
            <p class="text-slate-500 text-sm mt-1">Platform pelaporan terpadu untuk warga dan pengurus.</p>
        </div>
        @if(Auth::user()->warga_id || Auth::user()->can('create laporan') || Auth::user()->hasRole('Tenant Owner'))
        <x-primary-button wire:click="$dispatch('openModal', { component: 'tenant.laporan.form' })">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
            Buat Laporan Baru
        </x-primary-button>
        @endif
    </div>

    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 mb-6">
        <div class="relative w-full max-w-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" /></svg>
            </div>
            <input wire:model.live="search" type="text" class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-lg leading-5 bg-white placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-brand-indigo-500/20 focus:border-brand-indigo-500 sm:text-sm transition-shadow duration-200" placeholder="Cari laporan..." />
        </div>
        
        <div class="relative w-full sm:w-48">
            <select wire:model.live="filterStatus" class="block w-full pl-3 pr-10 py-2 border border-slate-300 rounded-lg leading-5 bg-white focus:outline-none focus:ring-4 focus:ring-brand-indigo-500/20 focus:border-brand-indigo-500 sm:text-sm appearance-none transition-shadow duration-200">
                <option value="">Semua Status</option>
                <option value="Menunggu">Menunggu</option>
                <option value="Diproses">Diproses</option>
                <option value="Selesai">Selesai</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($laporans as $laporan)
        <x-card class="flex flex-col relative group">
            <div class="flex justify-between items-start mb-4">
                <h3 class="font-display font-bold text-lg leading-tight text-slate-900 line-clamp-1 flex-1 pr-2" title="{{ $laporan->judul }}">{{ $laporan->judul }}</h3>
                @if($laporan->status === 'Menunggu')
                    <span class="inline-flex shrink-0 items-center rounded-full bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-0.5 text-[11px] font-semibold tracking-wide uppercase"><span class="w-1.5 h-1.5 rounded-full mr-1.5 bg-amber-500 animate-pulse"></span>Menunggu</span>
                @elseif($laporan->status === 'Diproses')
                    <span class="inline-flex shrink-0 items-center rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200 px-2.5 py-0.5 text-[11px] font-semibold tracking-wide uppercase"><span class="w-1.5 h-1.5 rounded-full mr-1.5 bg-indigo-500"></span>Diproses</span>
                @else
                    <span class="inline-flex shrink-0 items-center rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-0.5 text-[11px] font-semibold tracking-wide uppercase"><span class="w-1.5 h-1.5 rounded-full mr-1.5 bg-emerald-500"></span>Selesai</span>
                @endif
            </div>
            
            <p class="text-sm text-slate-600 mb-6 line-clamp-3 flex-grow leading-relaxed">{{ $laporan->deskripsi }}</p>
            
            <div class="flex items-center text-xs text-slate-500 mb-5 border-b border-slate-100/80 pb-4">
                <div class="flex items-center gap-2">
                    <div class="h-6 w-6 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center font-bold">
                        {{ $laporan->warga ? substr($laporan->warga->nama_lengkap, 0, 1) : 'A' }}
                    </div>
                    <span class="font-medium text-slate-700">{{ $laporan->warga->nama_lengkap ?? 'Anonim' }}</span>
                </div>
                <span class="mx-2 text-slate-300">•</span>
                <span>{{ $laporan->created_at->diffForHumans() }}</span>
                
                @if(!$laporan->is_published)
                    <span class="ml-auto text-amber-600 flex items-center bg-amber-50 px-2 py-0.5 rounded-md font-medium border border-amber-100">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                        Privat
                    </span>
                @endif
            </div>

            <div class="flex justify-between items-center gap-2">
                <div class="space-x-1 flex items-center relative">
                    @if($isPengurus)
                        @if(!$laporan->is_published)
                        <button wire:click="publish({{ $laporan->id }})" class="text-xs text-indigo-600 font-semibold hover:text-indigo-800 transition-colors mr-3 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            Rilis
                        </button>
                        @endif
                        
                        <div class="inline-block relative" x-data="{ open: false }">
                            <button @click="open = !open" class="text-xs font-medium text-slate-600 hover:text-slate-900 border border-slate-200 bg-slate-50 hover:bg-slate-100 transition-colors rounded-lg px-2.5 py-1.5 flex items-center gap-1">
                                Ubah Status <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute bottom-full left-0 mb-2 w-32 bg-white border border-slate-100 rounded-xl shadow-lg shadow-slate-200/50 z-20 overflow-hidden" style="display:none;" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                                <button wire:click="changeStatus({{ $laporan->id }}, 'Menunggu')" @click="open = false" class="block w-full text-left px-4 py-2 text-xs font-medium text-slate-600 hover:bg-slate-50 hover:text-amber-600 transition-colors">Menunggu</button>
                                <button wire:click="changeStatus({{ $laporan->id }}, 'Diproses')" @click="open = false" class="block w-full text-left px-4 py-2 text-xs font-medium text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-colors">Diproses</button>
                                <button wire:click="changeStatus({{ $laporan->id }}, 'Selesai')" @click="open = false" class="block w-full text-left px-4 py-2 text-xs font-medium text-slate-600 hover:bg-slate-50 hover:text-emerald-600 transition-colors">Selesai</button>
                            </div>
                        </div>
                    @endif
                </div>

                <div>
                    @if($isPengurus || Auth::user()->warga_id === $laporan->warga_id)
                    <button wire:click="delete({{ $laporan->id }})" wire:confirm="Hapus laporan ini?" class="text-xs font-medium text-slate-400 hover:text-red-600 transition-colors px-2 py-1.5 rounded-lg hover:bg-red-50">Hapus</button>
                    @endif
                </div>
            </div>
        </x-card>
        @empty
        <div class="col-span-full py-16 text-center text-slate-500 bg-white/40 backdrop-blur-sm border border-slate-200/60 rounded-2xl border-dashed">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 text-slate-400 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><line x1="10" x2="8" y1="9" y2="9"/></svg>
            </div>
            <p class="text-sm">Belum ada laporan atau keluhan warga.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $laporans->links() }}
    </div>
</div>
