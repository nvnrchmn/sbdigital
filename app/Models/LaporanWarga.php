<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanWarga extends Model
{
    protected $table = 'laporan_warga';
    protected $guarded = ['id'];

    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }
}
