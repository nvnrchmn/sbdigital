<div>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-display font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-600 tracking-tight">E-Voting / Polling</h2>
            <p class="text-slate-500 text-sm mt-1">Sistem pemungutan suara digital untuk pengambilan keputusan warga.</p>
        </div>
        @if($isPengurus)
        <x-primary-button wire:click="$dispatch('openModal', { component: 'tenant.polling.form' })">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
            Buat Polling Baru
        </x-primary-button>
        @endif
    </div>

    <div class="flex flex-col lg:flex-row space-y-4 lg:space-y-0 lg:space-x-4 mb-8">
        <div class="relative w-full lg:max-w-md">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input wire:model.live="search" type="text" class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-lg leading-5 bg-white placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-brand-indigo-500/20 focus:border-brand-indigo-500 sm:text-sm transition-shadow duration-200" placeholder="Cari polling..." />
        </div>
        
        <div class="relative w-full lg:w-48">
            <select wire:model.live="filterStatus" class="block w-full pl-3 pr-10 py-2 border border-slate-300 rounded-lg leading-5 bg-white focus:outline-none focus:ring-4 focus:ring-brand-indigo-500/20 focus:border-brand-indigo-500 sm:text-sm appearance-none transition-shadow duration-200">
                <option value="">Semua Status</option>
                <option value="Aktif">Aktif</option>
                <option value="Selesai">Selesai</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($polls as $poll)
        @php
            $isClosed = $poll->status !== 'Aktif' || ($poll->tgl_selesai && $poll->tgl_selesai < now());
            $hasVoted = $votedPollIds->contains($poll->id);
        @endphp
        <x-card class="flex flex-col group p-0 overflow-hidden">
            <div class="p-6 flex-1 flex flex-col">
                <div class="flex justify-between items-start mb-4">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                        {{ $isClosed ? 'bg-slate-100 text-slate-700' : 'bg-emerald-100 text-emerald-700' }}">
                        @if($isClosed)
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Ditutup
                        @else
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Aktif
                        @endif
                    </span>
                    
                    @if($isPengurus)
                    <div class="flex gap-1.5">
                        <button wire:click="$dispatch('openModal', { component: 'tenant.polling.form', arguments: { poll: {{ $poll->id }} } })" class="h-8 w-8 rounded-full bg-slate-50 text-slate-600 hover:bg-brand-indigo-50 hover:text-brand-indigo-600 flex items-center justify-center transition-colors border border-slate-200">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                        </button>
                        <button wire:click="delete({{ $poll->id }})" wire:confirm="Hapus polling ini?" class="h-8 w-8 rounded-full bg-slate-50 text-slate-600 hover:bg-rose-50 hover:text-rose-600 flex items-center justify-center transition-colors border border-slate-200">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                        </button>
                    </div>
                    @endif
                </div>

                <h3 class="font-display font-bold text-lg text-slate-900 mb-2 line-clamp-2">{{ $poll->judul }}</h3>
                <p class="text-slate-500 text-sm mb-4 line-clamp-3">{{ $poll->deskripsi }}</p>

                <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        {{ $poll->votes_count }} Suara Masuk
                    </div>
                    @if($poll->tgl_selesai)
                    <div class="flex items-center text-rose-500 font-medium">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $poll->tgl_selesai->format('d M, H:i') }}
                    </div>
                    @endif
                </div>
            </div>

            <div class="p-4 bg-slate-50 border-t border-slate-100 mt-auto">
                <a href="{{ route('tenant.polling.show', $poll->id) }}" wire:navigate class="w-full flex justify-center items-center py-2.5 px-4 rounded-xl text-sm font-bold transition-all
                    @if($hasVoted || $isClosed) bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 hover:text-slate-900
                    @else bg-brand-indigo-600 text-white hover:bg-brand-indigo-700 hover:shadow-md
                    @endif">
                    @if($hasVoted)
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Lihat Hasil
                    @elseif($isClosed)
                        Lihat Hasil Akhir
                    @else
                        Berikan Suara
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    @endif
                </a>
            </div>
        </x-card>
        @empty
        <div class="col-span-full py-16 text-center text-slate-500 bg-white/40 backdrop-blur-sm border border-slate-200/60 rounded-2xl border-dashed">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 text-slate-400 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M15 2H9a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1z"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/></svg>
            </div>
            <p class="text-sm font-medium text-slate-700 mb-1">Belum ada kegiatan polling.</p>
            <p class="text-xs text-slate-500">Buat polling baru untuk menjaring aspirasi warga.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $polls->links() }}
    </div>
</div>
