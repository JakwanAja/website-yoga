<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalModel;
use App\Models\Kelas;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    protected array $hariOptions = [
        'senin' => 'Senin',
        'selasa' => 'Selasa',
        'rabu' => 'Rabu',
        'kamis' => 'Kamis',
        'jumat' => 'Jumat',
        'sabtu' => 'Sabtu',
        'minggu' => 'Minggu',
    ];

    public function index()
    {
        $jadwals = JadwalModel::with('kelas')->orderBy('hari')->orderBy('jam_mulai')->paginate(12);
        $total = JadwalModel::count();

        return view('admin.jadwal.index', compact('jadwals', 'total'));
    }

    public function create()
    {
        $item = new JadwalModel();
        $hariOptions = $this->hariOptions;
        $kelasOptions = Kelas::orderBy('nama')->get();
        return view('admin.jadwal.form', compact('item', 'hariOptions', 'kelasOptions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'hari' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
            'jam_mulai' => 'required|date_format:H:i',
            'kuota' => 'nullable|integer|min:0',
        ]);

        JadwalModel::create($data);

        return redirect()->route('admin.jadwal')->with('success', 'Jadwal yoga berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = JadwalModel::findOrFail($id);
        $hariOptions = $this->hariOptions;
        $kelasOptions = Kelas::orderBy('nama')->get();
        return view('admin.jadwal.form', compact('item', 'hariOptions', 'kelasOptions'));
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalModel::findOrFail($id);

        $data = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'hari' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
            'jam_mulai' => 'required|date_format:H:i',
            'kuota' => 'nullable|integer|min:0',
        ]);

        $jadwal->update($data);

        return redirect()->route('admin.jadwal')->with('success', 'Jadwal yoga berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwal = JadwalModel::findOrFail($id);
        if ($jadwal->gambar && file_exists(public_path('uploads/kelas/' . $jadwal->gambar))) {
            @unlink(public_path('uploads/kelas/' . $jadwal->gambar));
        }
        $jadwal->delete();

        return redirect()->route('admin.jadwal')->with('success', 'Jadwal yoga berhasil dihapus.');
    }
}
