<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;

class InitializeTenancyIfTenantRoute
{
    public function handle(Request $request, Closure $next)
    {
        // Jika ada parameter tenant di URL (contoh: POST /ksb2/livewire/update), inisialisasi tenancy
        if ($request->route('tenant')) {
            return app(InitializeTenancyByPath::class)->handle($request, $next);
        }

        // Jika tidak ada (contoh: POST /livewire/update), biarkan sebagai Central request
        return $next($request);
    }
}
