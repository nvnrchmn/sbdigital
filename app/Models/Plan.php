<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    // Ensure we always use central connection even if inside tenant context
    public function getConnectionName()
    {
        return config('tenancy.database.central_connection', config('database.default'));
    }

    protected $fillable = [
        'name',
        'description',
        'price',
        'billing_cycle',
        'max_houses',
        'features',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
        ];
    }

    public function tenants()
    {
        return $this->hasMany(Tenant::class, 'plan_id');
    }
}
