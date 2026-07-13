<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumuman';
    protected $guarded = ['id'];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
