<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        if (tenant()) {
            $this->redirect(route('tenant.login'), navigate: true);
        } else {
            $this->redirect('/', navigate: true);
        }
    }
}; ?>

<nav class="bg-white/90 backdrop-blur-md border-b border-slate-200 sticky top-0 z-20">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            
            <!-- Left Side (Sidebar Toggle / Title) -->
            <div class="flex items-center gap-4">
                <!-- Desktop Sidebar Toggle -->
                <button @click="sidebarOpen = !sidebarOpen" class="hidden sm:inline-flex items-center justify-center p-2 rounded-lg text-slate-500 hover:text-slate-700 hover:bg-slate-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <!-- Hamburger icon -->
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                
                <div class="hidden sm:block">
                    <span class="text-sm font-semibold text-slate-500 uppercase tracking-wide">
                        {{ tenant('id') ? 'Tenant: ' . tenant('id') : 'Central Dashboard' }}
                    </span>
                </div>
                
                <!-- Mobile Logo / Title -->
                <div class="sm:hidden flex items-center">
                    <img src="/assets/sb-digital-logo.svg" alt="SB Digital" class="h-6 w-auto grayscale opacity-70">
                </div>
            </div>

            <!-- Right Side (Profile Dropdown) -->
            <div class="flex items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-slate-700 bg-transparent hover:text-brand-indigo-600 focus:outline-none transition ease-in-out duration-150">
                            <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @if(tenant('id'))
                            <x-dropdown-link :href="route('tenant.profile', ['tenant' => tenant('id')])" wire:navigate>
                                {{ __('Profile') }}
                            </x-dropdown-link>
                        @else
                            <x-dropdown-link :href="route('profile')" wire:navigate>
                                {{ __('Profile') }}
                            </x-dropdown-link>
                        @endif

                        <!-- Authentication -->
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>
