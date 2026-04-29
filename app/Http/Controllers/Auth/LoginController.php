<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Redirect ke dashboard jika sudah login,
     * atau tampilkan halaman publik (beranda) dengan modal login terbuka.
     */
    public function redirectIfAuthenticated()
    {
        if (Auth::check()) {
            $role = Auth::user()->role;

            if (in_array($role, ['admin', 'superadmin'])) {
                return redirect()->route('admin.dashboard');
            }
        }

        // Belum login → tampilkan halaman login terpisah
        return view('auth.login');
    }

    /**
     * Proses login: autentikasi via username & password,
     * lalu redirect ke dashboard sesuai role.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $credentials = $request->only('username', 'password');

        // Gunakan username (bukan email) sebagai identifier
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $role = Auth::user()->role;

            if (in_array($role, ['admin', 'superadmin'])) {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Selamat datang, ' . Auth::user()->nama_user . '!');
            }

            // Role tidak dikenal → logout & tolak
            Auth::logout();
            return redirect()->route('home')
                ->with('error', 'Akses ditolak. Role tidak dikenali.');
        }

        return redirect()->back()
            ->withErrors(['login' => 'Username atau password salah.'])
            ->withInput($request->only('username'));
    }

    /**
     * Logout dan redirect ke beranda.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Anda telah berhasil logout.');
    }
}