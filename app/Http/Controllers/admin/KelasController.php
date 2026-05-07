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
                $q->where('nama_kelas', 'like', "%{$search}%")      // fix: nama → nama_kelas
                    ->orWhere('instruktur', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");   // fix: keterangan → deskripsi
            });
        }

        if ($instruktur = request('instruktur')) {
            $query->where('instruktur', $instruktur);
        }

        $kelas = $query->orderBy('id_kelas', 'desc')->paginate(10)->withQueryString(); // fix: created_at → id_kelas
        $total = Kelas::count();
        $instrukturCount = Kelas::distinct()->count('instruktur');
        $avgHarga = Kelas::avg('biaya');

        return view('admin.kelas.index', compact('kelas', 'total', 'instrukturCount', 'avgHarga'));
    }

    public function create()
    {
        return view('admin.kelas.form', ['item' => new Kelas()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kelas'  => 'required|string|max:35',       // fix: nama → nama_kelas
            'deskripsi'   => 'required|string',              // fix: keterangan → deskripsi
            'instruktur'  => 'required|string|max:30',
            'biaya'       => 'required|numeric',
            'kuota'       => 'nullable|integer|min:0',
            'foto'        => 'nullable|image|max:2048',      // fix: gambar → foto
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $uploadPath = public_path('uploads/kelas');
            if (!file_exists($uploadPath)) mkdir($uploadPath, 0755, true); // buat folder jika belum ada
            $file->move($uploadPath, $filename);
            $data['foto'] = $filename;
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
            'nama_kelas'  => 'required|string|max:35',       // fix: nama → nama_kelas
            'deskripsi'   => 'required|string',              // fix: keterangan → deskripsi
            'instruktur'  => 'required|string|max:30',
            'biaya'       => 'required|numeric',
            'kuota'       => 'nullable|integer|min:0',
            'foto'        => 'nullable|image|max:2048',      // fix: gambar → foto
        ]);

        if ($request->hasFile('foto')) {
            if ($kelas->foto && file_exists(public_path('uploads/kelas/' . $kelas->foto))) {
                @unlink(public_path('uploads/kelas/' . $kelas->foto));
            }
            $file = $request->file('foto');
            $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $uploadPath = public_path('uploads/kelas');
            if (!file_exists($uploadPath)) mkdir($uploadPath, 0755, true); // buat folder jika belum ada
            $file->move($uploadPath, $filename);
            $data['foto'] = $filename;
        }

        $kelas->update($data);
        return redirect()->route('admin.kelas')->with('success', 'Kelas berhasil diubah.');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        if ($kelas->foto && file_exists(public_path('uploads/kelas/' . $kelas->foto))) {
            @unlink(public_path('uploads/kelas/' . $kelas->foto));
        }
        $kelas->delete();
        return redirect()->route('admin.kelas')->with('success', 'Kelas berhasil dihapus.');
    }
}