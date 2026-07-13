<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    protected $table = 'warga';
    protected $guarded = ['id'];

    public function rumah()
    {
        return $this->belongsTo(Rumah::class, 'id_rumah');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'warga_id');
    }

    public function laporanWarga()
    {
        return $this->hasMany(LaporanWarga::class, 'warga_id');
    }

    public function pembayaranIuran()
    {
        return $this->hasMany(PembayaranIuran::class, 'warga_id');
    }
}
