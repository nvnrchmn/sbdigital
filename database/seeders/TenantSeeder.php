<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions
        $permissions = [
            'view warga', 'create warga', 'edit warga', 'delete warga', 'approve warga',
            'view rumah', 'create rumah', 'edit rumah', 'delete rumah',
            'view iuran', 'create iuran', 'edit iuran', 'delete iuran', 'approve iuran',
            'view laporan', 'create laporan', 'edit laporan', 'delete laporan', 'approve laporan',
            'view pengumuman', 'create pengumuman', 'edit pengumuman', 'delete pengumuman',
            'view lapak', 'create lapak', 'edit lapak', 'delete lapak',
            'view surat', 'create surat', 'edit surat', 'delete surat', 'approve surat',
            'view keluhan', 'create keluhan', 'edit keluhan', 'delete keluhan', 'process keluhan',
            'view polling', 'vote polling', 'manage polling',
            'manage roles', 'manage settings'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Roles
        $roles = [
            'Tenant Owner', 'Ketua RT', 'Wakil Ketua', 'Sekretaris', 'Bendahara', 'Satpam', 'Warga'
        ];

        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            
            // By default, give Tenant Owner all permissions
            if ($roleName === 'Tenant Owner') {
                $role->givePermissionTo(Permission::all());
            }
        }
    }
}
