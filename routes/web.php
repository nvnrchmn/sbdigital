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
        return 'Gagal: ' . json_encode($response);
    }
});

// ROUTE SEMENTARA UNTUK TEST MASTER INVOICE
Route::get('/test-master-invoice', function () {
    $logikraf = new \App\Services\LogikrafService();
    $invoiceId = 'INV-SUB-DEBUG-' . time();
    $tenantId = 'sheika';
    $amount = 100000;
    $payerEmail = 'admin@sbdigital.biz.id';
    $description = 'Test Master Invoice Debugging';

    $response = $logikraf->createMasterInvoice($invoiceId, $tenantId, $amount, $payerEmail, $description);

    return [
        'central_sub_account_id_setting' => \App\Models\Setting::get('logikraf_central_sub_account_id'),
        'api_key' => substr(\App\Models\Setting::get('logikraf_api_key'), 0, 15) . '...',
        'response' => $response,
    ];
});
Route::middleware(['auth', 'verified', 'role:Super Admin'])
    ->prefix('superadmin')
    ->group(function () {
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

// ROUTE SEMENTARA: Jalankan TenantSeeder untuk tenant yang sudah ada (fix permission)
Route::get('/fix-tenant-permissions/{tenant?}', function ($tenant = null) {
    try {
        // Reset permission cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $tenantId = $tenant ?: tenant('id');
        $tenantModel = \App\Models\Tenant::find($tenantId);

        if (!$tenantModel) {
            return 'Tenant tidak ditemukan.';
        }

        $tenantModel->run(function () {
            \Database\Seeders\TenantSeeder::run();
        });

        return "TenantSeeder berhasil dijalankan untuk tenant: {$tenantId}. Silakan coba CRUD di UI kembali.";
    } catch (\Exception $e) {
        return 'Gagal: ' . $e->getMessage();
    }
})
    ->middleware(['auth', 'verified'])
    ->name('fix.tenant.permissions');

require __DIR__ . '/auth.php';
