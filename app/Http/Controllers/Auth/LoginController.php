<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Dipanggil oleh route 'login' — wajib ada agar middleware auth
    // tahu ke mana redirect jika user belum login
    public function redirectIfAuthenticated()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('home');
    }

    // Proses login dari modal di beranda
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $role = Auth::user()->role;

            if (!in_array($role, ['admin', 'superadmin'])) {
                Auth::logout();
                return redirect()->route('home')->withErrors([
                    'email' => 'Akun Anda tidak memiliki akses ke sistem ini.',
                ]);
            }

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Selamat datang, ' . Auth::user()->name . '!');
        }

        // Gagal login → kembali ke beranda agar modal bisa terbuka kembali
        return redirect()->route('home')->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Dashboard — dipisah dari closure di route agar bisa inject data nanti
    public function dashboard()
    {
        // Siap dikembangkan:
        // $totalBooking  = Booking::count();
        // $totalKelas    = Kelas::where('aktif', true)->count();
        // $totalMember   = User::where('role', 'member')->count();
        // $jadwalHariIni = Jadwal::whereDate('tanggal', today())->count();
        // $recentBookings = Booking::latest()->take(5)->get();

        return view('admin.dashboard');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Anda telah berhasil logout.');
    }
}