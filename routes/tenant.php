<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
])->group(function () {
    Route::get('/', function () {
        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    });

    // ROUTE SEMENTARA UNTUK TEST SETTING DI TENANT
    Route::get('/test-tenant-settings', function () {
        return [
            'tenant_id' => tenant('id'),
            'central_connection_config' => config('tenancy.database.central_connection'),
            'default_connection_config' => config('database.default'),
            'central_sub_account_id' => \App\Models\Setting::get('logikraf_central_sub_account_id', 'FALLBACK_NOT_FOUND'),
            'api_key' => substr(\App\Models\Setting::get('logikraf_api_key', 'NOT_FOUND'), 0, 10) . '...'
        ];
    });

    // ROUTE SEMENTARA UNTUK SIMULASI MASTER INVOICE DI TENANT
    Route::get('/test-tenant-subscribe', function () {
        $tenantId = tenant('id');
        $invoiceId = "INV-SUB-TTEST-" . time();
        $amount = 100000;
        $payerEmail = "nv.nrchmn@gmail.com";
        $description = "Langganan Paket Premium untuk Portal {$tenantId}";

        $logikraf = new \App\Services\LogikrafService();
        $invoice = $logikraf->createMasterInvoice($invoiceId, $tenantId, $amount, $payerEmail, $description);

        return [
            'tenant_id' => $tenantId,
            'invoice_id' => $invoiceId,
            'central_sub_account_id' => \App\Models\Setting::get('logikraf_central_sub_account_id'),
            'response' => $invoice,
            'all_subscriptions' => \App\Models\TenantSubscription::all()
        ];
    });

    Route::get('dashboard', \App\Livewire\Tenant\Dashboard::class)
        ->middleware(['auth', 'verified'])
        ->name('tenant.dashboard');

    Route::view('rumah', 'tenant.rumah')
        ->middleware(['auth', 'verified'])
        ->name('tenant.rumah');

    Route::view('warga', 'tenant.warga')
        ->middleware(['auth', 'verified'])
        ->name('tenant.warga');

    Route::view('iuran', 'tenant.iuran')
        ->middleware(['auth', 'verified'])
        ->name('tenant.iuran');

    Route::view('laporan', 'tenant.laporan')
        ->middleware(['auth', 'verified'])
        ->name('tenant.laporan');
        
    Route::view('lapak', 'tenant.lapak')
        ->middleware(['auth', 'verified'])
        ->name('tenant.lapak');

    Route::view('surat', 'tenant.surat')
        ->middleware(['auth', 'verified'])
        ->name('tenant.surat');

    Route::get('/surat/{id}/cetak', function ($id) {
        $surat = \App\Models\SuratPengantar::findOrFail($id);
        
        // Authorization
        $user = Illuminate\Support\Facades\Auth::user();
        $isPengurus = $user->can('approve surat') || $user->hasRole('Tenant Owner');
        
        if (!$isPengurus && $user->warga_id !== $surat->warga_id) {
            abort(403, 'Akses ditolak.');
        }

        if ($surat->status !== 'Disetujui') {
            abort(404, 'Surat belum disetujui.');
        }

        return view('tenant.surat.cetak', compact('surat'));
    })->middleware(['auth', 'verified'])->name('tenant.surat.cetak');

    Route::view('pengumuman', 'tenant.pengumuman')
        ->middleware(['auth', 'verified'])
        ->name('tenant.pengumuman');

    Route::view('keluhan', 'tenant.keluhan')
        ->middleware(['auth', 'verified'])
        ->name('tenant.keluhan');

    Route::view('polling', 'tenant.polling')
        ->middleware(['auth', 'verified'])
        ->name('tenant.polling');

    Route::get('/polling/{poll}', \App\Livewire\Tenant\Polling\Show::class)
        ->middleware(['auth', 'verified'])
        ->name('tenant.polling.show');

    Route::view('pengaturan', 'tenant.role')
        ->middleware(['auth', 'verified'])
        ->name('tenant.role');

    Route::view('langganan', 'tenant.langganan')
        ->middleware(['auth', 'verified'])
        ->name('tenant.langganan');

    Route::view('profile', 'profile')
        ->middleware(['auth'])
        ->name('tenant.profile');

    Route::name('tenant.')->group(function() {
        require __DIR__.'/auth.php';
    });
});
