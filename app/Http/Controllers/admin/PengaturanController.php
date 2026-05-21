<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PengaturanController extends Controller
{
    /**
     * Tampilkan halaman pengaturan profil
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        return view('admin.pengaturan', compact('user'));
    }

    /**
     * Update nama & username
     */
    public function updateProfil(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'nama_user' => 'required|string|max:35',
            'username'  => 'required|string|max:25|unique:users,username,' . $user->id_user . ',id_user',
        ], [
            'nama_user.required' => 'Nama wajib diisi.',
            'nama_user.max'      => 'Nama maksimal 35 karakter.',
            'username.required'  => 'Username wajib diisi.',
            'username.max'       => 'Username maksimal 25 karakter.',
            'username.unique'    => 'Username sudah dipakai akun lain.',
        ]);

        $user->nama_user = $request->nama_user;
        $user->username  = $request->username;
        $user->save();

        return redirect()->route('admin.pengaturan')
            ->with('success_profil', 'Profil berhasil diperbarui.');
    }

    /**
     * Ganti password
     */
    public function updatePassword(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'password_lama' => 'required|string',
            'password'      => 'required|string|min:8|confirmed',
        ], [
            'password_lama.required' => 'Password lama wajib diisi.',
            'password.required'      => 'Password baru wajib diisi.',
            'password.min'           => 'Password baru minimal 8 karakter.',
            'password.confirmed'     => 'Konfirmasi password tidak cocok.',
        ]);

        // Cek password lama
        if (!Hash::check($request->password_lama, $user->password)) {
            return redirect()->route('admin.pengaturan')
                ->withErrors(['password_lama' => 'Password lama tidak sesuai.'])
                ->with('tab_aktif', 'password');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('admin.pengaturan')
            ->with('success_password', 'Password berhasil diubah. Silakan login ulang jika diperlukan.');
    }
}