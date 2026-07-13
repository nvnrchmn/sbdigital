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
        Schema::create('tenant_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perumahan');
            $table->string('tenant_id')->unique();
            $table->string('admin_name');
            $table->string('admin_email');
            $table->string('admin_password');
            $table->string('token', 64)->unique();
            $table->enum('status', ['pending', 'verified'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_registrations');
    }
};
