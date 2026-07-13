<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratPengantar extends Model
{
    protected $fillable = [
        'warga_id',
        'jenis_surat',
        'keperluan',
        'status',
        'nomor_surat',
        'keterangan_admin',
        'tanggal_disetujui',
    ];

    protected $casts = [
        'tanggal_disetujui' => 'datetime',
    ];

    public function warga()
    {
        return $this->belongsTo(Warga::class);
    }
}
