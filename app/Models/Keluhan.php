<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keluhan extends Model
{
    protected $fillable = [
        'warga_id',
        'judul',
        'deskripsi',
        'kategori',
        'lokasi',
        'foto',
        'status',
        'tanggapan_admin',
    ];

    public function warga()
    {
        return $this->belongsTo(Warga::class);
    }
}
