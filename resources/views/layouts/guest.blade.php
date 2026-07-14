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
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased bg-slate-50 relative overflow-x-hidden min-h-screen">
        <!-- Background Elements -->
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-indigo-500/20 blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-purple-500/20 blur-[120px] pointer-events-none"></div>
        
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-10 p-4">
            <div class="mb-8">
                <a href="/" wire:navigate>
                    <img src="/assets/sb-digital-logo.svg" alt="SB Digital Logo" class="h-12 w-auto">
                </a>
            </div>

            <div class="w-full {{ $maxWidth ?? 'sm:max-w-md' }} bg-white/60 backdrop-blur-xl border border-white/40 shadow-xl overflow-hidden sm:rounded-3xl p-8 transition-all duration-300">
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-center text-xs text-slate-500">
                &copy; {{ date('Y') }} SB Digital by Logikraf. All rights reserved.
            </div>
        </div>

        <x-sweetalert />
    </body>
</html>
