<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\JadwalModel;
use App\Models\Kelas;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    protected array $hariOptions = [
        'senin'  => 'Senin',
        'selasa' => 'Selasa',
        'rabu'   => 'Rabu',
        'kamis'  => 'Kamis',
        'jumat'  => 'Jumat',
        'sabtu'  => 'Sabtu',
        'minggu' => 'Minggu',
    ];

    public function index()
    {
        $jadwals = JadwalModel::with('kelas')->orderBy('hari')->orderBy('jam_mulai')->paginate(12);
        $total   = JadwalModel::count();

        return view('admin.jadwal.index', compact('jadwals', 'total'));
    }

    public function create()
    {
        $item         = new JadwalModel();
        $hariOptions  = $this->hariOptions;
        $kelasOptions = Kelas::orderBy('nama_kelas')->get();
        return view('admin.jadwal.form', compact('item', 'hariOptions', 'kelasOptions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kelas_id'  => 'required|exists:kelas,id_kelas',
            'hari'      => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
            'jam_mulai' => 'required|date_format:H:i',
            // FIX: sisa_kuota tidak divalidasi dari input form,
            // melainkan diambil otomatis dari kuota kelas di bawah
        ]);

        // FIX: isi sisa_kuota otomatis dari kuota kelas yang dipilih
        $kelas              = Kelas::findOrFail($data['kelas_id']);
        $data['sisa_kuota'] = $kelas->kuota ?? 0;

        JadwalModel::create($data);

        return redirect()->route('admin.jadwal')->with('success', 'Jadwal yoga berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item         = JadwalModel::findOrFail($id);
        $hariOptions  = $this->hariOptions;
        $kelasOptions = Kelas::orderBy('nama_kelas')->get();
        return view('admin.jadwal.form', compact('item', 'hariOptions', 'kelasOptions'));
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalModel::findOrFail($id);

        $data = $request->validate([
            'kelas_id'  => 'required|exists:kelas,id_kelas',
            'hari'      => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
            'jam_mulai' => 'required|date_format:H:i',
            // FIX: sisa_kuota tidak diubah manual saat edit,
            // hanya kelas/hari/jam yang bisa diperbarui admin
        ]);

        $jadwal->update($data);

        return redirect()->route('admin.jadwal')->with('success', 'Jadwal yoga berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwal = JadwalModel::findOrFail($id);

        // FIX: hapus semua booking yang terkait jadwal ini terlebih dahulu
        // agar tidak terjadi foreign key constraint violation
        Booking::where('id_jadwal', $jadwal->id_jadwal)->delete();

        $jadwal->delete();

        return redirect()->route('admin.jadwal')->with('success', 'Jadwal yoga berhasil dihapus.');
    }
}