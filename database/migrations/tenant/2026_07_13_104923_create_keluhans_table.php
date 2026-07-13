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
        Schema::create('keluhans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warga_id')->constrained('warga')->onDelete('cascade');
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('kategori'); // Fasilitas Umum, Keamanan, Kebersihan, Sosial, Lain-lain
            $table->string('lokasi')->nullable();
            $table->string('foto')->nullable();
            $table->string('status')->default('Menunggu'); // Menunggu, Diproses, Selesai, Ditolak
            $table->text('tanggapan_admin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keluhans');
    }
};
