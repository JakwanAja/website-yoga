<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userRole = Auth::user()->role;

        if (!in_array($userRole, $roles)) {
            // Jika sudah login tapi role tidak sesuai, arahkan ke dashboard sesuai rolenya
            if ($userRole === 'super_admin') {
                return redirect()->route('superadmin.dashboard')
                    ->with('error', 'Akses ditolak. Anda diarahkan ke dashboard Anda.');
            }

            if ($userRole === 'admin') {
                return redirect()->route('admin.dashboard')
                    ->with('error', 'Akses ditolak. Anda tidak memiliki izin untuk halaman ini.');
            }

            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }

        return $next($request);
    }
}