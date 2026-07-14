<div class="max-w-7xl mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Informasi Langganan</h2>
            <p class="text-slate-500 text-sm mt-1">Kelola dan pantau penggunaan paket berlangganan perumahan Anda.</p>
        </div>
    </div>

    @if($plan)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            
            <!-- Plan Info Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 lg:col-span-1">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-slate-800">Paket Saat Ini</h3>
                    <span class="px-3 py-1 bg-brand-indigo-100 text-brand-indigo-700 rounded-full text-xs font-bold uppercase tracking-wider">
                        Aktif
                    </span>
                </div>
                
                <div class="flex items-center gap-4 mb-6">
                    <div class="h-16 w-16 bg-gradient-to-br from-brand-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-brand-indigo-500/30">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                    <div>
                        <h4 class="text-2xl font-bold text-slate-900">{{ $plan->name }}</h4>
                        <p class="text-slate-500 text-sm">Paket Utama</p>
                    </div>
                </div>
                
                <p class="text-slate-600 text-sm mb-6 pb-6 border-b border-slate-100">
                    {{ $plan->description ?? 'Anda berlangganan paket ' . $plan->name . '. Nikmati berbagai fitur unggulan untuk manajemen perumahan.' }}
                </p>

                <div class="w-full bg-slate-50 text-slate-500 text-center font-medium py-2.5 rounded-xl text-sm border border-slate-200">
                    Rp {{ number_format($plan->price, 0, ',', '.') }} / {{ $plan->billing_cycle === 'monthly' ? 'Bulan' : 'Tahun' }}
                </div>
            </div>

            <!-- Features & Usage Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 lg:col-span-2">
                <h3 class="text-lg font-semibold text-slate-800 mb-6">Kapasitas & Penggunaan</h3>
                
                <!-- Rumah Usage -->
                <div class="mb-8">
                    <div class="flex justify-between items-end mb-2">
                        <div>
                            <span class="text-sm font-medium text-slate-700">Kapasitas Rumah / Kavling</span>
                        </div>
                        <div class="text-right">
                            <span class="text-2xl font-bold {{ $rumahCount >= $plan->max_houses ? 'text-red-600' : 'text-slate-800' }}">{{ $rumahCount }}</span>
                            <span class="text-sm text-slate-500">/ {{ $plan->max_houses }}</span>
                        </div>
                    </div>
                    
                    @php
                        $percentage = min(100, ($rumahCount / max(1, $plan->max_houses)) * 100);
                        $barColor = $percentage >= 100 ? 'bg-red-500' : ($percentage >= 80 ? 'bg-amber-500' : 'bg-brand-indigo-500');
                    @endphp
                    
                    <div class="w-full bg-slate-100 rounded-full h-3 mb-2 overflow-hidden">
                        <div class="{{ $barColor }} h-3 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                    </div>
                    @if($percentage >= 100)
                        <p class="text-xs text-red-500 mt-1">Kapasitas penuh! Anda tidak dapat menambahkan rumah baru.</p>
                    @endif
                </div>

                <h3 class="text-lg font-semibold text-slate-800 mb-4 pt-4 border-t border-slate-100">Fitur Tersedia</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @php
                        $allFeatures = [
                            'warga' => 'Manajemen Data Warga',
                            'iuran' => 'Sistem Tagihan & Iuran',
                            'laporan' => 'Laporan Keuangan Kas',
                            'pengumuman' => 'Papan Pengumuman Digital',
                            'polling' => 'E-Voting & Polling',
                            'surat' => 'Administrasi Surat Pengantar',
                            'keluhan' => 'Sistem Keluhan Warga',
                            'lapak' => 'Marketplace (Lapak Warga)',
                        ];
                        $planFeatures = is_array($plan->features) ? $plan->features : [];
                    @endphp

                    @foreach($allFeatures as $key => $label)
                        <div class="flex items-center gap-3 p-3 rounded-xl border {{ in_array($key, $planFeatures) ? 'border-brand-indigo-100 bg-brand-indigo-50/50' : 'border-slate-100 bg-slate-50' }}">
                            @if(in_array($key, $planFeatures))
                                <div class="h-8 w-8 rounded-full bg-brand-indigo-100 text-brand-indigo-600 flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                                </div>
                                <span class="font-medium text-slate-800 text-sm">{{ $label }}</span>
                            @else
                                <div class="h-8 w-8 rounded-full bg-slate-200 text-slate-400 flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                </div>
                                <span class="font-medium text-slate-500 text-sm line-through">{{ $label }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            
        </div>
    @else
        <div class="bg-amber-50 border-l-4 border-amber-400 p-4 rounded-r-xl mb-8">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-amber-700">
                        Tenant ini belum terikat dengan Paket Berlangganan (Plan) apa pun. Silakan pilih paket di bawah.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <div class="mt-12 mb-8">
        <h3 class="text-xl font-bold text-slate-800 mb-6">Pilihan Paket Berlangganan</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($allPlans as $p)
                <div class="bg-white rounded-2xl shadow-sm border {{ $plan && $plan->id == $p->id ? 'border-brand-indigo-500 ring-2 ring-brand-indigo-500/20' : 'border-slate-200' }} p-6 relative overflow-hidden flex flex-col h-full">
                    
                    @if($plan && $plan->id == $p->id)
                        <div class="absolute top-4 right-4 text-brand-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                        </div>
                    @endif

                    <h4 class="text-xl font-bold text-slate-800 mb-2">{{ $p->name }}</h4>
                    <p class="text-slate-500 text-sm mb-6 flex-grow">{{ $p->description }}</p>
                    
                    <div class="mb-6 pb-6 border-b border-slate-100">
                        <span class="text-3xl font-extrabold text-slate-900">Rp {{ number_format($p->price, 0, ',', '.') }}</span>
                        <span class="text-slate-500 text-sm">/{{ $p->billing_cycle === 'monthly' ? 'Bulan' : 'Tahun' }}</span>
                    </div>
                    
                    <div class="space-y-3 mb-8 text-sm text-slate-600 flex-grow">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Maksimal {{ $p->max_houses }} Rumah
                        </div>
                        @php
                            $features = is_array($p->features) ? $p->features : [];
                            $displayFeatures = array_slice($features, 0, 4);
                        @endphp
                        @foreach($displayFeatures as $f)
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                {{ $allFeatures[$f] ?? $f }}
                            </div>
                        @endforeach
                        @if(count($features) > 4)
                            <div class="flex items-center gap-2 text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Dan {{ count($features) - 4 }} fitur lainnya
                            </div>
                        @endif
                    </div>

                    @can('manage settings')
                        @if(!$plan || $plan->id != $p->id)
                            <button type="button" wire:click="subscribe({{ $p->id }})" wire:loading.attr="disabled" class="w-full bg-brand-indigo-600 hover:bg-brand-indigo-700 text-white font-semibold py-3 rounded-xl transition-colors shadow-sm mt-auto">
                                <span wire:loading.remove wire:target="subscribe({{ $p->id }})">Langganan Paket Ini</span>
                                <span wire:loading wire:target="subscribe({{ $p->id }})" class="inline-flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Memproses...
                                </span>
                            </button>
                        @else
                            <div class="w-full bg-slate-100 text-slate-400 text-center font-medium py-3 rounded-xl mt-auto">
                                Paket Saat Ini
                            </div>
                        @endif
                    @endcan
                </div>
            @endforeach
        </div>
    </div>

    <!-- Riwayat Tagihan -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-12">
        <div class="p-6 border-b border-slate-100">
            <h3 class="text-lg font-semibold text-slate-800">Riwayat Tagihan Langganan</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left whitespace-nowrap">
                <thead class="bg-slate-50/50 text-slate-500 border-b border-slate-100/60 text-xs uppercase font-semibold tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Paket</th>
                        <th class="px-6 py-4">Nominal</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/60">
                    @forelse($subscriptions as $sub)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 text-slate-700">
                            {{ $sub->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-900">
                            {{ $sub->plan->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-slate-700">
                            Rp {{ number_format($sub->amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($sub->status === 'Lunas')
                                <span class="inline-flex items-center rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-0.5 text-xs font-semibold shadow-sm"><span class="w-1.5 h-1.5 rounded-full mr-1.5 bg-emerald-500"></span>Lunas</span>
                            @elseif($sub->status === 'Pending')
                                <span class="inline-flex items-center rounded-full bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-0.5 text-xs font-semibold shadow-sm"><span class="w-1.5 h-1.5 rounded-full mr-1.5 bg-amber-500 animate-pulse"></span>Pending</span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-rose-50 text-rose-700 border border-rose-200 px-2.5 py-0.5 text-xs font-semibold shadow-sm"><span class="w-1.5 h-1.5 rounded-full mr-1.5 bg-rose-500"></span>Ditolak/Expired</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($sub->status === 'Pending' && $sub->checkout_url)
                                @can('manage settings')
                                    <a href="{{ $sub->checkout_url }}" target="_blank" class="inline-flex items-center justify-center h-8 px-3 rounded-lg text-indigo-600 hover:text-white hover:bg-indigo-600 font-medium text-xs transition-colors border border-indigo-200 hover:border-indigo-600 shadow-sm">
                                        Bayar Sekarang
                                    </a>
                                @endcan
                            @elseif($sub->status === 'Pending')
                                <span class="text-xs text-slate-400 italic">Menyiapkan pembayaran...</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <p class="text-slate-500 text-sm">Tidak ada riwayat tagihan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>
