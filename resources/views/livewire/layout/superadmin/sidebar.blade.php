<?php

use Livewire\Volt\Component;

new class extends Component
{
    //
}; ?>

<div>
    <!-- Mobile Backdrop Overlay -->
    <div 
        x-show="mobileMenuOpen" 
        x-transition.opacity 
        @click="mobileMenuOpen = false" 
        class="sm:hidden fixed inset-0 z-40 bg-slate-900/80 backdrop-blur-sm"
    ></div>

    <!-- Sidebar (Desktop: Left Collapsible, Mobile: Right Offcanvas) -->
    <aside 
        :class="{ 
            'translate-x-0 shadow-2xl': mobileMenuOpen, 
            'translate-x-full': !mobileMenuOpen,
            'sm:w-64 sm:translate-x-0 sm:border-r': sidebarOpen,
            'sm:w-0 sm:border-none sm:overflow-hidden sm:px-0': !sidebarOpen
        }" 
        class="fixed inset-y-0 right-0 z-50 h-screen w-64 bg-slate-900 border-slate-800 flex flex-col transition-all duration-300 ease-in-out sm:relative sm:z-auto sm:flex-shrink-0"
    >
        <!-- Header / Logo -->
        <div class="h-16 flex items-center px-6 border-b border-slate-800 justify-between sm:justify-start">
            <a href="{{ route('superadmin.dashboard') }}" wire:navigate class="flex items-center gap-2 overflow-hidden whitespace-nowrap">
                <img src="/assets/sb-digital-logo.svg" alt="SB Digital Logo" class="h-8 w-auto brightness-0 invert">
            </a>
            <!-- Mobile Close Button -->
            <button @click="mobileMenuOpen = false" class="sm:hidden p-2 -mr-2 text-slate-400 hover:text-slate-200 rounded-lg bg-slate-800">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            <div class="pt-2 pb-2">
                <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Superadmin Panel</p>
            </div>

            <a href="{{ route('superadmin.dashboard') }}" wire:navigate class="w-full flex items-center px-3 py-2.5 rounded-lg transition-colors whitespace-nowrap overflow-hidden {{ request()->routeIs('superadmin.dashboard') ? 'bg-indigo-600/10 text-indigo-400 font-semibold border border-indigo-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200 font-medium border border-transparent' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3 {{ request()->routeIs('superadmin.dashboard') ? 'text-indigo-400' : 'text-slate-500' }}"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                Dashboard
            </a>

            <a href="{{ route('superadmin.tenants.index') }}" wire:navigate class="w-full flex items-center px-3 py-2.5 rounded-lg transition-colors whitespace-nowrap overflow-hidden {{ request()->routeIs('superadmin.tenants.*') ? 'bg-indigo-600/10 text-indigo-400 font-semibold border border-indigo-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200 font-medium border border-transparent' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3 {{ request()->routeIs('superadmin.tenants.*') ? 'text-indigo-400' : 'text-slate-500' }}"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                Manajemen Tenant
            </a>

            <a href="{{ route('superadmin.plans.index') }}" wire:navigate class="w-full flex items-center px-3 py-2.5 rounded-lg transition-colors whitespace-nowrap overflow-hidden {{ request()->routeIs('superadmin.plans.*') ? 'bg-indigo-600/10 text-indigo-400 font-semibold border border-indigo-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200 font-medium border border-transparent' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3 {{ request()->routeIs('superadmin.plans.*') ? 'text-indigo-400' : 'text-slate-500' }}"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                Paket & Limitasi
            </a>

            <a href="{{ route('superadmin.announcements.index') }}" wire:navigate class="w-full flex items-center px-3 py-2.5 rounded-lg transition-colors whitespace-nowrap overflow-hidden {{ request()->routeIs('superadmin.announcements.*') ? 'bg-indigo-600/10 text-indigo-400 font-semibold border border-indigo-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200 font-medium border border-transparent' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3 {{ request()->routeIs('superadmin.announcements.*') ? 'text-indigo-400' : 'text-slate-500' }}"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Siaran Global
            </a>

            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Sistem</p>
            </div>

            <a href="{{ route('superadmin.settings.index') }}" wire:navigate class="w-full flex items-center px-3 py-2.5 rounded-lg transition-colors whitespace-nowrap overflow-hidden {{ request()->routeIs('superadmin.settings.*') ? 'bg-indigo-600/10 text-indigo-400 font-semibold border border-indigo-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200 font-medium border border-transparent' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3 {{ request()->routeIs('superadmin.settings.*') ? 'text-indigo-400' : 'text-slate-500' }}"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                Pengaturan
            </a>
        </nav>
    </aside>
</div>
