<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GlobalAnnouncement extends Model
{
    // Ensure we always use central connection even if inside tenant context
    public function getConnectionName()
    {
        return config('tenancy.database.central_connection', config('database.default'));
    }

    protected $fillable = [
        'title',
        'content',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
