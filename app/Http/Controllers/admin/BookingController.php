<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\JadwalModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    /**
     * ────────────────────────────────────────
     * PUBLIK — Simpan booking dari form publik
     * Status default: 'booking'
     * ────────────────────────────────────────
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:35',
            'email'     => 'required|email|max:35',
            'telephone' => 'required|string|max:13',
            'id_jadwal' => 'required|exists:jadwal_kelas,id_jadwal',
            'class_name'=> 'nullable|string|max:255',
        ], [
            'nama.required'      => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'telephone.required' => 'Nomor telepon wajib diisi.',
            'telephone.max'      => 'Nomor telepon maksimal 13 karakter.',
            'id_jadwal.required' => 'Jadwal kelas wajib dipilih.',
            'id_jadwal.exists'   => 'Jadwal yang dipilih tidak valid.',
        ]);

        // Status selalu 'booking' saat dibuat dari publik
        $validated['status'] = 'booking';

        // Cek kuota pada jadwal
        $jadwal = JadwalModel::find($validated['id_jadwal']);
        if (!$jadwal) {
            return redirect()->back()->withErrors(['id_jadwal' => 'Jadwal tidak ditemukan.']);
        }

        // FIX: cek menggunakan sisa_kuota (bukan hitung manual), lebih akurat
        if ($jadwal->sisa_kuota !== null && $jadwal->sisa_kuota <= 0) {
            return redirect()->back()->withErrors(['id_jadwal' => 'Maaf, kuota untuk jadwal ini sudah penuh.']);
        }

        Booking::create($validated);

        // FIX: kurangi sisa_kuota di jadwal setiap booking berhasil dibuat
        if ($jadwal->sisa_kuota !== null) {
            $jadwal->decrement('sisa_kuota');
        }

        return redirect()->back()
            ->with('booking_success', 'Booking berhasil! Kami akan menghubungi Anda segera.');
    }

    /**
     * ────────────────────────────────────────
     * ADMIN — Daftar booking + search & filter
     * ────────────────────────────────────────
     */
    public function index(Request $request)
    {
        $query = Booking::with('jadwal');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('telephone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('jadwal')) {
            $query->where('id_jadwal', $request->jadwal);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->orderBy('kode_booking', 'desc')->paginate(10)->withQueryString();
        $jadwals  = JadwalModel::orderBy('hari')->get();
        $total    = Booking::count();

        // Hitung per-status untuk summary card
        $statusCount = [
            'booking'       => Booking::where('status', 'booking')->count(),
            'terkonfirmasi' => Booking::where('status', 'terkonfirmasi')->count(),
            'hadir'         => Booking::where('status', 'hadir')->count(),
            'selesai'       => Booking::where('status', 'selesai')->count(),
        ];

        return view('admin.booking.booking', compact('bookings', 'jadwals', 'total', 'statusCount'));
    }

    /**
     * ────────────────────────────────────────
     * ADMIN — Update status saja (AJAX-friendly)
     * ────────────────────────────────────────
     */
    public function updateStatus(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|in:booking,terkonfirmasi,hadir,selesai',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update(['status' => $request->status]);

        return redirect()->route('admin.booking')
            ->with('success', "Status booking #{$id} diperbarui menjadi \"{$request->status}\".");
    }

    /**
     * ────────────────────────────────────────
     * ADMIN — Kirim informasi booking ke email peserta
     * ────────────────────────────────────────
     */
    public function sendEmail(int $id)
    {
        $booking = Booking::findOrFail($id);

        if (!$booking->email) {
            return redirect()->route('admin.booking')
                ->with('error', 'Email peserta tidak tersedia.');
        }

        $subject = 'Informasi Booking Anda #' . str_pad($booking->kode_booking, 4, '0', STR_PAD_LEFT);
        $jadwalText = $booking->jadwal
            ? "pada hari {$booking->jadwal->hari_label}, jam " . Carbon::parse($booking->jadwal->jam_mulai)->format('H:i') . " WIB"
            : 'untuk jadwal yang belum ditentukan';

        $body = "Halo {$booking->nama},\n\n" .
            "Booking Anda (kode #" . str_pad($booking->kode_booking, 4, '0', STR_PAD_LEFT) . ") saat ini berstatus \"{$booking->status_info['label']}\" dan dijadwalkan {$jadwalText}.\n\n" .
            "Terima kasih telah melakukan booking di Asha Studio. Jika Anda membutuhkan bantuan lebih lanjut, balas email ini atau hubungi kami.\n\n" .
            "Salam,\nAsha Studio";

        try {
            Mail::raw($body, function ($message) use ($booking, $subject) {
                $message->to($booking->email, $booking->nama)
                    ->subject($subject);
            });

            return redirect()->route('admin.booking')
                ->with('success', "Email berhasil dikirim ke {$booking->email}.");
        } catch (\Exception $e) {
            return redirect()->route('admin.booking')
                ->with('error', 'Gagal mengirim email. Periksa konfigurasi mail server.');
        }
    }

    /**
     * ────────────────────────────────────────
     * ADMIN — Form edit booking (data + status)
     * ────────────────────────────────────────
     */
    public function edit(int $id)
    {
        $booking  = Booking::findOrFail($id);
        // FIX: ganti where('status', 1) → where('status', 'aktif') agar jadwal muncul di dropdown
        $jadwals  = JadwalModel::where('status', 'aktif')->orderBy('hari')->get();
        $statuses = Booking::STATUSES;

        return view('admin.booking.booking-edit', compact('booking', 'jadwals', 'statuses'));
    }

    /**
     * ────────────────────────────────────────
     * ADMIN — Simpan perubahan booking
     * ────────────────────────────────────────
     */
    public function update(Request $request, int $id)
    {
        $booking = Booking::findOrFail($id);

        $validated = $request->validate([
            'nama'      => 'required|string|max:35',
            'email'     => 'required|email|max:35',
            'telephone' => 'required|string|max:13',
            'id_jadwal' => 'required|exists:jadwal_kelas,id_jadwal',
            'status'    => 'required|in:booking,terkonfirmasi,hadir,selesai',
        ], [
            'nama.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'telephone.required' => 'Nomor telepon wajib diisi.',
            'id_jadwal.required' => 'Jadwal wajib dipilih.',
            'status.required'    => 'Status wajib dipilih.',
            'status.in'          => 'Status tidak valid.',
        ]);

        $booking->update($validated);

        return redirect()->route('admin.booking')
            ->with('success', 'Data booking berhasil diperbarui.');
    }

    /**
     * ────────────────────────────────────────
     * ADMIN — Hapus booking
     * ────────────────────────────────────────
     */
    public function destroy(int $id)
    {
        Booking::findOrFail($id)->delete();

        return redirect()->route('admin.booking')
            ->with('success', 'Data booking berhasil dihapus.');
    }
}