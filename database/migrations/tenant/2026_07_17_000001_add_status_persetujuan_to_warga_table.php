<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * PENTING: migration ini untuk database TENANT, bukan central.
     * Jalankan dengan: php artisan tenants:migrate
     * (JANGAN pakai `php artisan migrate` biasa, itu hanya akan menyentuh database central)
     *
     * FIX (Alur Approval Registrasi Mandiri):
     * Warga yang daftar sendiri lewat halaman registrasi (bukan diinput manual oleh
     * Tenant Owner/pengurus lewat modul Warga) sekarang berstatus 'pending' dulu,
     * dan baru bisa memakai aplikasi setelah disetujui oleh pengurus (lihat
     * App\Http\Middleware\EnsureWargaIsApproved).
     *
     * Data warga yang diinput manual oleh pengurus lewat modul Warga (Tenant\Warga\Form)
     * otomatis dianggap 'disetujui' (default kolom ini di-override di Form.php),
     * karena sudah melalui verifikasi pengurus saat penginputan.
     */
    public function up(): void
    {
        Schema::table('warga', function (Blueprint $table) {
            $table->enum('status_persetujuan', ['pending', 'disetujui', 'ditolak'])
                ->default('disetujui')
                ->after('status_warga');
        });
    }

    public function down(): void
    {
        Schema::table('warga', function (Blueprint $table) {
            $table->dropColumn('status_persetujuan');
        });
    }
};
