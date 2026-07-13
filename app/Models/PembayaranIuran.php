<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranIuran extends Model
{
    protected $table = 'pembayaran_iuran';
    protected $guarded = ['id'];

    public function rumah()
    {
        return $this->belongsTo(Rumah::class, 'id_rumah');
    }

    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }
}
