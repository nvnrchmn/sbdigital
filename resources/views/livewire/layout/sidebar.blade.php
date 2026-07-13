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
        class="sm:hidden fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm"
    ></div>

    <!-- Sidebar (Desktop: Left Collapsible, Mobile: Right Offcanvas) -->
    <aside 
        :class="{ 
            'translate-x-0 shadow-2xl': mobileMenuOpen, 
            'translate-x-full': !mobileMenuOpen,
            'sm:w-64 sm:translate-x-0 sm:border-r': sidebarOpen,
            'sm:w-0 sm:border-none sm:overflow-hidden sm:px-0': !sidebarOpen
        }" 
        class="fixed inset-y-0 right-0 z-50 h-screen w-64 bg-white flex flex-col transition-all duration-300 ease-in-out sm:relative sm:z-auto sm:flex-shrink-0"
    >
        <!-- Header / Logo -->
        <div class="h-16 flex items-center px-6 border-b border-slate-200 justify-between sm:justify-start">
            <a href="{{ route('tenant.dashboard') }}" wire:navigate class="flex items-center gap-2 overflow-hidden whitespace-nowrap">
                <img src="/assets/sb-digital-logo.svg" alt="SB Digital Logo" class="h-8 w-auto">
            </a>
            <!-- Mobile Close Button -->
            <button @click="mobileMenuOpen = false" class="sm:hidden p-2 -mr-2 text-slate-400 hover:text-slate-600 rounded-lg bg-slate-50">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            @php
                $plan_id = tenant('plan_id');
                $features = [];
                if ($plan_id) {
                    $plan = \App\Models\Plan::find($plan_id);
                    if ($plan) {
                        $features = $plan->features ?? [];
                    }
                }
            @endphp

            <a href="{{ route('tenant.dashboard') }}" wire:navigate class="w-full flex items-center px-3 py-2 rounded-lg transition-colors whitespace-nowrap overflow-hidden {{ request()->routeIs('tenant.dashboard') ? 'bg-brand-indigo-50 text-brand-indigo-600 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                Dashboard
            </a>

            @if(in_array('warga', $features))
            <a href="{{ route('tenant.rumah') }}" wire:navigate class="w-full flex items-center px-3 py-2 rounded-lg transition-colors whitespace-nowrap overflow-hidden {{ request()->routeIs('tenant.rumah') ? 'bg-brand-indigo-50 text-brand-indigo-600 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Data Rumah
            </a>

            <a href="{{ route('tenant.warga') }}" wire:navigate class="w-full flex items-center px-3 py-2 rounded-lg transition-colors whitespace-nowrap overflow-hidden {{ request()->routeIs('tenant.warga') ? 'bg-brand-indigo-50 text-brand-indigo-600 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Data Warga
            </a>
            @endif

            @if(in_array('iuran', $features))
            <a href="{{ route('tenant.iuran') }}" wire:navigate class="w-full flex items-center px-3 py-2 rounded-lg transition-colors whitespace-nowrap overflow-hidden {{ request()->routeIs('tenant.iuran') ? 'bg-brand-indigo-50 text-brand-indigo-600 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                Data Iuran
            </a>
            @endif

            @if(in_array('laporan', $features))
            <a href="{{ route('tenant.laporan') }}" wire:navigate class="w-full flex items-center px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('tenant.laporan') ? 'bg-brand-indigo-50 text-brand-indigo-600 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><line x1="10" x2="8" y1="9" y2="9"/></svg>
                Laporan
            </a>
            @endif

            @if(in_array('lapak', $features))
            <a href="{{ route('tenant.lapak') }}" wire:navigate class="w-full flex items-center px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('tenant.lapak') ? 'bg-brand-indigo-50 text-brand-indigo-600 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                Lapak Warga
            </a>
            @endif

            @if(in_array('surat', $features))
            <a href="{{ route('tenant.surat') }}" wire:navigate class="w-full flex items-center px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('tenant.surat') ? 'bg-brand-indigo-50 text-brand-indigo-600 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
                Surat Pengantar
            </a>
            @endif

            @if(in_array('pengumuman', $features))
            <a href="{{ route('tenant.pengumuman') }}" wire:navigate class="w-full flex items-center px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('tenant.pengumuman') ? 'bg-brand-indigo-50 text-brand-indigo-600 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Pengumuman
            </a>
            @endif

            @if(in_array('keluhan', $features))
            <a href="{{ route('tenant.keluhan') }}" wire:navigate class="w-full flex items-center px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('tenant.keluhan') ? 'bg-brand-indigo-50 text-brand-indigo-600 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                Lapor RT
            </a>
            @endif

            @if(in_array('polling', $features))
            <a href="{{ route('tenant.polling') }}" wire:navigate class="w-full flex items-center px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('tenant.polling') ? 'bg-brand-indigo-50 text-brand-indigo-600 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3"><path d="M18 11V6a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v0"/><path d="M14 10V4a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v2"/><path d="M10 10.5V6a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v8"/><path d="M18 8a2 2 0 1 1 4 0v6a8 8 0 0 1-8 8h-2c-2.8 0-4.5-.86-5.99-2.34l-3.6-3.6a2 2 0 0 1 2.83-2.82L7 15"/></svg>
                Polling Warga
            </a>
            @endif

            @hasrole('Tenant Owner')
            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Pengaturan</p>
            </div>
            <a href="{{ route('tenant.langganan') }}" wire:navigate class="w-full flex items-center px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('tenant.langganan') ? 'bg-brand-indigo-50 text-brand-indigo-600 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                Langganan Paket
            </a>
            <a href="{{ route('tenant.role') }}" wire:navigate class="w-full flex items-center px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('tenant.role') ? 'bg-brand-indigo-50 text-brand-indigo-600 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                Manajemen Role
            </a>
            @endhasrole
        </nav>
    </aside>
</div>
