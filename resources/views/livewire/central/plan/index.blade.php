<div>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-display font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-600 tracking-tight">Paket & Limitasi</h2>
            <p class="text-slate-500 text-sm mt-1">Kelola paket langganan dan fitur yang tersedia untuk Tenant.</p>
        </div>
        <x-primary-button href="{{ route('superadmin.plans.create') }}" wire:navigate>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            Tambah Paket
        </x-primary-button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($plans as $plan)
            <x-card class="flex flex-col p-0 overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-display font-bold text-xl text-slate-800">{{ $plan->name }}</h3>
                    <p class="text-sm text-slate-500 mt-2 min-h-[40px]">{{ $plan->description }}</p>
                </div>
                
                <div class="p-6 flex-1">
                    <div class="mb-6">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Batasan Kapasitas</p>
                        <div class="flex items-center text-slate-700">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 text-brand-indigo-500"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                            Maksimal <strong class="mx-1">{{ $plan->max_houses }}</strong> Data Rumah
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Fitur yang Diizinkan</p>
                        <ul class="space-y-2">
                            @php
                                $allFeatures = ['pengumuman', 'iuran', 'laporan', 'warga', 'lapak', 'surat', 'keluhan', 'polling'];
                                $planFeatures = $plan->features ?? [];
                                
                                $sortedFeatures = collect($allFeatures)->sortByDesc(function ($feature) use ($planFeatures) {
                                    return in_array($feature, $planFeatures) ? 1 : 0;
                                })->values()->all();
                            @endphp
                            
                            @foreach($sortedFeatures as $feature)
                                <li class="flex items-center text-sm {{ in_array($feature, $planFeatures) ? 'text-slate-700' : 'text-slate-400 line-through opacity-60' }}">
                                    @if(in_array($feature, $planFeatures))
                                        <svg class="w-4 h-4 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    @else
                                        <svg class="w-4 h-4 mr-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    @endif
                                    Modul {{ ucfirst($feature) }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="p-6 border-t border-slate-100 bg-slate-50 flex justify-between items-center mt-auto">
                    <span class="text-sm text-slate-500 font-medium">Digunakan oleh <strong class="text-slate-700">{{ $plan->tenants_count }}</strong> Tenant</span>
                    <a href="{{ route('superadmin.plans.edit', $plan->id) }}" wire:navigate class="text-sm font-semibold text-brand-indigo-600 hover:text-brand-indigo-800">Edit Paket</a>
                </div>
            </x-card>
        @endforeach
    </div>
</div>
