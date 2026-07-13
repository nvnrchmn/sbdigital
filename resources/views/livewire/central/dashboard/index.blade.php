<div>
    <x-slot name="header">
        <h2 class="font-display font-bold text-xl text-slate-800 leading-tight">
            {{ __('Dashboard Superadmin') }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Perumahan / Tenant</p>
                        <h3 class="text-3xl font-display font-bold text-slate-900 mt-1">{{ $totalTenants }}</h3>
                    </div>
                </div>
            </div>

            <!-- Warga Metric -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Populasi Warga</p>
                        <h3 class="text-3xl font-display font-bold text-slate-900 mt-1">{{ number_format($totalWarga, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>

            <!-- Kas Metric -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"></path><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Kas Terkelola</p>
                        <h3 class="text-3xl font-display font-bold text-slate-900 mt-1">Rp{{ number_format($totalKasBeredar, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Tenants -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-200 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-display font-bold text-lg text-slate-800">Pendaftar Terbaru</h3>
                <a href="{{ route('superadmin.tenants.index') }}" wire:navigate class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">Lihat Semua &rarr;</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-500">
                        <tr>
                            <th class="px-6 py-3 font-semibold">Nama Perumahan</th>
                            <th class="px-6 py-3 font-semibold">Domain</th>
                            <th class="px-6 py-3 font-semibold">Admin (Nama)</th>
                            <th class="px-6 py-3 font-semibold">Tanggal Daftar</th>
                            <th class="px-6 py-3 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentTenants as $tenant)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-slate-900">{{ $tenant->nama_perumahan ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    @if($tenant->domains->count() > 0)
                                        <a href="http://{{ $tenant->domains->first()->domain }}" target="_blank" class="text-indigo-600 hover:underline">
                                            {{ $tenant->domains->first()->domain }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ $tenant->nama_admin ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ $tenant->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="#" class="text-indigo-600 font-semibold hover:text-indigo-800">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                    Belum ada tenant yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
