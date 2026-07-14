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
     */
    public function up(): void
    {
        Schema::table('warga', function (Blueprint $table) {
            $table->string('nik_hash', 64)->nullable()->after('nik');
        });

        // Unique index dibuat terpisah (bukan inline) supaya migration tidak gagal
        // kalau ada duplikat nik_hash NULL sementara sebelum backfill dijalankan.
        Schema::table('warga', function (Blueprint $table) {
            $table->unique('nik_hash', 'warga_nik_hash_unique');
        });
    }

    public function down(): void
    {
        Schema::table('warga', function (Blueprint $table) {
            $table->dropUnique('warga_nik_hash_unique');
            $table->dropColumn('nik_hash');
        });
    }
};
