<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'status',
        'tgl_selesai',
        'created_by',
    ];

    protected $casts = [
        'tgl_selesai' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function options()
    {
        return $this->hasMany(PollOption::class);
    }

    public function votes()
    {
        return $this->hasMany(PollVote::class);
    }
}
