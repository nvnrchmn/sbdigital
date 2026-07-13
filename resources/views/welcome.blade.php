<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SB Digital') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" href="/assets/sb-digital-icon.ico" type="image/x-icon">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Gradient Animation for Hero Text */
        .bg-300\% { background-size: 300% auto; }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .animate-gradient { animation: gradient 6s ease infinite; }

        /* Glassmorphism Classes */
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
        }
        
        .glass-card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .glass-card-hover:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
            border-color: rgba(99, 102, 241, 0.2); /* Indigo hint */
        }

        /* Scroll Reveal Animations */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.5, 0, 0, 1);
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Delays for grid items */
        .delay-100 { transition-delay: 100ms; }
        .delay-200 { transition-delay: 200ms; }
        .delay-300 { transition-delay: 300ms; }

        /* Smooth Floating Animation for Dashboard Mockup */
        @keyframes float {
            0% { transform: translateY(0px) rotateX(5deg) scale(0.95); }
            50% { transform: translateY(-15px) rotateX(5deg) scale(0.95); }
            100% { transform: translateY(0px) rotateX(5deg) scale(0.95); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
            transform-style: preserve-3d;
            perspective: 1000px;
        }
    </style>
</head>
<body class="font-sans antialiased text-slate-800 bg-slate-50 min-h-screen overflow-x-hidden selection:bg-indigo-500/30 selection:text-indigo-900" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">
    
    <!-- Ambient Background Bubbles (Fixed behind content) -->
    <div class="fixed inset-0 z-[-1] pointer-events-none overflow-hidden">
        <div class="absolute top-[-10%] left-[-5%] w-[40%] h-[40%] rounded-full bg-indigo-500/10 blur-[100px]"></div>
        <div class="absolute top-[30%] right-[-10%] w-[50%] h-[50%] rounded-full bg-blue-500/10 blur-[120px]"></div>
        <div class="absolute bottom-[-10%] left-[20%] w-[30%] h-[30%] rounded-full bg-violet-500/10 blur-[100px]"></div>
    </div>

    <!-- 1. Header / Navbar (Floating Pill Design) -->
    <div class="fixed top-0 inset-x-0 z-50 pt-6 px-4 transition-all duration-500" :class="{ 'pt-4': scrolled, 'pt-6': !scrolled }">
        <header class="max-w-5xl mx-auto bg-white/80 backdrop-blur-xl border border-slate-200/60 rounded-full shadow-xl shadow-slate-200/20 px-6 sm:px-8 py-3.5 flex items-center justify-between transition-all duration-500" :class="{ 'bg-white/95 border-slate-200 shadow-slate-200/40': scrolled }">
            <div class="flex items-center gap-3">
                <a href="#" class="flex items-center"><img src="/assets/sb-digital-logo.svg" alt="SB Digital" class="h-8 md:h-9 w-auto transition-transform hover:scale-105 origin-left"></a>
            </div>
            
            <nav class="hidden md:flex items-center gap-8 text-sm font-bold text-slate-600">
                <a href="#layanan" class="hover:text-indigo-600 transition-colors">Layanan</a>
                <a href="#client" class="hover:text-indigo-600 transition-colors">Klien</a>
                <a href="#pricing" class="hover:text-indigo-600 transition-colors">Harga</a>
            </nav>

            <div class="flex items-center gap-3 sm:gap-4">
                @if (Route::has('login'))
                    <div class="flex items-center gap-4">
                        @auth
                            <a href="{{ auth()->user()->hasRole('Super Admin') ? route('superadmin.dashboard') : route('profile') }}" class="text-xs sm:text-sm font-bold text-slate-600 hover:text-indigo-600 transition-colors">Dashboard</a>
                        @else
                            <a href="{{ route('find-portal') }}" class="text-xs sm:text-sm font-bold text-slate-600 hover:text-indigo-600 transition-colors">Login / Masuk</a>
                        @endauth
                    </div>
                @endif
                
                <a href="{{ route('register.tenant') }}" class="inline-flex items-center justify-center gap-2 rounded-full font-sans font-bold transition-all duration-300 bg-indigo-600 text-white hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-0.5 h-9 sm:h-11 px-4 sm:px-6 text-xs sm:text-sm">
                    Mulai Gratis
                </a>
            </div>
        </header>
    </div>

    <!-- 2. Hero Section -->
    <section class="relative z-10 pt-32 pb-20 px-4 sm:px-6 lg:px-8 min-h-[95vh] flex flex-col justify-center items-center">
        <div class="max-w-5xl mx-auto text-center mt-10 md:mt-0 reveal">
            
            <div class="inline-flex items-center rounded-full border border-indigo-200/60 bg-white/60 backdrop-blur-sm px-4 py-1.5 text-sm font-semibold text-indigo-700 mb-8 shadow-sm">
                <span class="flex w-2.5 h-2.5 rounded-full bg-indigo-500 mr-2.5 animate-pulse"></span>
                SaaS Manajemen RT/RW Digital Terdepan
            </div>
            
            <h1 class="text-4xl md:text-6xl lg:text-[5rem] font-display font-extrabold tracking-tight mb-8 text-slate-900 leading-[1.15]">
                Harmoniskan Warga <br class="hidden md:block"/> Melalui <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-violet-600 to-indigo-600 bg-300% animate-gradient">Tata Kelola Modern</span>
            </h1>
            
            <p class="text-lg md:text-xl text-slate-500 mb-10 max-w-3xl mx-auto leading-relaxed">
                Tinggalkan pencatatan manual yang memusingkan. SB Digital menghadirkan transparansi iuran, database warga akurat, dan komunikasi satu pintu yang elegan.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 reveal delay-100">
                <a href="{{ route('register.tenant') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-2xl font-sans font-bold transition-all duration-300 bg-indigo-600 text-white hover:bg-indigo-700 hover:shadow-xl hover:shadow-indigo-500/30 hover:-translate-y-1 h-14 px-8 text-lg">
                    Daftarkan Perumahan
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
                <a href="#discuss" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-2xl font-sans font-bold transition-all duration-300 bg-white text-slate-700 hover:bg-slate-50 border border-slate-200 hover:border-slate-300 hover:shadow-md h-14 px-8 text-lg">
                    Jadwalkan Demo
                </a>
            </div>
            
            <!-- Dashboard Mockup Preview -->
            <div class="mt-20 mx-auto max-w-5xl relative reveal delay-200 perspective-1000">
                <div class="absolute inset-x-0 bottom-[-20%] h-1/2 bg-gradient-to-t from-slate-50 to-transparent z-10"></div>
                <div class="glass-panel rounded-t-3xl overflow-hidden border-b-0 shadow-2xl p-2 md:p-3 relative top-0 animate-float">
                    <!-- Fake Window Controls -->
                    <div class="h-6 flex items-center px-4 gap-2 mb-2">
                        <div class="w-3 h-3 rounded-full bg-slate-300 hover:bg-red-400 transition-colors"></div>
                        <div class="w-3 h-3 rounded-full bg-slate-300 hover:bg-yellow-400 transition-colors"></div>
                        <div class="w-3 h-3 rounded-full bg-slate-300 hover:bg-green-400 transition-colors"></div>
                    </div>
                    <!-- Fake Dashboard UI -->
                    <div class="bg-slate-50 rounded-2xl h-[300px] md:h-[450px] flex border border-slate-200 overflow-hidden shadow-inner relative">
                        <!-- Sidebar -->
                        <div class="w-16 md:w-56 bg-white border-r border-slate-200 p-4 flex flex-col gap-6 relative z-10">
                            <div class="w-8 md:w-28 h-6 bg-slate-200 rounded-lg mx-auto md:mx-0"></div>
                            <div class="space-y-3">
                                <div class="w-full h-10 md:h-10 bg-indigo-50/80 border border-indigo-100 rounded-xl"></div>
                                <div class="w-full h-10 md:h-10 bg-white hover:bg-slate-50 rounded-xl transition-colors border border-transparent"></div>
                                <div class="w-full h-10 md:h-10 bg-white hover:bg-slate-50 rounded-xl transition-colors border border-transparent"></div>
                            </div>
                        </div>
                        <!-- Content -->
                        <div class="flex-1 p-6 md:p-8 space-y-6 md:space-y-8 bg-slate-50 relative z-0">
                            <div class="flex justify-between items-center">
                                <div class="w-32 md:w-64 h-8 bg-slate-200 rounded-xl"></div>
                                <div class="w-10 h-10 rounded-full bg-indigo-100 border-2 border-white shadow-sm"></div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
                                <div class="h-24 md:h-32 bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex flex-col justify-between">
                                    <div class="w-10 h-10 bg-indigo-50 rounded-full"></div>
                                    <div class="w-16 h-6 bg-slate-100 rounded-lg"></div>
                                </div>
                                <div class="hidden md:flex h-32 bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex-col justify-between">
                                    <div class="w-10 h-10 bg-violet-50 rounded-full"></div>
                                    <div class="w-16 h-6 bg-slate-100 rounded-lg"></div>
                                </div>
                                <div class="hidden md:flex h-32 bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex-col justify-between">
                                    <div class="w-10 h-10 bg-emerald-50 rounded-full"></div>
                                    <div class="w-16 h-6 bg-slate-100 rounded-lg"></div>
                                </div>
                            </div>
                            
                            <div class="h-48 md:h-64 bg-white rounded-2xl border border-slate-200 shadow-sm p-6 hidden sm:block">
                                <div class="w-full h-4 bg-slate-100 rounded-full mb-4"></div>
                                <div class="w-3/4 h-4 bg-slate-100 rounded-full mb-4"></div>
                                <div class="w-5/6 h-4 bg-slate-100 rounded-full mb-4"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Client Section -->
    <section id="client" class="relative z-10 py-16 bg-white/40 border-y border-slate-200/50 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-4 text-center reveal">
            <p class="text-xs md:text-sm font-semibold text-slate-500 uppercase tracking-widest mb-10">Telah Dipercaya Oleh Puluhan Perumahan & RT</p>
            <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16 opacity-50 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-700">
                <h3 class="text-xl md:text-2xl font-display font-bold text-slate-800">Bukit Hijau<span class="text-indigo-500">.</span></h3>
                <h3 class="text-xl md:text-2xl font-display font-bold text-slate-800">Grand <span class="font-light">Residence</span></h3>
                <h3 class="text-xl md:text-2xl font-display font-bold text-slate-800"><span class="italic text-violet-600">Villa</span> Mutiara</h3>
                <h3 class="text-xl md:text-2xl font-display font-bold text-slate-800">Griya <span class="border-b-2 border-indigo-500">Asri</span></h3>
                <h3 class="text-xl md:text-2xl font-display font-bold text-slate-800 hidden sm:block">Harmoni <span class="text-emerald-500 font-serif">Park</span></h3>
            </div>
        </div>
    </section>

    <!-- 4. Layanan Section -->
    <section id="layanan" class="relative z-10 py-24 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center max-w-3xl mx-auto mb-16 reveal">
                <h2 class="text-3xl md:text-4xl font-display font-bold text-slate-900 mb-5">Modul Cerdas Lingkungan Anda</h2>
                <p class="text-lg text-slate-500">Arsitektur Multi-Tenant kami memisahkan data tiap perumahan secara ketat, menjamin privasi, kecepatan, dan kenyamanan paripurna.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                <!-- Fitur 1 -->
                <div class="glass-panel glass-card-hover rounded-3xl p-8 group reveal delay-100">
                    <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 group-hover:bg-indigo-600 group-hover:text-white shadow-sm border border-indigo-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <h3 class="text-xl font-display font-bold mb-3 text-slate-900">Database Warga Pintar</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Struktur pendataan warga terhubung langsung dengan denah/nomor rumah. Aman dan mudah dikelola oleh RT.</p>
                </div>
                
                <!-- Fitur 2 -->
                <div class="glass-panel glass-card-hover rounded-3xl p-8 group reveal delay-200">
                    <div class="w-14 h-14 bg-violet-50 text-violet-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 group-hover:bg-violet-600 group-hover:text-white shadow-sm border border-violet-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                    </div>
                    <h3 class="text-xl font-display font-bold mb-3 text-slate-900">Keuangan & Tagihan</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Lupakan nagih kas dari pintu ke pintu. Sistem tagihan otomatis mempermudah warga untuk membayar secara mandiri.</p>
                </div>
                
                <!-- Fitur 3 -->
                <div class="glass-panel glass-card-hover rounded-3xl p-8 group reveal delay-300">
                    <div class="w-14 h-14 bg-rose-50 text-rose-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 group-hover:bg-rose-500 group-hover:text-white shadow-sm border border-rose-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><line x1="10" x2="8" y1="9" y2="9"/></svg>
                    </div>
                    <h3 class="text-xl font-display font-bold mb-3 text-slate-900">Sentralisasi Informasi</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Distribusi pengumuman langsung tayang di beranda tiap warga. Terstruktur, rapi, tanpa tertumpuk chat obrolan panjang.</p>
                </div>

                <!-- Fitur 4 -->
                <div class="glass-panel glass-card-hover rounded-3xl p-8 group reveal delay-100">
                    <div class="w-14 h-14 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 group-hover:bg-emerald-500 group-hover:text-white shadow-sm border border-emerald-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l8.57-8.57A4 4 0 1 1 18 8.84l-8.59 8.57a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                    </div>
                    <h3 class="text-xl font-display font-bold mb-3 text-slate-900">E-Laporan Warga</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Fasilitas pelaporan fasilitas rusak, keamanan, atau aduan dengan sistem penelusuran status pengerjaan secara aktual.</p>
                </div>

                <!-- Fitur 5 -->
                <div class="glass-panel glass-card-hover rounded-3xl p-8 group reveal delay-200">
                    <div class="w-14 h-14 bg-amber-50 text-amber-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 group-hover:bg-amber-500 group-hover:text-white shadow-sm border border-amber-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 22v-4a2 2 0 1 0-4 0v4"/><path d="m18 10 4 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-8l4-2"/><path d="M18 5v17"/><path d="m4 6 8-4 8 4"/><path d="M6 5v17"/><circle cx="12" cy="9" r="2"/></svg>
                    </div>
                    <h3 class="text-xl font-display font-bold mb-3 text-slate-900">Isolasi Database</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Tiap perumahan menggunakan database fisik yang terpisah 100%, menghapus risiko kebocoran data antar-perumahan.</p>
                </div>

                <!-- Fitur 6 -->
                <div class="glass-panel glass-card-hover rounded-3xl p-8 group reveal delay-300">
                    <div class="w-14 h-14 bg-sky-50 text-sky-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 group-hover:bg-sky-500 group-hover:text-white shadow-sm border border-sky-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="m9 16 2 2 4-4"/></svg>
                    </div>
                    <h3 class="text-xl font-display font-bold mb-3 text-slate-900">Agenda & Polling Online</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Buat acara kerja bakti hingga ambil keputusan voting RT secara digital tanpa harus menunggu kuorum rapat offline.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. Pricing Section -->
    <section id="pricing" class="relative z-10 py-24 px-4 sm:px-6 lg:px-8 bg-slate-100/50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center max-w-3xl mx-auto mb-16 reveal">
                <h2 class="text-3xl md:text-4xl font-display font-bold text-slate-900 mb-5">Skala yang Berpihak Pada Anda</h2>
                <p class="text-lg text-slate-500">Mulai langkah digitalisasi tanpa risiko, dan tingkatkan daya komputasi saat populasi perumahan membesar.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Paket Dasar -->
                <div class="glass-panel rounded-3xl p-8 border border-slate-200 hover:shadow-lg transition-shadow reveal delay-100">
                    <h3 class="text-2xl font-display font-bold text-slate-900 mb-2">Klaster Mini</h3>
                    <p class="text-sm text-slate-500 mb-6">Paket perkenalan untuk satu lorong RT dengan skala sangat kecil.</p>
                    <div class="mb-6 flex items-baseline gap-2">
                        <span class="text-4xl font-extrabold text-slate-900">Gratis</span>
                        <span class="text-slate-500 font-medium">/ selamanya</span>
                    </div>
                    <ul class="space-y-4 mb-10 text-sm font-medium text-slate-600">
                        <li class="flex items-center gap-3"><div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg></div> Maksimal 20 Rumah</li>
                        <li class="flex items-center gap-3"><div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg></div> Modul Tagihan Iuran</li>
                        <li class="flex items-center gap-3 text-slate-400"><div class="w-5 h-5 rounded-full bg-slate-100 flex items-center justify-center"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg></div> Fitur Polling Dinonaktifkan</li>
                    </ul>
                    <a href="{{ route('register.tenant') }}" class="block w-full text-center py-3.5 rounded-xl border-2 border-slate-200 text-slate-700 font-bold hover:border-indigo-600 hover:text-indigo-600 transition-colors">Pilih Paket</a>
                </div>
                
                <!-- Paket Pro -->
                <div class="bg-white rounded-3xl p-8 border-2 border-indigo-500 relative transform md:-translate-y-4 shadow-2xl shadow-indigo-500/10 reveal delay-200">
                    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-indigo-600 text-white text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wider shadow-sm">
                        Rekomendasi RW
                    </div>
                    <h3 class="text-2xl font-display font-bold text-slate-900 mb-2">Bumi Standar</h3>
                    <p class="text-sm text-slate-500 mb-6">Pilihan paling rasional untuk rata-rata perumahan dan kepengurusan RW.</p>
                    <div class="mb-6 flex items-baseline gap-2">
                        <span class="text-4xl font-extrabold text-indigo-600">Rp49<span class="text-2xl">rb</span></span>
                        <span class="text-slate-500 font-medium">/ bulan</span>
                    </div>
                    <ul class="space-y-4 mb-10 text-sm font-medium text-slate-600">
                        <li class="flex items-center gap-3"><div class="w-5 h-5 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg></div> Hingga 300 Rumah</li>
                        <li class="flex items-center gap-3"><div class="w-5 h-5 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg></div> Akses Seluruh Modul Warga</li>
                        <li class="flex items-center gap-3"><div class="w-5 h-5 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg></div> Ekspor Laporan Keuangan</li>
                        <li class="flex items-center gap-3"><div class="w-5 h-5 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg></div> Database Fisik Terisolasi</li>
                    </ul>
                    <a href="{{ route('register.tenant') }}" class="block w-full text-center py-3.5 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/30 transition-all">Mulai Percobaan Gratis</a>
                </div>

                <!-- Paket Enterprise -->
                <div class="glass-panel rounded-3xl p-8 border border-slate-200 hover:shadow-lg transition-shadow reveal delay-300">
                    <h3 class="text-2xl font-display font-bold text-slate-900 mb-2">Grand Townhouse</h3>
                    <p class="text-sm text-slate-500 mb-6">Skala raksasa dengan fitur automasi ekstra dan pendampingan khusus.</p>
                    <div class="mb-6 flex items-baseline gap-2">
                        <span class="text-4xl font-extrabold text-slate-900">Custom</span>
                    </div>
                    <ul class="space-y-4 mb-10 text-sm font-medium text-slate-600">
                        <li class="flex items-center gap-3"><div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg></div> Tanpa Batas Rumah</li>
                        <li class="flex items-center gap-3"><div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg></div> Penyatuan Payment Gateway</li>
                        <li class="flex items-center gap-3"><div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg></div> Dedicated WhatsApp Support</li>
                    </ul>
                    <a href="#discuss" class="block w-full text-center py-3.5 rounded-xl border border-indigo-200 bg-indigo-50/50 text-indigo-700 font-bold hover:bg-indigo-100 transition-colors">Konsultasikan</a>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. Discuss / CTA Section -->
    <section id="discuss" class="relative z-10 py-24 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto bg-slate-900 rounded-[2.5rem] p-10 md:p-16 text-center border border-indigo-500/20 overflow-hidden relative shadow-2xl reveal">
            <!-- Decorative Glow inside dark box -->
            <div class="absolute top-[-50%] left-[-10%] w-[60%] h-[150%] bg-indigo-600/30 blur-[100px] rounded-full pointer-events-none"></div>
            <div class="absolute bottom-[-50%] right-[-10%] w-[60%] h-[150%] bg-violet-600/20 blur-[100px] rounded-full pointer-events-none"></div>
            
            <h2 class="text-3xl md:text-5xl font-display font-bold text-white mb-6 relative z-10">Revolusi Lingkungan Anda Dimulai Di Sini.</h2>
            <p class="text-lg md:text-xl text-indigo-100/80 mb-10 max-w-2xl mx-auto relative z-10 font-medium leading-relaxed">
                Bergabung dengan puluhan ketua RT cerdas lainnya yang telah beralih ke manajemen digital yang elegan, cepat, dan transparan.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4 relative z-10">
                <a href="{{ route('register.tenant') }}" class="inline-flex justify-center items-center px-8 py-4 rounded-xl text-indigo-900 bg-white hover:bg-indigo-50 font-bold transition-all hover:scale-105 shadow-lg shadow-white/10 text-lg">
                    Daftar Sekarang
                </a>
                <a href="mailto:halo@sbdigital.com" class="inline-flex justify-center items-center px-8 py-4 rounded-xl text-white bg-white/10 hover:bg-white/20 border border-white/20 font-bold transition-all backdrop-blur-md text-lg">
                    Hubungi Sales
                </a>
            </div>
        </div>
    </section>

    <!-- 7. Footer -->
    <footer class="relative z-10 border-t border-slate-200 bg-slate-50 pt-16 pb-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <div class="col-span-1 md:col-span-1">
                <img src="/assets/sb-digital-logo.svg" alt="SB Digital" class="h-8 w-auto mb-5 grayscale opacity-70">
                <p class="text-sm text-slate-500 font-medium leading-relaxed mb-4">
                    Mengubah wajah kepengurusan warga menjadi rapi, aman, dan tanpa stres melalui pendekatan SaaS eksklusif.
                </p>
            </div>
            <div>
                <h4 class="font-bold text-slate-900 mb-5 font-display tracking-wide">Produk</h4>
                <ul class="space-y-3 text-sm font-medium text-slate-500">
                    <li><a href="#layanan" class="hover:text-indigo-600 transition-colors">Fitur Utama</a></li>
                    <li><a href="#pricing" class="hover:text-indigo-600 transition-colors">Paket & Harga</a></li>
                    <li><a href="#" class="hover:text-indigo-600 transition-colors">Status Server</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-slate-900 mb-5 font-display tracking-wide">Perusahaan</h4>
                <ul class="space-y-3 text-sm font-medium text-slate-500">
                    <li><a href="#" class="hover:text-indigo-600 transition-colors">Tentang Tim</a></li>
                    <li><a href="#client" class="hover:text-indigo-600 transition-colors">Kisah Sukses</a></li>
                    <li><a href="#discuss" class="hover:text-indigo-600 transition-colors">Kontak Kami</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-slate-900 mb-5 font-display tracking-wide">Legalitas</h4>
                <ul class="space-y-3 text-sm font-medium text-slate-500">
                    <li><a href="#" class="hover:text-indigo-600 transition-colors">Syarat Penggunaan</a></li>
                    <li><a href="#" class="hover:text-indigo-600 transition-colors">Kebijakan Privasi</a></li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto border-t border-slate-200/60 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-sm font-semibold text-slate-400">&copy; {{ date('Y') }} SB Digital SaaS. All rights reserved.</p>
            <div class="flex gap-4">
                <!-- Social media icons -->
                <a href="#" class="w-9 h-9 rounded-full bg-slate-200/50 flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-colors">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                </a>
                <a href="#" class="w-9 h-9 rounded-full bg-slate-200/50 flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-colors">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                </a>
            </div>
        </div>
    </footer>

    <!-- Native Scroll Reveal Animation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.15
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.reveal').forEach(el => {
                observer.observe(el);
            });
            
            // Trigger immediately for elements already in view
            setTimeout(() => {
                document.querySelectorAll('.reveal').forEach(el => {
                    const rect = el.getBoundingClientRect();
                    if(rect.top < window.innerHeight) {
                        el.classList.add('active');
                    }
                });
            }, 100);
        });
    </script>
</body>
</html>
