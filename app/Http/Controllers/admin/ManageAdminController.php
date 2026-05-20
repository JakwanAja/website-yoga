<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ManageAdminController extends Controller
{
    /**
     * Daftar semua admin & superadmin
     */
    public function index()
    {
        $admins = User::whereIn('role', ['admin', 'superadmin'])
            ->orderBy('role', 'asc')
            ->orderBy('nama_user', 'asc')
            ->get();

        return view('admin.manajemenadmin.kelola-admin', compact('admins'));
    }

    /**
     * Form tambah admin
     */
    public function create()
    {
        return view('admin.manajemenadmin.admin-create');
    }

    /**
     * Simpan admin baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_user' => 'required|string|max:35',
            'username'  => 'required|string|max:25|unique:users,username',
            'password'  => 'required|string|min:8|confirmed',
            'role'      => 'required|in:admin,superadmin',
        ], [
            'nama_user.required' => 'Nama wajib diisi.',
            'nama_user.max'      => 'Nama maksimal 35 karakter.',
            'username.required'  => 'Username wajib diisi.',
            'username.max'       => 'Username maksimal 25 karakter.',
            'username.unique'    => 'Username sudah dipakai.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required'      => 'Role wajib dipilih.',
            'role.in'            => 'Role tidak valid.',
        ]);

        User::create([
            'nama_user' => $request->nama_user,
            'username'  => $request->username,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
            'status'    => 'aktif',
        ]);

        return redirect()->route('admin.manage-admin')
            ->with('success', 'Admin "' . $request->nama_user . '" berhasil ditambahkan.');
    }

    /**
     * Form edit admin
     */
    public function edit(int $id)
    {
        $admin = User::findOrFail($id);
        return view('admin.manajemenadmin.admin-edit', compact('admin'));
    }

    /**
     * Simpan perubahan admin
     */
    public function update(Request $request, int $id)
    {
        $admin = User::findOrFail($id);

        $request->validate([
            'nama_user' => 'required|string|max:35',
            'username'  => 'required|string|max:25|unique:users,username,' . $id . ',id_user',
            'role'      => 'required|in:admin,superadmin',
            'status'    => 'required|in:aktif,tidak aktif', // FIX: sesuai ENUM di tabel users
            'password'  => 'nullable|string|min:8|confirmed',
        ], [
            'nama_user.required' => 'Nama wajib diisi.',
            'nama_user.max'      => 'Nama maksimal 35 karakter.',
            'username.required'  => 'Username wajib diisi.',
            'username.max'       => 'Username maksimal 25 karakter.',
            'username.unique'    => 'Username sudah dipakai.',
            'role.required'      => 'Role wajib dipilih.',
            'status.required'    => 'Status wajib dipilih.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $data = [
            'nama_user' => $request->nama_user,
            'username'  => $request->username,
            'role'      => $request->role,
            'status'    => $request->status,
        ];

        // Ganti password hanya jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('admin.manage-admin')
            ->with('success', 'Data admin "' . $admin->nama_user . '" berhasil diperbarui.');
    }

    /**
     * Hapus admin — tidak bisa hapus diri sendiri
     */
    public function destroy(int $id)
    {
        $admin = User::findOrFail($id);

        if ($admin->id_user === Auth::id()) {
            return redirect()->route('admin.manage-admin')
                ->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $nama = $admin->nama_user;
        $admin->delete();

        return redirect()->route('admin.manage-admin')
            ->with('success', 'Admin "' . $nama . '" berhasil dihapus.');
    }
}