<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rumah extends Model
{
    protected $table = 'rumah';
    protected $guarded = ['id'];

    public function warga()
    {
        return $this->hasMany(Warga::class, 'id_rumah');
    }

    public function pembayaranIuran()
    {
        return $this->hasMany(PembayaranIuran::class, 'id_rumah');
    }
}
