<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
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

Route::middleware(['web'])->group(function () {
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
            'api_key' => substr(\App\Models\Setting::get('logikraf_api_key', 'NOT_FOUND'), 0, 10) . '...',
        ];
    });

    // ROUTE SEMENTARA UNTUK SIMULASI MASTER INVOICE DI TENANT
    Route::get('/test-tenant-subscribe', function () {
        $tenantId = tenant('id');
        $invoiceId = 'INV-SUB-TTEST-' . time();
        $amount = 100000;
        $payerEmail = 'nv.nrchmn@gmail.com';
        $description = "Langganan Paket Premium untuk Portal {$tenantId}";

        $logikraf = new \App\Services\LogikrafService();
        $invoice = $logikraf->createMasterInvoice($invoiceId, $tenantId, $amount, $payerEmail, $description);

        return [
            'tenant_id' => $tenantId,
            'invoice_id' => $invoiceId,
            'central_sub_account_id' => \App\Models\Setting::get('logikraf_central_sub_account_id'),
            'response' => $invoice,
            'all_subscriptions' => \App\Models\TenantSubscription::all(),
        ];
    });

    // ROUTE SEMENTARA UNTUK MEMBERSIHKAN TAGIHAN GAGAL
    Route::get('/clean-subscriptions', function () {
        \App\Models\TenantSubscription::where('status', 'Pending')->delete();
        return 'Berhasil menghapus seluruh tagihan Pending yang gagal. Silakan buka halaman langganan tenant Anda kembali.';
    });

    // ROUTE SEMENTARA: Fix permissions untuk tenant yang sudah ada
    Route::get('/fix-permissions', function () {
        try {
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
            \Database\Seeders\TenantSeeder::run();
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
            return 'Permissions berhasil diperbaiki! Silakan coba CRUD di UI.';
        } catch (\Exception $e) {
            return 'Gagal: ' . $e->getMessage();
        }
    })
        ->middleware(['auth', 'verified', 'role:Tenant Owner'])
        ->name('fix.permissions');

    // FIX (Alur Approval Registrasi Mandiri): halaman ini SENGAJA tidak dipasangi
    // middleware 'warga.approved' -- kalau dipasang, warga yang pending akan
    // di-redirect balik ke sini terus menerus (infinite redirect loop).
    Volt::route('menunggu-persetujuan', 'pages.tenant.pending-approval')
        ->middleware(['auth', 'verified'])
        ->name('tenant.pending-approval');

    // Semua modul di bawah ini butuh: login -> email terverifikasi -> akun disetujui pengurus.
    Route::middleware(['auth', 'verified', 'warga.approved'])->group(function () {
        Route::get('dashboard', \App\Livewire\Tenant\Dashboard::class)
            ->name('tenant.dashboard');

        Route::view('rumah', 'tenant.rumah')
            ->name('tenant.rumah');

        Route::view('warga', 'tenant.warga')
            ->name('tenant.warga');

        Route::view('iuran', 'tenant.iuran')
            ->name('tenant.iuran');

        Route::view('laporan', 'tenant.laporan')
            ->name('tenant.laporan');

        Route::view('lapak', 'tenant.lapak')
            ->name('tenant.lapak');

        Route::view('surat', 'tenant.surat')
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
        })
            ->name('tenant.surat.cetak');

        Route::view('pengumuman', 'tenant.pengumuman')
            ->name('tenant.pengumuman');

        Route::view('keluhan', 'tenant.keluhan')
            ->name('tenant.keluhan');

        Route::view('polling', 'tenant.polling')
            ->name('tenant.polling');

        Route::get('/polling/{poll}', \App\Livewire\Tenant\Polling\Show::class)
            ->name('tenant.polling.show');

        Route::view('pengaturan', 'tenant.role')
            ->name('tenant.role');

        Route::view('langganan', 'tenant.langganan')
            ->name('tenant.langganan');
    });

    // FIX: profile SENGAJA tidak dipasangi 'warga.approved' supaya warga yang
    // masih pending tetap bisa melihat/mengedit profilnya sendiri sambil menunggu.
    Route::view('profile', 'profile')
        ->middleware(['auth'])
        ->name('tenant.profile');

    Route::name('tenant.')->group(function () {
        require __DIR__ . '/auth.php';
    });
});
