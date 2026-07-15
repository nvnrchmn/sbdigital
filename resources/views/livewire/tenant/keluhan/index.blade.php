<div>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-display font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-600 tracking-tight">Lapor RT</h2>
            <p class="text-slate-500 text-sm mt-1">Sistem pelaporan dan keluhan warga terpadu.</p>
        </div>
        @if(Auth::user()->warga_id || Auth::user()->can('create keluhan') || Auth::user()->hasRole('Tenant Owner'))
        <x-primary-button wire:click="$dispatch('openModal', { component: 'tenant.keluhan.form' })">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Buat Laporan Baru
        </x-primary-button>
        @endif
    </div>

    <div class="flex flex-col lg:flex-row space-y-4 lg:space-y-0 lg:space-x-4 mb-8">
        <div class="relative w-full lg:max-w-md">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" /></svg>
            </div>
            <input wire:model.live="search" type="text" class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-lg leading-5 bg-white placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-brand-indigo-500/20 focus:border-brand-indigo-500 sm:text-sm transition-shadow" placeholder="Cari laporan, deskripsi, pelapor..." />
        </div>
        
        <div class="flex gap-4 w-full lg:w-auto">
            <div class="relative w-full lg:w-48">
                <select wire:model.live="filterKategori" class="block w-full pl-3 pr-10 py-2 border border-slate-300 rounded-lg leading-5 bg-white focus:outline-none focus:ring-4 focus:ring-brand-indigo-500/20 focus:border-brand-indigo-500 sm:text-sm appearance-none transition-shadow">
                    <option value="">Semua Kategori</option>
                    <option value="Fasilitas Umum">Fasilitas Umum</option>
                    <option value="Keamanan">Keamanan</option>
                    <option value="Kebersihan">Kebersihan</option>
                    <option value="Sosial">Sosial</option>
                    <option value="Lain-lain">Lain-lain</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>

            <div class="relative w-full lg:w-48">
                <select wire:model.live="filterStatus" class="block w-full pl-3 pr-10 py-2 border border-slate-300 rounded-lg leading-5 bg-white focus:outline-none focus:ring-4 focus:ring-brand-indigo-500/20 focus:border-brand-indigo-500 sm:text-sm appearance-none transition-shadow">
                    <option value="">Semua Status</option>
                    <option value="Menunggu">Menunggu</option>
                    <option value="Diproses">Diproses</option>
                    <option value="Selesai">Selesai</option>
                    <option value="Ditolak">Ditolak</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        @forelse($keluhans as $keluhan)
        <x-card class="p-0 overflow-hidden group">
            <div class="flex flex-col md:flex-row">
                <!-- Bagian Kiri: Info Tiket -->
                <div class="flex-1 p-6 md:p-8 flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex gap-2">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                @if($keluhan->status === 'Menunggu') bg-slate-100 text-slate-700
                                @elseif($keluhan->status === 'Diproses') bg-sky-100 text-sky-700
                                @elseif($keluhan->status === 'Selesai') bg-emerald-100 text-emerald-700
                                @else bg-rose-100 text-rose-700
                                @endif">
                                @if($keluhan->status === 'Menunggu')
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @elseif($keluhan->status === 'Diproses')
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                @elseif($keluhan->status === 'Selesai')
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                @else
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                @endif
                                {{ $keluhan->status }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                {{ $keluhan->kategori }}
                            </span>
                        </div>
                        
                        <div class="flex gap-1.5">
                            @if($keluhan->status === 'Menunggu' && (Auth::user()->can('edit keluhan') || Auth::user()->hasRole('Tenant Owner') || Auth::user()->warga_id === $keluhan->warga_id))
                            <button wire:click="$dispatch('openModal', { component: 'tenant.keluhan.form', arguments: { keluhan: {{ $keluhan->id }} } })" class="h-8 w-8 rounded-full bg-slate-50 text-slate-600 hover:bg-brand-indigo-50 hover:text-brand-indigo-600 flex items-center justify-center transition-colors border border-slate-200" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                            </button>
                            @endif

                            @if($keluhan->status === 'Menunggu' && (Auth::user()->can('delete keluhan') || Auth::user()->hasRole('Tenant Owner') || Auth::user()->warga_id === $keluhan->warga_id))
                            <button wire:click="delete({{ $keluhan->id }})" wire:confirm="Hapus laporan ini?" class="h-8 w-8 rounded-full bg-slate-50 text-slate-600 hover:bg-rose-50 hover:text-rose-600 flex items-center justify-center transition-colors border border-slate-200" title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                            </button>
                            @endif
                        </div>
                    </div>

                    <h3 class="font-display font-bold text-xl text-slate-900 mb-2">{{ $keluhan->judul }}</h3>
                    <p class="text-slate-600 mb-6 text-sm leading-relaxed">{{ $keluhan->deskripsi }}</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-auto">
                        <div class="flex items-center text-sm text-slate-500">
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center mr-3 text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Pelapor</p>
                                <p class="font-medium text-slate-700">{{ $keluhan->warga->nama_lengkap ?? 'Anonim' }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center text-sm text-slate-500">
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center mr-3 text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Dilaporkan Pada</p>
                                <p class="font-medium text-slate-700">{{ $keluhan->created_at->diffForHumans() }}</p>
                            </div>
                        </div>

                        @if($keluhan->lokasi)
                        <div class="flex items-center text-sm text-slate-500 sm:col-span-2 mt-2">
                            <svg class="w-4 h-4 mr-2 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="truncate">{{ $keluhan->lokasi }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Bagian Kanan: Foto (Jika ada) -->
                @if($keluhan->foto)
                <div class="md:w-64 lg:w-80 h-48 md:h-auto border-l border-slate-100 shrink-0 bg-slate-50">
                    <img src="{{ Storage::url($keluhan->foto) }}" alt="Foto Laporan" class="w-full h-full object-cover">
                </div>
                @endif
            </div>

            <!-- Tanggapan RT & Aksi -->
            <div class="bg-slate-50 border-t border-slate-200 px-6 md:px-8 py-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex-1">
                    @if($keluhan->tanggapan_admin)
                        <div class="flex gap-3">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center shrink-0 text-indigo-600 mt-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-indigo-900 mb-0.5">Tanggapan Pengurus RT</p>
                                <p class="text-sm text-slate-700 italic">"{{ $keluhan->tanggapan_admin }}"</p>
                            </div>
                        </div>
                    @else
                        <p class="text-sm text-slate-400 italic">Belum ada tanggapan dari Pengurus RT.</p>
                    @endif
                </div>

                @if($isPengurus)
                <div class="shrink-0">
                    <button wire:click="$dispatch('openModal', { component: 'tenant.keluhan.process', arguments: { keluhan: {{ $keluhan->id }} } })" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition-colors shadow-sm">
                        Proses / Tanggapi
                    </button>
                </div>
                @endif
            </div>
        </x-card>
        @empty
        <div class="col-span-full py-16 text-center text-slate-500 bg-white/40 backdrop-blur-sm border border-slate-200/60 rounded-2xl border-dashed">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 text-slate-400 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <p class="text-sm font-medium text-slate-700 mb-1">Belum ada laporan keluhan.</p>
            <p class="text-xs text-slate-500">Lingkungan RT Anda saat ini aman dan terkendali.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $keluhans->links() }}
    </div>
</div>
