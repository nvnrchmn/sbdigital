<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Superadmin | {{ config('app.name', 'SB Digital') }}</title>

        <!-- Favicon -->
        <link rel="icon" href="/assets/sb-digital-icon.ico" type="image/x-icon">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&family=Plus+Jakarta+Sans:wght@400;500;600&family=Poppins:wght@700;800&display=swap" rel="stylesheet">

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-900 bg-slate-900 flex h-screen overflow-hidden selection:bg-indigo-500/30 selection:text-indigo-200" x-data="{ sidebarOpen: true, mobileMenuOpen: false }">
        
        <!-- Sidebar Component -->
        <livewire:layout.superadmin.sidebar />

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-slate-50 rounded-none sm:rounded-tl-3xl shadow-[0_0_40px_rgba(0,0,0,0.1)] border-none sm:border-l sm:border-t sm:border-slate-200/50 relative z-10">
            
            <!-- Top Navigation Component -->
            <livewire:layout.navigation />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white/80 backdrop-blur-md border-b border-slate-200 z-10 sticky top-0">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4 pb-24 sm:pb-6 sm:p-6 lg:p-8 bg-slate-50/50">
                {{ $slot }}
            </main>

            <!-- Mobile Bottom Navigation (Superadmin) -->
            <div class="sm:hidden fixed bottom-0 inset-x-0 bg-slate-900 border-t border-slate-800 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] z-40 px-6 py-2 pb-safe">
                <div class="flex justify-between items-center">
                    <!-- Dashboard -->
                    <a href="{{ route('superadmin.dashboard') }}" wire:navigate class="flex flex-col items-center p-2 {{ request()->routeIs('superadmin.dashboard') ? 'text-indigo-400' : 'text-slate-500 hover:text-slate-300' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-1"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                        <span class="text-[10px] font-semibold">Dashboard</span>
                    </a>

                    <!-- Tenants -->
                    <a href="{{ route('superadmin.tenants.index') }}" wire:navigate class="flex flex-col items-center p-2 {{ request()->routeIs('superadmin.tenants.*') ? 'text-indigo-400' : 'text-slate-500 hover:text-slate-300' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-1"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span class="text-[10px] font-semibold">Tenants</span>
                    </a>

                    <!-- Menu / Lainnya -->
                    <button @click="mobileMenuOpen = true" class="flex flex-col items-center p-2 text-slate-500 hover:text-slate-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-1"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
                        <span class="text-[10px] font-semibold">Lainnya</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- SweetAlert2 Initialization -->
        <script>
            document.addEventListener('livewire:initialized', () => {
                Livewire.on('swal:modal', (data) => {
                    Swal.fire({
                        title: data[0].title,
                        text: data[0].text,
                        icon: data[0].icon,
                        confirmButtonColor: '#4f46e5',
                    });
                });

                Livewire.on('notify', (data) => {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: data[0].icon || 'success',
                        title: data[0].message,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                });

                Livewire.on('swal:confirm', (data) => {
                    Swal.fire({
                        title: data[0].title,
                        text: data[0].text,
                        icon: data[0].icon ?? 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#94a3b8',
                        confirmButtonText: data[0].confirmText ?? 'Ya, Hapus!',
                        cancelButtonText: data[0].cancelText ?? 'Batal',
                        customClass: {
                            popup: 'rounded-2xl',
                            confirmButton: 'rounded-xl',
                            cancelButton: 'rounded-xl'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.dispatch(data[0].action, data[0].params ?? {});
                        }
                    });
                });
            });
        </script>
    </body>
</html>
