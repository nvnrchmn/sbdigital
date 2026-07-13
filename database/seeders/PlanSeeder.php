<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Plan::create([
            'name' => 'Basic (Gratis)',
            'description' => 'Paket dasar gratis untuk perumahan kecil (maksimal 50 rumah).',
            'price' => 0,
            'billing_cycle' => 'monthly',
            'max_houses' => 50,
            'features' => ['pengumuman'], // hanya bisa pakai fitur pengumuman, tidak bisa laporan
        ]);

        \App\Models\Plan::create([
            'name' => 'Premium',
            'description' => 'Paket lengkap tanpa batasan fitur untuk manajemen perumahan.',
            'price' => 100000,
            'billing_cycle' => 'monthly',
            'max_houses' => 500,
            'features' => ['pengumuman', 'iuran', 'laporan', 'warga', 'lapak', 'surat', 'keluhan', 'polling'], // fitur lengkap
        ]);
    }
}
