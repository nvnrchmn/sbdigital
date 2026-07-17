<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

// FIX (b): mengaktifkan enforcement verifikasi email. Method konkretnya
// (hasVerifiedEmail, markEmailAsVerified, sendEmailVerificationNotification, dst)
// sudah otomatis tersedia lewat trait Illuminate\Auth\MustVerifyEmail yang
// sudah di-`use` di dalam Illuminate\Foundation\Auth\User (parent class ini) --
// jadi cukup implement interface-nya saja, tidak perlu tambah trait lagi.
#[Fillable(['name', 'email', 'password', 'warga_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }

    public function pengumuman()
    {
        return $this->hasMany(Pengumuman::class, 'admin_id');
    }
}
