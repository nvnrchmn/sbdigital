<div>
    <div class="mb-6">
        <a href="{{ route('tenant.polling') }}" wire:navigate class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Polling
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden w-full max-w-3xl mx-auto">
        <div class="p-8 md:p-10">
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-6">
                <div>
                    <div class="flex items-center gap-3 mb-3">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                            {{ $isClosed ? 'bg-slate-100 text-slate-700' : 'bg-emerald-100 text-emerald-700' }}">
                            @if($isClosed)
                                Ditutup
                            @else
                                Sedang Aktif
                            @endif
                        </span>
                        @if($poll->tgl_selesai)
                        <span class="text-sm font-medium text-slate-500 flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Batas: {{ $poll->tgl_selesai->format('d M Y, H:i') }}
                        </span>
                        @endif
                    </div>
                    <h2 class="text-3xl font-display font-extrabold text-slate-900 mb-4">{{ $poll->judul }}</h2>
                    @if($poll->deskripsi)
                    <p class="text-slate-600 leading-relaxed">{{ $poll->deskripsi }}</p>
                    @endif
                </div>

                @if($isPengurus && !$isClosed)
                <div class="shrink-0">
                    <button wire:click="closePolling" wire:confirm="Tutup polling ini secara paksa?" class="px-4 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 rounded-xl text-sm font-semibold transition-colors flex items-center shadow-sm">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Tutup Polling
                    </button>
                </div>
                @endif
            </div>

            <div class="mt-8 pt-8 border-t border-slate-100">
                @if(!$hasVoted && !$isClosed)
                    <!-- Form Pemilihan -->
                    <h4 class="text-lg font-bold text-slate-800 mb-6">Pilih salah satu opsi di bawah ini:</h4>
                    
                    <div class="space-y-4">
                        @foreach($poll->options as $option)
                        <label class="relative flex cursor-pointer rounded-xl border border-slate-200 bg-white p-5 hover:bg-slate-50 focus:outline-none has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50/50 has-[:checked]:ring-1 has-[:checked]:ring-indigo-500 transition-all shadow-sm hover:shadow">
                            <div class="flex items-center gap-4 w-full">
                                <div class="flex items-center">
                                    <input type="radio" wire:model="selectedOption" value="{{ $option->id }}" class="h-5 w-5 border-slate-300 text-indigo-600 focus:ring-indigo-600">
                                </div>
                                <div class="flex-1">
                                    <p class="font-bold text-slate-900 text-lg">{{ $option->teks }}</p>
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button wire:click="vote" class="inline-flex justify-center items-center rounded-xl bg-indigo-600 px-8 py-3.5 text-sm font-bold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors disabled:opacity-50" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="vote">Berikan Suara Saya</span>
                            <span wire:loading wire:target="vote">Memproses...</span>
                            <svg wire:loading.remove wire:target="vote" class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                    </div>

                @else
                    <!-- Hasil Polling -->
                    <div class="flex items-center justify-between mb-6">
                        <h4 class="text-xl font-bold text-slate-800">Hasil Polling</h4>
                        <div class="px-3 py-1.5 bg-slate-100 rounded-lg text-sm font-semibold text-slate-600">
                            Total: {{ $totalVotes }} Suara
                        </div>
                    </div>

                    @if($hasVoted && !$isClosed)
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-start text-emerald-800">
                        <svg class="w-5 h-5 mr-3 mt-0.5 shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>
                            <p class="font-semibold">Terima kasih telah berpartisipasi!</p>
                            <p class="text-sm mt-1 opacity-90">Suara Anda telah tercatat dalam sistem. Berikut adalah hasil sementara dari polling ini.</p>
                        </div>
                    </div>
                    @endif

                    <div class="space-y-6">
                        @foreach($results as $result)
                        <div class="relative">
                            <div class="flex justify-between items-end mb-2">
                                <div class="flex items-center">
                                    <span class="font-bold text-slate-800 text-lg">{{ $result['option']->teks }}</span>
                                    @if($result['isUserChoice'])
                                        <span class="ml-3 inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-indigo-100 text-indigo-800">
                                            Pilihan Anda
                                        </span>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <span class="text-2xl font-black text-slate-900">{{ $result['percentage'] }}%</span>
                                    <span class="text-sm font-medium text-slate-500 block">{{ $result['votes'] }} suara</span>
                                </div>
                            </div>
                            <!-- Progress Bar -->
                            <div class="overflow-hidden bg-slate-100 rounded-full h-4 shadow-inner">
                                <div class="h-4 rounded-full bg-gradient-to-r {{ $result['isUserChoice'] ? 'from-indigo-500 to-purple-500' : 'from-slate-400 to-slate-500' }} transition-all duration-1000 ease-out" 
                                     style="width: {{ $result['percentage'] }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
