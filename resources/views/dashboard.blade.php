<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-display font-bold text-display-lg text-slate-900 leading-tight">
                    Dashboard
                </h2>
                <p class="text-body-md text-slate-500 mt-1">Ringkasan operasional dan statistik warga.</p>
            </div>
            <button onclick="Livewire.dispatch('swal:modal', [{ title: 'Info Sistem', text: 'Semua sistem berjalan normal!', icon: 'success' }])" class="inline-flex items-center justify-center gap-2 rounded-lg font-sans font-semibold transition disabled:opacity-50 disabled:pointer-events-none bg-brand-gradient text-white hover:brightness-105 shadow-sm h-10 px-4 text-body-md">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                Cek Status Sistem
            </button>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto space-y-6">
            
            @php
                $announcement = \App\Models\GlobalAnnouncement::where('is_active', true)->latest()->first();
            @endphp

            @if($announcement)
                <div class="bg-indigo-600 rounded-2xl shadow-sm overflow-hidden flex items-start gap-4 p-4 text-white">
                    <div class="bg-indigo-500/50 p-2 rounded-lg shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </div>
                    <div>
                        <h4 class="font-display font-semibold text-lg">{{ $announcement->title }}</h4>
                        <p class="text-indigo-100 text-sm mt-1 whitespace-pre-line">{{ $announcement->content }}</p>
                    </div>
                </div>
            @endif

            <!-- Welcome Banner -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs relative overflow-hidden">
                <!-- Decorative arc -->
                <div class="absolute top-0 right-0 -mt-16 -mr-16 opacity-10">
                    <svg width="200" height="200" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="100" cy="100" r="98" stroke="#2A5DF9" stroke-width="4"/><circle cx="100" cy="100" r="78" stroke="#2A5DF9" stroke-width="4"/></svg>
                </div>
                
                <div class="p-6 relative z-10 flex items-center justify-between">
                    <div>
                        <h3 class="font-display text-heading-md font-semibold text-slate-900">Selamat datang kembali, {{ auth()->user()->name }}! 👋</h3>
                        <p class="text-body-sm text-slate-500 mt-2 max-w-xl">Ini adalah pusat kendali untuk mengelola data operasional di {{ tenant('id') ? 'Tenant ' . tenant('id') : 'Central' }}. Pantau data warga, iuran, dan laporan secara real-time.</p>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Stat Card 1 -->
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-xs flex flex-col relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 transition-opacity group-hover:opacity-20 text-brand-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <p class="text-caption uppercase tracking-wide text-slate-500">Total Warga</p>
                    <p class="mt-1 font-display text-display-lg text-slate-900">142</p>
                    <div class="mt-4 flex items-center text-body-sm">
                        <span class="inline-flex items-center gap-1 text-success-500 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                            +12%
                        </span>
                        <span class="text-slate-400 ml-2">bulan ini</span>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-xs flex flex-col relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 transition-opacity group-hover:opacity-20 text-brand-cyan-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    </div>
                    <p class="text-caption uppercase tracking-wide text-slate-500">Total Rumah</p>
                    <p class="mt-1 font-display text-display-lg text-slate-900">84</p>
                    <div class="mt-4 flex items-center text-body-sm">
                        <span class="inline-flex items-center gap-1 text-slate-500">
                            Terdata aktif
                        </span>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-xs flex flex-col relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 transition-opacity group-hover:opacity-20 text-emerald-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                    </div>
                    <p class="text-caption uppercase tracking-wide text-slate-500">Kas Masuk</p>
                    <p class="mt-1 font-display text-display-lg text-slate-900 font-mono text-3xl flex items-baseline gap-1"><span class="text-body-sm text-slate-400 font-sans">Rp</span>4.5M</p>
                    <div class="mt-4 flex items-center text-body-sm">
                        <span class="inline-flex items-center gap-1 text-success-500 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                            +5.2%
                        </span>
                        <span class="text-slate-400 ml-2">bulan ini</span>
                    </div>
                </div>

                <!-- Stat Card 4 -->
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-xs flex flex-col relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 transition-opacity group-hover:opacity-20 text-danger-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><line x1="10" x2="8" y1="9" y2="9"/></svg>
                    </div>
                    <p class="text-caption uppercase tracking-wide text-slate-500">Tunggakan</p>
                    <p class="mt-1 font-display text-display-lg text-slate-900 text-3xl">12 <span class="text-body-sm text-slate-400 font-sans font-normal">rumah</span></p>
                    <div class="mt-4 flex items-center text-body-sm">
                        <span class="inline-flex items-center gap-1 text-danger-500 font-medium">
                            Perlu ditindaklanjuti
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
