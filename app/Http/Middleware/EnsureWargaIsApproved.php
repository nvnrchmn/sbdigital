<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * FIX (Alur Approval Registrasi Mandiri):
 *
 * Middleware ini HANYA menyentuh akun yang punya warga_id (artinya akun itu
 * lahir dari halaman registrasi mandiri di resources/views/livewire/pages/auth/register.blade.php).
 * Akun pengurus (Tenant Owner, Ketua RT, Sekretaris, dll.) yang dibuat/di-assign
 * role langsung oleh Tenant Owner lewat modul Role TIDAK punya warga_id, jadi
 * tidak pernah kena redirect oleh middleware ini.
 *
 * Pasang middleware ini SETELAH 'auth' dan 'verified' di route yang butuh proteksi,
 * supaya urutannya: harus login -> harus verifikasi email -> baru dicek approval.
 */
class EnsureWargaIsApproved
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->warga_id && $user->warga && !$user->warga->isApproved()) {
            return redirect()->route('tenant.pending-approval');
        }

        return $next($request);
    }
}
