<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KelasController extends Controller
{
    public function index()
    {
        $query = Kelas::query();

        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('instruktur', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        if ($instruktur = request('instruktur')) {
            $query->where('instruktur', $instruktur);
        }

        $kelas = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $total = Kelas::count();
        // jumlah instruktur unik
        $instrukturCount = Kelas::distinct()->count('instruktur');
        // rata-rata harga (null jika tidak ada)
        $avgHarga = Kelas::avg('harga');

        return view('admin.kelas.index', compact('kelas', 'total', 'instrukturCount', 'avgHarga'));
    }

    public function create()
    {
        return view('admin.kelas.form', ['item' => new Kelas()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'required|string',
            'instruktur' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'kuota' => 'nullable|integer|min:0',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/kelas'), $filename);
            $data['gambar'] = $filename;
        }

        Kelas::create($data);
        return redirect()->route('admin.kelas')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = Kelas::findOrFail($id);
        return view('admin.kelas.form', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'required|string',
            'instruktur' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'kuota' => 'nullable|integer|min:0',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            // delete old file
            if ($kelas->gambar && file_exists(public_path('uploads/kelas/' . $kelas->gambar))) {
                @unlink(public_path('uploads/kelas/' . $kelas->gambar));
            }
            $file = $request->file('gambar');
            $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/kelas'), $filename);
            $data['gambar'] = $filename;
        }

        $kelas->update($data);
        return redirect()->route('admin.kelas')->with('success', 'Kelas berhasil diubah.');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        if ($kelas->gambar && file_exists(public_path('uploads/kelas/' . $kelas->gambar))) {
            @unlink(public_path('uploads/kelas/' . $kelas->gambar));
        }
        $kelas->delete();
        return redirect()->route('admin.kelas')->with('success', 'Kelas berhasil dihapus.');
    }
}
