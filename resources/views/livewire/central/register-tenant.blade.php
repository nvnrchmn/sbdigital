<x-slot name="maxWidth">sm:max-w-4xl</x-slot>

<div>
    @if (session('status'))
        <div class="mb-8 p-6 bg-green-50 border border-green-200 rounded-2xl">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-bold text-green-900">Berhasil!</h3>
                    <div class="mt-1 text-sm text-green-700">
                        {{ session('status') }}
                    </div>
                </div>
            </div>
            <div class="mt-6">
                <a href="{{ route('home') }}" class="text-sm font-semibold text-green-800 hover:text-green-900 bg-green-100 hover:bg-green-200 px-4 py-2 rounded-lg transition-colors">Kembali ke Beranda</a>
            </div>
        </div>
    @else
        <div class="text-center mb-10">
            <h2 class="text-3xl font-display font-bold text-slate-900 tracking-tight">Mulai Kelola Perumahan Anda</h2>
            <p class="text-base text-slate-500 mt-2">Daftar sekarang, gratis tanpa kartu kredit.</p>
        </div>

    <form wire:submit="register" class="space-y-8 md:space-y-0 md:grid md:grid-cols-2 md:gap-8">
        
        <!-- Left Column: Data Perumahan -->
        <div class="space-y-5">
            <div class="pb-2 border-b border-slate-200">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Data Perumahan / RT</h3>
                <p class="text-xs text-slate-500 mt-1">Informasi dasar lingkungan Anda.</p>
            </div>

            <div>
                <label for="nama_perumahan" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Perumahan / RT <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    </div>
                    <input wire:model.live="nama_perumahan" id="nama_perumahan" type="text" class="block w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl bg-white focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 sm:text-sm" placeholder="Misal: Perumahan Indah RT 01" />
                </div>
                @error('nama_perumahan') <span class="text-xs text-red-500 mt-1.5 block font-medium">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="tenant_id" class="block text-sm font-medium text-slate-700 mb-1.5">ID Ruang Kerja (URL Path) <span class="text-red-500">*</span></label>
                <div class="flex items-stretch relative rounded-xl overflow-hidden border border-slate-200 bg-white focus-within:ring-2 focus-within:ring-indigo-500/20 focus-within:border-indigo-500 transition-all duration-200">
                    <span class="flex items-center px-3 bg-slate-50 border-r border-slate-200 text-slate-500 text-sm whitespace-nowrap">
                        {{ request()->getHttpHost() }}/
                    </span>
                    <input wire:model="tenant_id" id="tenant_id" type="text" class="flex-1 w-full border-none focus:ring-0 py-3 px-3 sm:text-sm bg-transparent" placeholder="perum-indah" />
                </div>
                <p class="text-[11px] text-slate-500 mt-1.5">Hanya huruf kecil, angka, dan strip (-). Ini akan jadi alamat login warga Anda.</p>
                @error('tenant_id') <span class="text-xs text-red-500 mt-1.5 block font-medium">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Right Column: Akun Administrator -->
        <div class="space-y-5">
            <div class="pb-2 border-b border-slate-200">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Akun Administrator</h3>
                <p class="text-xs text-slate-500 mt-1">Akses untuk mengelola lingkungan.</p>
            </div>

            <div>
                <label for="admin_name" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap Admin <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <input wire:model="admin_name" id="admin_name" type="text" class="block w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl bg-white focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 sm:text-sm" placeholder="Nama Anda" />
                </div>
                @error('admin_name') <span class="text-xs text-red-500 mt-1.5 block font-medium">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="admin_email" class="block text-sm font-medium text-slate-700 mb-1.5">Email Admin <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    </div>
                    <input wire:model="admin_email" id="admin_email" type="email" class="block w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl bg-white focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 sm:text-sm" placeholder="email@contoh.com" />
                </div>
                @error('admin_email') <span class="text-xs text-red-500 mt-1.5 block font-medium">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="admin_password" class="block text-sm font-medium text-slate-700 mb-1.5">Password <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </div>
                    <input wire:model="admin_password" id="admin_password" type="password" class="block w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl bg-white focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 sm:text-sm" placeholder="Minimal 8 karakter" />
                </div>
                @error('admin_password') <span class="text-xs text-red-500 mt-1.5 block font-medium">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Full width button -->
        <div class="md:col-span-2 pt-6">
            <button type="submit" wire:loading.attr="disabled" class="w-full flex justify-center items-center py-4 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 disabled:opacity-70 disabled:cursor-not-allowed">
                <span wire:loading.remove>Daftar & Buat Ruang Kerja</span>
                <span wire:loading class="flex items-center gap-2">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Memproses Pembuatan...
                </span>
            </button>
            
            <div class="text-center text-sm text-slate-500 mt-6 space-y-2">
                <div>
                    Sudah mendaftarkan perumahan? 
                    <a href="{{ route('home') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 transition-colors">Kembali ke Beranda</a>
                </div>
                <div class="text-xs">
                    Atau pengurus lama? 
                    <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 transition-colors">Login ke Perumahan</a>
                </div>
            </div>
        </div>
    </form>
    @endif
</div>
