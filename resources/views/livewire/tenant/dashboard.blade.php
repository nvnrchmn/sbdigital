<div class="py-6">
    <div class="max-w-7xl mx-auto space-y-6">
        
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
            <div class="absolute top-0 right-0 -mt-16 -mr-16 opacity-10">
                <svg width="200" height="200" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="100" cy="100" r="98" stroke="#2A5DF9" stroke-width="4"/><circle cx="100" cy="100" r="78" stroke="#2A5DF9" stroke-width="4"/></svg>
            </div>
            
            <div class="p-6 relative z-10 flex items-center justify-between">
                <div>
                    <h3 class="font-display text-heading-md font-semibold text-slate-900">Selamat datang kembali, {{ auth()->user()->name }}! 👋</h3>
                    <p class="text-body-sm text-slate-500 mt-2 max-w-xl">
                        Ini adalah pusat transparansi data {{ tenant('id') ? 'Lingkungan ' . tenant('id') : 'Central' }}. Pantau data warga, iuran, dan laporan secara real-time.
                    </p>
                </div>
            </div>
        </div>

        <!-- Stats Grid (Transparan untuk semua) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Stat Card 1 -->
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-xs flex flex-col relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 transition-opacity group-hover:opacity-20 text-brand-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <p class="text-caption uppercase tracking-wide text-slate-500">Total Warga</p>
                <p class="mt-1 font-display text-display-lg text-slate-900">{{ number_format($totalWarga, 0, ',', '.') }}</p>
                <div class="mt-4 flex items-center text-body-sm">
                    <span class="inline-flex items-center gap-1 text-slate-500">
                        Warga terdaftar
                    </span>
                </div>
            </div>

            <!-- Stat Card 2 -->
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-xs flex flex-col relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 transition-opacity group-hover:opacity-20 text-brand-cyan-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                </div>
                <p class="text-caption uppercase tracking-wide text-slate-500">Total Rumah</p>
                <p class="mt-1 font-display text-display-lg text-slate-900">{{ number_format($totalRumah, 0, ',', '.') }}</p>
                <div class="mt-4 flex items-center text-body-sm">
                    <span class="inline-flex items-center gap-1 text-slate-500">
                        Rumah terdata aktif
                    </span>
                </div>
            </div>

            <!-- Stat Card 3 -->
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-xs flex flex-col relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 transition-opacity group-hover:opacity-20 text-emerald-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                </div>
                <p class="text-caption uppercase tracking-wide text-slate-500">Total Kas Iuran (Lunas)</p>
                <p class="mt-1 font-display text-display-md text-slate-900 font-mono text-2xl flex items-baseline gap-1"><span class="text-body-sm text-slate-400 font-sans">Rp</span>{{ number_format($kasMasuk, 0, ',', '.') }}</p>
                <div class="mt-4 flex items-center text-body-sm">
                    <span class="inline-flex items-center gap-1 text-emerald-500 font-medium">
                        Transparan untuk semua warga
                    </span>
                </div>
            </div>

            <!-- Stat Card 4 -->
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-xs flex flex-col relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 transition-opacity group-hover:opacity-20 text-danger-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><line x1="10" x2="8" y1="9" y2="9"/></svg>
                </div>
                <p class="text-caption uppercase tracking-wide text-slate-500">Tunggakan Iuran</p>
                <p class="mt-1 font-display text-display-lg text-slate-900 text-3xl">{{ $tunggakan }} <span class="text-body-sm text-slate-400 font-sans font-normal">transaksi</span></p>
                <div class="mt-4 flex items-center text-body-sm">
                    <span class="inline-flex items-center gap-1 text-danger-500 font-medium">
                        Perlu ditindaklanjuti
                    </span>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Chart 1: Status Iuran -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
                <h4 class="font-display font-semibold text-lg text-slate-900 mb-4">Status Iuran Keseluruhan</h4>
                <div id="iuranChart" class="w-full flex justify-center" wire:ignore></div>
            </div>

            <!-- Chart 2: Tren Keluhan -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
                <h4 class="font-display font-semibold text-lg text-slate-900 mb-4">Tren Keluhan Warga (6 Bulan)</h4>
                <div id="keluhanChart" class="w-full" wire:ignore></div>
            </div>

        </div>

    </div>
</div>

@push('scripts')
<!-- Load ApexCharts dari CDN -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('livewire:initialized', () => {
        // Data dari Livewire
        const iuranData = @json($chartIuranData);
        
        // 1. Render Pie Chart (Iuran)
        const iuranOptions = {
            series: iuranData,
            labels: ['Lunas', 'Menunggak/Belum Lunas'],
            chart: {
                type: 'donut',
                height: 320,
                fontFamily: 'inherit',
            },
            colors: ['#10b981', '#ef4444'], // Emerald (Lunas) & Red (Nunggak)
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        labels: {
                            show: true,
                            name: { show: true },
                            value: { show: true }
                        }
                    }
                }
            },
            dataLabels: { enabled: false },
            legend: { position: 'bottom' }
        };
        const iuranChart = new ApexCharts(document.querySelector("#iuranChart"), iuranOptions);
        iuranChart.render();

        // Data dari Livewire
        const keluhanCategories = @json($chartKeluhanCategories);
        const keluhanData = @json($chartKeluhanData);

        // 2. Render Bar Chart (Keluhan)
        const keluhanOptions = {
            series: [{
                name: 'Jumlah Keluhan',
                data: keluhanData
            }],
            chart: {
                type: 'bar',
                height: 320,
                fontFamily: 'inherit',
                toolbar: { show: false }
            },
            colors: ['#6366f1'], // Indigo
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    columnWidth: '50%',
                }
            },
            dataLabels: { enabled: false },
            xaxis: {
                categories: keluhanCategories,
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: {
                    formatter: function (val) {
                        return Math.floor(val);
                    }
                }
            },
            grid: {
                borderColor: '#f1f5f9',
                strokeDashArray: 4,
                yaxis: { lines: { show: true } }
            }
        };
        const keluhanChart = new ApexCharts(document.querySelector("#keluhanChart"), keluhanOptions);
        keluhanChart.render();
    });
</script>
@endpush
