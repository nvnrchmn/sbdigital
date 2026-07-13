<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surat_pengantars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warga_id')->constrained('warga')->onDelete('cascade');
            $table->string('jenis_surat');
            $table->text('keperluan');
            $table->string('status')->default('Menunggu'); // Menunggu, Disetujui, Ditolak
            $table->string('nomor_surat')->nullable();
            $table->text('keterangan_admin')->nullable();
            $table->timestamp('tanggal_disetujui')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_pengantars');
    }
};
