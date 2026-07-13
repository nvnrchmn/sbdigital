<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenantRegistration extends Model
{
    protected $fillable = [
        'nama_perumahan',
        'tenant_id',
        'admin_name',
        'admin_email',
        'admin_password',
        'token',
        'status',
    ];

    public function getConnectionName()
    {
        return config('tenancy.database.central_connection', config('database.default'));
    }
}
