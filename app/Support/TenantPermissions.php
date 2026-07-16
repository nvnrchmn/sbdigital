<?php

namespace App\Support;

use App\Models\User;

class TenantPermissions
{
    public const PENGURUS = ['Tenant Owner', 'Ketua RT', 'Wakil Ketua', 'Sekretaris'];
    public const KEUANGAN = ['Tenant Owner', 'Ketua RT', 'Bendahara'];
    public const LAPORAN = ['Tenant Owner', 'Ketua RT', 'Sekretaris'];
    public const SURAT = ['Tenant Owner', 'Ketua RT', 'Wakil Ketua', 'Sekretaris'];
    public const KELUHAN = ['Tenant Owner', 'Ketua RT', 'Wakil Ketua', 'Sekretaris', 'Satpam'];
    public const POLLING = ['Tenant Owner', 'Ketua RT', 'Wakil Ketua', 'Sekretaris'];

    public static function hasAnyRoleOrPermission(?User $user, array $roles, array|string $permissions = []): bool
    {
        if (!$user) {
            return false;
        }

        $permissions = (array) $permissions;

        return $user->hasAnyRole($roles) || collect($permissions)->contains(fn (string $permission) => $user->can($permission));
    }
}
