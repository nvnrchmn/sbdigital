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

    Route::view('dashboard', 'dashboard')
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
