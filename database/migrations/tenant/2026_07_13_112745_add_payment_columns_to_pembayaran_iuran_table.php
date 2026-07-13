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
        Schema::table('pembayaran_iuran', function (Blueprint $table) {
            $table->string('external_id')->nullable()->after('status');
            $table->string('checkout_url')->nullable()->after('external_id');
            $table->timestamp('paid_at')->nullable()->after('checkout_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayaran_iuran', function (Blueprint $table) {
            //
        });
    }
};
