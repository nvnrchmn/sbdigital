<div>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-display font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-600 tracking-tight">Manajemen Tenant</h2>
            <p class="text-slate-500 text-sm mt-1">Kelola semua perumahan yang menggunakan layanan SB Digital.</p>
        </div>
        <x-primary-button href="{{ route('superadmin.tenants.create') }}" wire:navigate>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            Tambah Tenant Manual
        </x-primary-button>
    </div>

    <x-card class="mb-8 overflow-hidden p-0">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-display font-bold text-lg text-slate-800">Daftar Tenant Terdaftar</h3>
            <p class="text-sm text-slate-500 mt-1">Tenant yang sudah aktif.</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-slate-50 border-b border-slate-100 text-slate-500">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Nama Perumahan</th>
                        <th class="px-6 py-4 font-semibold">ID / Path (URL)</th>
                        <th class="px-6 py-4 font-semibold">Paket / DB</th>
                        <th class="px-6 py-4 font-semibold">Admin (Nama)</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($tenants as $tenant)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-6 py-4 font-medium text-slate-900">{{ $tenant->nama_perumahan ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ url('/' . $tenant->id . '/login') }}" target="_blank" class="text-brand-indigo-600 hover:underline flex items-center gap-1 font-mono text-sm bg-brand-indigo-50 px-2 py-1 rounded w-max">
                                    /{{ $tenant->id }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1 text-sm">
                                    <span class="font-medium text-brand-indigo-600">{{ $tenant->plan ? $tenant->plan->name : 'Belum Dipilih' }}</span>
                                    <span class="text-slate-500 text-xs font-mono">{{ $tenant->tenancy_db_name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ $tenant->nama_admin ?? '-' }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    <a href="{{ route('superadmin.tenants.edit', $tenant->id) }}" wire:navigate class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-slate-400 hover:text-brand-indigo-600 hover:bg-brand-indigo-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                                    </a>
                                    <button wire:click="confirmDelete('{{ $tenant->id }}')" class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 text-slate-400 mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                    </div>
                                    <p>Belum ada tenant yang terdaftar.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/30">
            {{ $tenants->links() }}
        </div>
    </x-card>

    <!-- Pendaftar Tertunda -->
    <x-card class="overflow-hidden p-0 border-amber-200">
        <div class="p-6 border-b border-amber-100 bg-amber-50/50">
            <h3 class="font-display font-bold text-lg text-amber-800">Antrean Pendaftar (Pending Verification)</h3>
            <p class="text-sm text-amber-600 mt-1">Daftar calon tenant yang belum melakukan klik tautan verifikasi dari email mereka.</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-amber-50/30 border-b border-amber-100 text-slate-500">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Nama Perumahan</th>
                        <th class="px-6 py-4 font-semibold">ID Booking</th>
                        <th class="px-6 py-4 font-semibold">Calon Admin</th>
                        <th class="px-6 py-4 font-semibold">Tanggal Daftar</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-amber-100">
                    @forelse($pendings as $pending)
                        <tr class="hover:bg-amber-50/50 transition-colors group">
                            <td class="px-6 py-4 font-medium text-slate-900">{{ $pending->nama_perumahan }}</td>
                            <td class="px-6 py-4 font-mono text-brand-indigo-600">{{ $pending->tenant_id }}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <span class="font-medium text-slate-700">{{ $pending->admin_name }}</span>
                                    <span class="text-slate-500 text-xs">{{ $pending->admin_email }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $pending->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    <button wire:click="deletePending({{ $pending->id }})" onclick="confirm('Yakin ingin menghapus antrean ini?') || event.stopImmediatePropagation()" class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                <p>Tidak ada pendaftar yang sedang antre/pending.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>
</div>
