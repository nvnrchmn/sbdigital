<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'plan_id',
            // Add custom columns here if you have modified the tenants table,
            // otherwise 'nama_perumahan' will be saved in the 'data' JSON column.
        ];
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }
}
