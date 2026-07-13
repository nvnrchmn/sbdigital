<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenantSubscription extends Model
{
    // Ensure we always use central connection even if inside tenant context
    public function getConnectionName()
    {
        return config('tenancy.database.central_connection', config('database.default'));
    }

    protected $fillable = [
        'tenant_id',
        'plan_id',
        'amount',
        'status',
        'external_id',
        'checkout_url',
        'paid_at',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
