<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::get('/register-tenant', \App\Livewire\Central\RegisterTenant::class)->name('register.tenant');
Route::get('/verify-tenant/{token}', \App\Livewire\Central\VerifyTenant::class)->name('tenant.verify');
Route::get('/cari-portal', \App\Livewire\Central\FindPortal::class)->name('find-portal');
Route::middleware(['auth', 'verified', 'role:Super Admin'])->prefix('superadmin')->group(function () {
    Route::get('/dashboard', \App\Livewire\Central\Dashboard\Index::class)->name('superadmin.dashboard');
    Route::get('/tenants', \App\Livewire\Central\Tenant\Index::class)->name('superadmin.tenants.index');
    Route::get('/tenants/create', \App\Livewire\Central\Tenant\Form::class)->name('superadmin.tenants.create');
    Route::get('/tenants/{tenant}/edit', \App\Livewire\Central\Tenant\Form::class)->name('superadmin.tenants.edit');

    Route::get('/plans', \App\Livewire\Central\Plan\Index::class)->name('superadmin.plans.index');
    Route::get('/plans/create', \App\Livewire\Central\Plan\Form::class)->name('superadmin.plans.create');
    Route::get('/plans/{plan}/edit', \App\Livewire\Central\Plan\Form::class)->name('superadmin.plans.edit');

    Route::get('/announcements', \App\Livewire\Central\Announcement\Index::class)->name('superadmin.announcements.index');
    Route::get('/announcements/create', \App\Livewire\Central\Announcement\Form::class)->name('superadmin.announcements.create');
    Route::get('/announcements/{announcement}/edit', \App\Livewire\Central\Announcement\Form::class)->name('superadmin.announcements.edit');
    
    Route::get('/settings', \App\Livewire\Central\Settings\Index::class)->name('superadmin.settings.index');

    Route::view('/profile', 'profile')->name('profile');
});

Route::post('/webhook/logikraf', [\App\Http\Controllers\LogikrafWebhookController::class, 'handle']);

require __DIR__.'/auth.php';
