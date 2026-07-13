<div>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-display font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-600 tracking-tight">Manajemen Role</h2>
            <p class="text-slate-500 text-sm mt-1">Atur hak akses pengguna (Role-Based Access Control).</p>
        </div>
    </div>

    <div class="bg-white/60 backdrop-blur-xl border border-white/40 shadow-sm rounded-2xl overflow-hidden mb-6">
        <div class="p-4 border-b border-slate-100/60 flex items-center">
            <div class="relative w-full max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" /></svg>
                </div>
                <input wire:model.live="search" type="text" class="block w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-xl leading-5 bg-white/50 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-shadow duration-200" placeholder="Cari nama atau email pengguna..." />
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left whitespace-nowrap">
                <thead class="bg-slate-50/50 text-slate-500 border-b border-slate-100/60 text-xs uppercase font-semibold tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Pengguna</th>
                        <th class="px-6 py-4">Role / Hak Akses</th>
                        <th class="px-6 py-4">Status Warga</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/60">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/50 transition-colors duration-200 group">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-10 w-10 flex-shrink-0 bg-gradient-to-br from-slate-100 to-slate-200 text-slate-600 rounded-full flex items-center justify-center font-bold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-semibold text-slate-900">{{ $user->name }}</div>
                                    <div class="text-xs text-slate-500 mt-0.5">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1.5">
                                @forelse($user->roles as $role)
                                    @php
                                        $colorClass = match($role->name) {
                                            'Tenant Owner' => 'bg-purple-100 text-purple-700 border-purple-200',
                                            'Ketua RT' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                                            'Sekretaris', 'Bendahara' => 'bg-blue-100 text-blue-700 border-blue-200',
                                            'Warga' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                            default => 'bg-slate-100 text-slate-700 border-slate-200'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $colorClass }}">
                                        {{ $role->name }}
                                    </span>
                                @empty
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-500 border border-slate-200">
                                        Belum ada role
                                    </span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->warga)
                                <span class="inline-flex items-center gap-1.5 text-xs font-medium text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    Terhubung Warga
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-500 bg-slate-50 px-2.5 py-1 rounded-md border border-slate-200">
                                    Belum Terhubung
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                @if(Auth::id() !== $user->id)
                                <button wire:click="$dispatch('openModal', { component: 'tenant.role.form', arguments: { user: {{ $user->id }} } })" class="inline-flex items-center justify-center gap-1.5 h-8 px-3 rounded-lg text-indigo-600 hover:text-white hover:bg-indigo-600 transition-colors border border-indigo-200 hover:border-indigo-600 shadow-sm font-medium text-xs">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                    Atur Role
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 text-slate-400 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            </div>
                            <p class="text-slate-500 text-sm">Tidak ada pengguna yang ditemukan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-slate-100/60 bg-slate-50/30">
            {{ $users->links() }}
        </div>
    </div>
</div>
