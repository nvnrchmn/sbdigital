<x-slot name="maxWidth">sm:max-w-md</x-slot>

<div>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-display font-bold text-slate-900">Verifikasi Pendaftaran</h2>
    </div>

    <div class="bg-white px-8 py-10 shadow-xl shadow-slate-200/40 rounded-2xl border border-slate-100">
        @if($status === 'loading')
            <div class="text-center">
                <svg class="animate-spin mx-auto h-10 w-10 text-indigo-600 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <h3 class="text-lg font-medium text-slate-900">Memverifikasi dan Membuat Ruang Kerja...</h3>
                <p class="text-sm text-slate-500 mt-2">Mohon tunggu sebentar, proses ini mungkin memakan waktu beberapa menit.</p>
            </div>
        @elseif($status === 'success')
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-slate-900">Verifikasi Berhasil!</h3>
                <p class="text-sm text-slate-500 mt-2 mb-6">{{ $message }}</p>
                <a href="{{ $tenantUrl }}" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Lanjut ke Login Perumahan
                </a>
            </div>
        @else
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-slate-900">Verifikasi Gagal</h3>
                <p class="text-sm text-slate-500 mt-2 mb-6">{{ $message }}</p>
                <a href="{{ route('home') }}" class="w-full flex justify-center py-3 px-4 border border-slate-300 rounded-xl shadow-sm text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Kembali ke Beranda
                </a>
            </div>
        @endif
    </div>
</div>
