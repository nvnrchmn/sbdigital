<div>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-display font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-600 tracking-tight">Lapak Warga</h2>
            <p class="text-slate-500 text-sm mt-1">Marketplace internal khusus untuk warga perumahan.</p>
        </div>
        @if(Auth::user()->warga_id || Auth::user()->can('create lapak') || Auth::user()->hasRole('Tenant Owner'))
        <x-primary-button wire:click="$dispatch('open-modal', { component: 'tenant.lapak.form' })">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
            Jual Barang/Jasa
        </x-primary-button>
        @endif
    </div>

    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 mb-8">
        <div class="relative w-full max-w-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" /></svg>
            </div>
            <input wire:model.live="search" type="text" class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-lg leading-5 bg-white placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-brand-indigo-500/20 focus:border-brand-indigo-500 sm:text-sm transition-shadow duration-200" placeholder="Cari nama produk..." />
        </div>
        
        <div class="relative w-full sm:w-48">
            <select wire:model.live="filterKategori" class="block w-full pl-3 pr-10 py-2 border border-slate-300 rounded-lg leading-5 bg-white focus:outline-none focus:ring-4 focus:ring-brand-indigo-500/20 focus:border-brand-indigo-500 sm:text-sm appearance-none transition-shadow duration-200">
                <option value="">Semua Kategori</option>
                <option value="Makanan & Minuman">Makanan & Minuman</option>
                <option value="Jasa">Jasa</option>
                <option value="Barang Bekas">Barang Bekas</option>
                <option value="Lainnya">Lainnya</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($produks as $produk)
        <x-card class="flex flex-col group relative">
            
            <!-- Foto Produk -->
            <div class="relative w-full h-48 bg-slate-100 overflow-hidden">
                @if($produk->foto)
                    <img src="{{ Storage::url($produk->foto) }}" alt="{{ $produk->nama_produk }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-300 bg-slate-50">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                        <span class="text-xs font-medium mt-2">Tanpa Foto</span>
                    </div>
                @endif

                <!-- Badge Kategori -->
                <div class="absolute top-3 left-3">
                    <span class="inline-flex items-center rounded-full bg-black/60 backdrop-blur-md text-white px-2.5 py-1 text-[10px] font-semibold tracking-wide border border-white/10 shadow-sm">
                        {{ $produk->kategori }}
                    </span>
                </div>
                
                <!-- Opsi Pengeditan -->
                @if(Auth::user()->can('edit lapak') || Auth::user()->hasRole('Tenant Owner') || Auth::user()->warga_id === $produk->warga_id)
                <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex gap-1.5">
                    <button wire:click="$dispatch('open-modal', { component: 'tenant.lapak.form', arguments: { produk: {{ $produk->id }} } })" class="h-7 w-7 rounded-full bg-white/90 backdrop-blur-sm text-indigo-600 hover:bg-white hover:text-indigo-800 flex items-center justify-center shadow-sm transition-colors" title="Edit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                    </button>
                    <button wire:click="delete({{ $produk->id }})" wire:confirm="Hapus produk ini?" class="h-7 w-7 rounded-full bg-white/90 backdrop-blur-sm text-rose-600 hover:bg-white hover:text-rose-800 flex items-center justify-center shadow-sm transition-colors" title="Hapus">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                    </button>
                </div>
                @endif
            </div>

            <div class="p-5 flex flex-col flex-grow">
                <h3 class="font-display font-bold text-lg text-slate-900 leading-tight mb-1 line-clamp-1" title="{{ $produk->nama_produk }}">{{ $produk->nama_produk }}</h3>
                <div class="text-xl font-extrabold text-indigo-600 mb-3">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>
                
                <p class="text-sm text-slate-500 line-clamp-2 mb-4 flex-grow">{{ $produk->deskripsi ?: 'Tidak ada deskripsi' }}</p>
                
                <div class="flex items-center gap-2 mb-4 text-xs font-medium text-slate-600 bg-slate-50 py-2 px-3 rounded-lg border border-slate-100">
                    <div class="h-6 w-6 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold flex-shrink-0">
                        {{ substr($produk->warga->nama_lengkap ?? 'A', 0, 1) }}
                    </div>
                    <span class="truncate">{{ $produk->warga->nama_lengkap ?? 'Anonim' }}</span>
                </div>

                @if($produk->warga && $produk->warga->no_hp)
                @php
                    // Pastikan nomor diawali dengan 62
                    $phone = preg_replace('/[^0-9]/', '', $produk->warga->no_hp);
                    if (str_starts_with($phone, '0')) {
                        $phone = '62' . substr($phone, 1);
                    }
                    $waText = urlencode("Halo, saya warga perumahan melihat produk *{$produk->nama_produk}* di Lapak Warga. Apakah masih tersedia?");
                @endphp
                <a href="https://wa.me/{{ $phone }}?text={{ $waText }}" target="_blank" class="mt-auto w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-[#25D366]/10 hover:bg-[#25D366]/20 text-[#128C7E] text-sm font-bold rounded-xl transition-colors border border-[#25D366]/20">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    Hubungi via WhatsApp
                </a>
                @else
                <button disabled class="mt-auto w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-100 text-slate-400 text-sm font-bold rounded-xl cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/><line x1="2" y1="2" x2="22" y2="22"/></svg>
                    Kontak Tidak Tersedia
                </button>
                @endif
            </div>
        </x-card>
        @empty
        <div class="col-span-full py-16 text-center text-slate-500 bg-white/40 backdrop-blur-sm border border-slate-200/60 rounded-2xl border-dashed">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 text-slate-400 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"/><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"/><path d="M2 7h20"/><path d="M22 7v3a2 2 0 0 1-2 2v0a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 16 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 12 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 8 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 4 12v0a2 2 0 0 1-2-2V7"/></svg>
            </div>
            <p class="text-sm font-medium text-slate-700 mb-1">Belum ada barang di Lapak.</p>
            <p class="text-xs text-slate-500">Jadilah yang pertama menawarkan barang atau jasa Anda!</p>
        </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $produks->links() }}
    </div>
</div>
