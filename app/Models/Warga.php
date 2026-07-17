<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Warga extends Model
{
    protected $table = 'warga';
    protected $guarded = ['id'];

    // FIX (Fitur Enkripsi NIK): cast otomatis enkripsi/dekripsi kolom nik.
    // Laravel encrypted cast pakai random IV, jadi ciphertext BEDA setiap kali
    // walau plaintext-nya sama -- karena itu uniqueness check pakai nik_hash terpisah,
    // BUKAN kolom nik ini.
    protected $casts = [
        'nik' => 'encrypted',
    ];

    /**
     * Mutator: setiap kali $warga->nik = 'xxx' di-set, otomatis:
     * - nik terenkripsi (ditangani oleh $casts di atas)
     * - nik_hash terisi HMAC deterministik untuk keperluan pencarian/unique check
     */
    public function setNikAttribute($value): void
    {
        $this->attributes['nik'] = Crypt::encryptString($value);
        $this->attributes['nik_hash'] = hash_hmac('sha256', $value, config('app.key'));
    }

    /**
     * Accessor: versi NIK yang disamarkan, untuk ditampilkan ke role
     * yang tidak berhak melihat NIK penuh.
     * Contoh: "3201********12"
     */
    public function getNikMaskedAttribute(): string
    {
        $nik = (string) $this->nik; // otomatis ter-decrypt via cast

        if (strlen($nik) < 6) {
            return str_repeat('*', strlen($nik));
        }

        return substr($nik, 0, 4) . str_repeat('*', strlen($nik) - 6) . substr($nik, -2);
    }

    /**
     * Helper otorisasi: apakah $user boleh melihat NIK penuh milik Warga ini.
     * Sesuai requirement: Tenant Owner, Ketua RT, Sekretaris -> selalu boleh.
     * Warga -> hanya boleh untuk dirinya sendiri + anggota keluarga satu rumah (id_rumah sama).
     * Role lain (Bendahara, Satpam, Wakil Ketua) -> TIDAK termasuk, harus lihat versi masked.
     */
    public function canBeViewedFullyBy(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        if ($user->hasAnyRole(['Tenant Owner', 'Ketua RT', 'Sekretaris'])) {
            return true;
        }

        if ($user->warga && $user->warga->id_rumah !== null && $user->warga->id_rumah === $this->id_rumah) {
            return true;
        }

        return false;
    }

    /**
     * FIX (Alur Approval Registrasi Mandiri): true jika warga ini sudah disetujui
     * pengurus dan boleh memakai aplikasi (login ke dashboard tenant).
     */
    public function isApproved(): bool
    {
        return $this->status_persetujuan === 'disetujui';
    }

    public function isPendingApproval(): bool
    {
        return $this->status_persetujuan === 'pending';
    }

    public function isRejected(): bool
    {
        return $this->status_persetujuan === 'ditolak';
    }

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
