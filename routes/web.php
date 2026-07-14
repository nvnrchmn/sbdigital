<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::get('/register-tenant', \App\Livewire\Central\RegisterTenant::class)->name('register.tenant');
Route::get('/verify-tenant/{token}', \App\Livewire\Central\VerifyTenant::class)->name('tenant.verify');
Route::get('/cari-portal', \App\Livewire\Central\FindPortal::class)->name('find-portal');

// ROUTE SEMENTARA UNTUK SETUP LOGIKRAF
Route::get('/setup-logikraf-central', function () {
    $logikraf = new \App\Services\LogikrafService();
    $response = $logikraf->createSubAccount('SBDIGITAL-CENTRAL', 'Kas Utama SBDigital', 'admin@sbdigital.biz.id');
    
    if ($response && isset($response['data']['external_reference_id'])) {
        $centralId = $response['data']['external_reference_id'];
        \App\Models\Setting::set('logikraf_central_sub_account_id', $centralId);
        return "Berhasil mendaftar! ID Sub-Akun Sentral Anda: {$centralId}. Silakan tutup tab ini dan tes langganan lagi.";
    } elseif (isset($response['message']) && strpos(strtolower($response['message']), 'already exists') !== false) {
        $centralId = 'SBDIGITAL-CENTRAL';
        \App\Models\Setting::set('logikraf_central_sub_account_id', $centralId);
        return "Sub-Akun Sentral sudah terdaftar sebelumnya. ID {$centralId} disimpan ke database. Silakan tutup tab ini dan tes langganan lagi.";
    } else {
        return "Gagal: " . json_encode($response);
    }
});
Route::middleware(['auth', 'verified', 'role:Super Admin'])->prefix('superadmin')->group(function () {
    Route::get('/dashboard', \App\Livewire\Central\Dashboard\Index::class)->name('superadmin.dashboard');
    Route::get('/up', function () {
    return app()->isDownForMaintenance() ? response('Maintenance', 503) : response('OK', 200);
});

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
