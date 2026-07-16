<div>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-display font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-600 tracking-tight">Pengumuman</h2>
            <p class="text-slate-500 text-sm mt-1">Papan informasi terpadu warga perumahan.</p>
        </div>
        @can('create pengumuman')
        <x-primary-button wire:click="$dispatch('open-modal', { component: 'tenant.pengumuman.form' })">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Buat Pengumuman
        </x-primary-button>
        @endcan
    </div>

    <div class="mb-8 relative w-full max-w-lg">
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" /></svg>
        </div>
        <input wire:model.live="search" type="text" class="block w-full pl-11 pr-4 py-2 border border-slate-300 rounded-lg leading-5 bg-white placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-brand-indigo-500/20 focus:border-brand-indigo-500 sm:text-sm transition-shadow duration-200" placeholder="Cari judul atau isi pengumuman..." />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($pengumumans as $pengumuman)
        <x-card class="flex flex-col relative group p-6">
            <div class="flex justify-between items-start mb-4">
                <h3 class="font-display font-bold text-lg leading-tight text-slate-900 pr-2 line-clamp-2">{{ $pengumuman->judul }}</h3>
                @if($pengumuman->prioritas)
                    <span class="inline-flex shrink-0 items-center rounded-full bg-rose-50 text-rose-700 border border-rose-200 px-2.5 py-0.5 text-[10px] font-bold tracking-wider uppercase">
                        <svg class="w-3 h-3 mr-1 text-rose-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        Penting
                    </span>
                @endif
            </div>
            
            <p class="text-sm text-slate-600 mb-6 flex-grow leading-relaxed whitespace-pre-line">{{ $pengumuman->isi }}</p>
            
            <div class="flex items-center justify-between text-xs text-slate-500 mt-auto pt-4 border-t border-slate-100">
                <div class="flex items-center gap-2">
                    <span class="font-medium text-slate-700">{{ $pengumuman->admin->name ?? 'Admin' }}</span>
                    <span class="text-slate-300">•</span>
                    <span>{{ $pengumuman->created_at->diffForHumans() }}</span>
                </div>
                
                <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    @can('edit pengumuman')
                    <button wire:click="$dispatch('open-modal', { component: 'tenant.pengumuman.form', arguments: { pengumuman: {{ $pengumuman->id }} } })" class="text-brand-indigo-600 hover:text-brand-indigo-800 transition-colors p-1" title="Edit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                    </button>
                    @endcan
                    @can('delete pengumuman')
                    <button wire:click="delete({{ $pengumuman->id }})" wire:confirm="Hapus pengumuman ini?" class="text-slate-400 hover:text-rose-600 transition-colors p-1" title="Hapus">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                    </button>
                    @endcan
                </div>
            </div>
        </x-card>
        @empty
        <div class="col-span-full py-16 text-center text-slate-500 bg-white/40 backdrop-blur-sm border border-slate-200/60 rounded-2xl border-dashed">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 text-slate-400 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 17v1c0 .5-.5 1-1 1H3c-.5 0-1-.5-1-1v-1"/><path d="M4 14V4c0-.5.5-1 1-1h14c.5 0 1 .5 1 1v10"/><path d="M12 9v4"/><path d="M12 9h4"/></svg>
            </div>
            <p class="text-sm">Tidak ada pengumuman yang ditemukan.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $pengumumans->links() }}
    </div>
</div>
