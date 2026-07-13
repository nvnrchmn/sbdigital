<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukLapak extends Model
{
    protected $fillable = [
        'warga_id',
        'nama_produk',
        'deskripsi',
        'harga',
        'kategori',
        'foto',
    ];

    public function warga()
    {
        return $this->belongsTo(Warga::class);
    }
}
