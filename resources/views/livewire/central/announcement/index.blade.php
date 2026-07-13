<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-display font-bold text-xl text-slate-800 leading-tight">
                {{ __('Siaran Global') }}
            </h2>
            <a href="{{ route('superadmin.announcements.create') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 transition ease-in-out duration-150 shadow-sm">
                Buat Siaran Baru
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Judul Siaran</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold">Tanggal Dibuat</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($announcements as $ann)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-medium text-slate-900 block">{{ $ann->title }}</span>
                                <span class="text-slate-500 text-xs truncate max-w-xs block mt-1">{{ Str::limit($ann->content, 50) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($ann->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                {{ $ann->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('superadmin.announcements.edit', $ann->id) }}" wire:navigate class="text-indigo-600 hover:text-indigo-900 font-medium text-sm">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    <p class="text-lg font-medium text-slate-900">Belum ada siaran global</p>
                                    <p class="text-sm mt-1">Buat siaran pertama Anda untuk menyapa semua tenant.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
