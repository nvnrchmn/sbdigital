<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SB Digital') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="/assets/sb-digital-icon.ico" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&family=Plus+Jakarta+Sans:wght@400;500;600&family=Poppins:wght@700;800&display=swap"
        rel="stylesheet">


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-slate-900 bg-slate-50 flex h-screen overflow-hidden" x-data="{ sidebarOpen: true, mobileMenuOpen: false }">

    <!-- Sidebar Component -->
    <livewire:layout.sidebar />

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden relative">

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

        <!-- Page Content (add pb-20 on mobile to clear bottom nav) -->
        <main class="flex-1 overflow-y-auto bg-slate-50 p-4 pb-24 sm:pb-8 sm:p-6 lg:p-8">
            {{ $slot }}
        </main>

        <!-- Mobile Bottom Navigation -->
        @php
            $plan_id = tenant('plan_id');
            $features = [];
            if ($plan_id) {
                $plan = \App\Models\Plan::find($plan_id);
                if ($plan) {
                    $features = $plan->features ?? [];
                }
            }

            $hasIuran = in_array('iuran', $features);
        @endphp
        <div
            class="sm:hidden fixed bottom-0 inset-x-0 bg-white border-t border-slate-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] z-40 px-6 py-2 pb-safe">
            <div class="flex justify-between items-center">
                <!-- Home -->
                <a href="{{ route('tenant.dashboard') }}" wire:navigate
                    class="flex flex-col items-center p-2 {{ request()->routeIs('tenant.dashboard') ? 'text-indigo-600' : 'text-slate-500 hover:text-slate-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="mb-1">
                        <rect width="7" height="9" x="3" y="3" rx="1" />
                        <rect width="7" height="5" x="14" y="3" rx="1" />
                        <rect width="7" height="9" x="14" y="12" rx="1" />
                        <rect width="7" height="5" x="3" y="16" rx="1" />
                    </svg>
                    <span class="text-[10px] font-semibold">Home</span>
                </a>

                <!-- Iuran / Warga -->
                @if ($hasIuran)
                    <a href="{{ route('tenant.iuran') }}" wire:navigate
                        class="flex flex-col items-center p-2 {{ request()->routeIs('tenant.iuran') ? 'text-indigo-600' : 'text-slate-500 hover:text-slate-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="mb-1">
                            <rect width="20" height="14" x="2" y="5" rx="2" />
                            <line x1="2" x2="22" y1="10" y2="10" />
                        </svg>
                        <span class="text-[10px] font-semibold">Iuran</span>
                    </a>
                @else
                    <a href="{{ route('tenant.warga') }}" wire:navigate
                        class="flex flex-col items-center p-2 {{ request()->routeIs('tenant.warga') ? 'text-indigo-600' : 'text-slate-500 hover:text-slate-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="mb-1">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                        <span class="text-[10px] font-semibold">Warga</span>
                    </a>
                @endif

                <!-- Menu / Lainnya -->
                <button @click="mobileMenuOpen = true"
                    class="flex flex-col items-center p-2 text-slate-500 hover:text-slate-900">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="mb-1">
                        <line x1="4" x2="20" y1="12" y2="12" />
                        <line x1="4" x2="20" y1="6" y2="6" />
                        <line x1="4" x2="20" y1="18" y2="18" />
                    </svg>
                    <span class="text-[10px] font-semibold">Lainnya</span>
                </button>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 Component -->
    <x-sweetalert />

    <!-- Dynamic Modal (mounts the Livewire component requested via $dispatch('open-modal', ...)) -->
    <livewire:dynamic-modal />

    @stack('scripts')
</body>

</html>
