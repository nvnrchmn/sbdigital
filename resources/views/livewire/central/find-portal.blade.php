<div>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Cari Perumahan Anda</h2>
        <p class="text-sm text-slate-500 mt-2">Masukkan email yang terdaftar untuk masuk ke portal perumahan Anda.</p>
    </div>

    <form wire:submit="search">
        <!-- Email Address -->
        <div>
            <label class="block font-medium text-sm text-slate-700" for="email">Email Terdaftar</label>
            <input wire:model="email" id="email" class="block mt-1 w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors bg-white/50" type="email" name="email" required autofocus autocomplete="username" placeholder="contoh: budi@email.com" />
            @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center mt-6">
            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-3 bg-indigo-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm shadow-indigo-600/20" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="search">Cari Portal</span>
                <span wire:loading wire:target="search" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Mencari...
                </span>
            </button>
        </div>
    </form>

    @if($hasSearched)
        <div class="mt-8 border-t border-slate-100 pt-6">
            @if(count($foundTenants) > 0)
                <h3 class="text-sm font-semibold text-slate-900 mb-4 text-center">Ditemukan {{ count($foundTenants) }} Perumahan</h3>
                <div class="space-y-3">
                    @foreach($foundTenants as $tenant)
                        <a href="{{ $tenant['login_url'] }}" class="flex items-center justify-between p-4 rounded-xl border border-indigo-100 bg-indigo-50/50 hover:bg-indigo-50 hover:border-indigo-200 transition-colors group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-bold text-lg shadow-sm">
                                    {{ strtoupper(substr($tenant['name'], 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-indigo-900">{{ $tenant['name'] }}</p>
                                    <p class="text-xs text-indigo-600/70">Klik untuk masuk</p>
                                </div>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-indigo-400 group-hover:text-indigo-600 group-hover:translate-x-1 transition-transform"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center bg-red-50/50 rounded-xl p-4 border border-red-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-auto text-red-500 mb-2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                    <p class="text-sm font-semibold text-red-800">Email tidak ditemukan</p>
                    <p class="text-xs text-red-600 mt-1">Pastikan email yang dimasukkan sudah benar.</p>
                </div>
            @endif
        </div>
    @endif

    <div class="mt-6 text-center text-sm text-slate-500">
        Kembali ke <a href="{{ route('home') }}" wire:navigate class="font-semibold text-indigo-600 hover:text-indigo-500 transition-colors">Halaman Utama</a>
    </div>
</div>
