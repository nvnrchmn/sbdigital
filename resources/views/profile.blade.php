<x-dynamic-component :component="tenant('id') ? 'app-layout' : 'superadmin-layout'">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-6 sm:p-8 bg-white/60 backdrop-blur-xl shadow-sm border border-white/40 sm:rounded-2xl relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-8 opacity-5 transition-opacity group-hover:opacity-10 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-indigo-600"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <div class="max-w-xl relative z-10">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white/60 backdrop-blur-xl shadow-sm border border-white/40 sm:rounded-2xl relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-8 opacity-5 transition-opacity group-hover:opacity-10 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-600"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
                <div class="max-w-xl relative z-10">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white/60 backdrop-blur-xl shadow-sm border border-rose-100 sm:rounded-2xl relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-8 opacity-5 transition-opacity group-hover:opacity-10 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-rose-600"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                </div>
                <div class="max-w-xl relative z-10">
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</x-dynamic-component>
