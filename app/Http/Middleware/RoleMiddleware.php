<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Periksa apakah user yang login memiliki salah satu dari role yang diizinkan.
     *
     * Contoh penggunaan di route:
     *   ->middleware('role:admin,superadmin')
     *   ->middleware('role:superadmin')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Belum login sama sekali
        if (! Auth::check()) {
            return redirect()->route('home')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $userRole = Auth::user()->role;

        // Role tidak ada dalam daftar yang diizinkan
        if (! in_array($userRole, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}