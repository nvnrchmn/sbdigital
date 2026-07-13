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
        Schema::create('pembayaran_iuran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_rumah')->constrained('rumah')->cascadeOnDelete();
            $table->foreignId('warga_id')->nullable()->constrained('warga')->nullOnDelete();
            $table->integer('bulan');
            $table->integer('tahun');
            $table->decimal('nominal', 10, 2);
            $table->enum('status', ['Pending', 'Lunas', 'Ditolak'])->default('Pending');
            $table->string('payment_method')->nullable();
            $table->string('payment_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_iuran');
    }
};
