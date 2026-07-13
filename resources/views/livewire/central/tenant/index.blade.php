<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-display font-bold text-xl text-slate-800 leading-tight">
                {{ __('Manajemen Tenant') }}
            </h2>
            <a href="{{ route('superadmin.tenants.create') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                Tambah Tenant Manual
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-200 bg-slate-50/50">
            <h3 class="font-display font-bold text-lg text-slate-800">Daftar Tenant Terdaftar</h3>
            <p class="text-sm text-slate-500 mt-1">Kelola semua perumahan yang menggunakan layanan SB Digital.</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500">
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
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-900">{{ $tenant->nama_perumahan ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ url('/' . $tenant->id . '/login') }}" target="_blank" class="text-indigo-600 hover:underline flex items-center gap-1 font-mono text-sm bg-indigo-50 px-2 py-1 rounded w-max">
                                    /{{ $tenant->id }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1 text-sm">
                                    <span class="font-medium text-indigo-600">{{ $tenant->plan ? $tenant->plan->name : 'Belum Dipilih' }}</span>
                                    <span class="text-slate-500 text-xs font-mono">{{ $tenant->tenancy_db_name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ $tenant->nama_admin ?? '-' }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('superadmin.tenants.edit', $tenant->id) }}" wire:navigate class="text-indigo-600 font-semibold hover:text-indigo-800 bg-indigo-50 px-3 py-1.5 rounded-lg mr-2 transition-colors">Edit</a>
                                <button wire:click="confirmDelete('{{ $tenant->id }}')" class="text-rose-600 font-semibold hover:text-rose-800 bg-rose-50 px-3 py-1.5 rounded-lg transition-colors">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-300 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <p>Belum ada tenant yang terdaftar.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $tenants->links() }}
        </div>
    </div>
</div>
