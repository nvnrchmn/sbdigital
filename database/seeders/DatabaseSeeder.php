<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Pastikan role Super Admin dibuat di database pusat
        $superAdminRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);

        $admin = User::firstOrCreate(
            ['email' => 'admin@sbdigital.biz.id'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        // Panggil seeder lainnya (hanya untuk database sentral)
        $this->call([
            PlanSeeder::class,
        ]);
    }
}
