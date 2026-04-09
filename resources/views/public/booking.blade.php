@extends('layouts.app')
@section('title', 'Booking — Asha Studio')

@section('content')
<div class="max-w-2xl mx-auto px-6 py-14">

    {{-- Header --}}
    <div class="text-center mb-10">
        <p class="font-serif uppercase tracking-widest text-xs mb-2" style="color:#9e7b7b; letter-spacing:0.18em;">Reserve Your Spot</p>
        <h1 class="font-script text-6xl" style="color:#5c2d2d;">Book a Class</h1>
    </div>

    {{-- Success State --}}
    <div id="success-card" class="hidden rounded-3xl p-10 text-center" style="background-color:#f5ece4;">
        <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-5"
             style="background-color:#b5848c;">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h2 class="font-script text-4xl mb-2" style="color:#5c2d2d;">Booking Berhasil!</h2>
        <p class="font-serif text-sm mb-6" style="color:#9e7b7b;">Terima kasih telah mempercayai Asha Studio.</p>
        <div class="rounded-2xl p-5 mb-6 inline-block" style="background-color:#e8d8d0;">
            <p class="font-serif text-xs mb-1" style="color:#9e7b7b; letter-spacing:0.1em;">KODE BOOKING ANDA</p>
            <p class="font-serif text-3xl font-semibold tracking-widest" style="color:#5c2d2d;" id="kode-booking">—</p>
        </div>
        <p class="font-serif text-xs" style="color:#9e7b7b;">Tunjukkan kode ini kepada instruktur saat datang ke studio.</p>
        <div class="mt-8">
            <a href="/jadwal" class="btn-rose font-serif tracking-widest px-8 py-3 rounded-full text-sm inline-block" style="letter-spacing:0.1em;">
                Lihat Jadwal Lainnya
            </a>
        </div>
    </div>

    {{-- Form --}}
    <div id="booking-form-wrap" class="rounded-3xl p-8 md:p-10" style="background-color:#f5ece4;">
        <form id="booking-form" class="space-y-6" novalidate>

            {{-- Nama --}}
            <div>
                <label class="block font-serif text-sm mb-2" style="color:#5c2d2d; letter-spacing:0.04em;">Nama Lengkap</label>
                <input type="text" id="nama" placeholder="Masukkan nama lengkap anda"
                    class="w-full rounded-2xl px-5 py-3.5 font-serif text-sm outline-none transition"
                    style="background-color:#b5848c; color:#fff; border:none;"
                    onfocus="this.style.boxShadow='0 0 0 2px #8d5f67'"
                    onblur="this.style.boxShadow='none'"
                    oninput="clearErr('err-nama')">
                <p id="err-nama" class="hidden mt-1.5 text-xs font-serif pl-1" style="color:#8d3a3a;"></p>
            </div>

            {{-- Email --}}
            <div>
                <label class="block font-serif text-sm mb-2" style="color:#5c2d2d; letter-spacing:0.04em;">Alamat Email</label>
                <input type="email" id="email" placeholder="contoh@email.com"
                    class="w-full rounded-2xl px-5 py-3.5 font-serif text-sm outline-none transition"
                    style="background-color:#b5848c; color:#fff; border:none;"
                    onfocus="this.style.boxShadow='0 0 0 2px #8d5f67'"
                    onblur="this.style.boxShadow='none'"
                    oninput="clearErr('err-email')">
                <p id="err-email" class="hidden mt-1.5 text-xs font-serif pl-1" style="color:#8d3a3a;"></p>
            </div>

            {{-- WhatsApp --}}
            <div>
                <label class="block font-serif text-sm mb-2" style="color:#5c2d2d; letter-spacing:0.04em;">Nomor WhatsApp</label>
                <input type="tel" id="wa" placeholder="08xx xxxx xxxx"
                    class="w-full rounded-2xl px-5 py-3.5 font-serif text-sm outline-none transition"
                    style="background-color:#b5848c; color:#fff; border:none;"
                    onfocus="this.style.boxShadow='0 0 0 2px #8d5f67'"
                    onblur="this.style.boxShadow='none'"
                    oninput="clearErr('err-wa')">
                <p id="err-wa" class="hidden mt-1.5 text-xs font-serif pl-1" style="color:#8d3a3a;"></p>
            </div>

            {{-- Pilih Kelas --}}
            <div>
                <label class="block font-serif text-sm mb-2" style="color:#5c2d2d; letter-spacing:0.04em;">Pilih Kelas</label>
                <select id="kelas"
                    class="w-full rounded-2xl px-5 py-3.5 font-serif text-sm outline-none transition appearance-none cursor-pointer"
                    style="background-color:#b5848c; color:#fff; border:none;"
                    onfocus="this.style.boxShadow='0 0 0 2px #8d5f67'"
                    onblur="this.style.boxShadow='none'"
                    onchange="updateJadwal(); clearErr('err-kelas')">
                    <option value="" style="background:#b5848c;">— Pilih kelas —</option>
                    <option value="Beginner Yoga" style="background:#b5848c;">Beginner Yoga</option>
                    <option value="Pilates Core Strength" style="background:#b5848c;">Pilates Core Strength</option>
                    <option value="Yoga Relax & Stretch" style="background:#b5848c;">Yoga Relax & Stretch</option>
                </select>
                <p id="err-kelas" class="hidden mt-1.5 text-xs font-serif pl-1" style="color:#8d3a3a;"></p>
            </div>

            {{-- Pilih Jadwal --}}
            <div>
                <label class="block font-serif text-sm mb-2" style="color:#5c2d2d; letter-spacing:0.04em;">Pilih Jadwal</label>
                <select id="jadwal"
                    class="w-full rounded-2xl px-5 py-3.5 font-serif text-sm outline-none transition appearance-none cursor-pointer"
                    style="background-color:#b5848c; color:#fff; border:none;"
                    onfocus="this.style.boxShadow='0 0 0 2px #8d5f67'"
                    onblur="this.style.boxShadow='none'"
                    oninput="clearErr('err-jadwal')">
                    <option value="" style="background:#b5848c;">— Pilih kelas dulu —</option>
                </select>
                <p id="err-jadwal" class="hidden mt-1.5 text-xs font-serif pl-1" style="color:#8d3a3a;"></p>
            </div>

            {{-- Submit --}}
            <div class="pt-2 flex justify-center">
                <button type="button" onclick="submitBooking()"
                    class="btn-rose font-serif tracking-widest px-12 py-3.5 rounded-full text-sm transition-all active:scale-95"
                    style="letter-spacing:0.18em;">
                    KONFIRMASI BOOKING
                </button>
            </div>

        </form>
    </div>

</div>
@endsection

@push('scripts')
<script>
const jadwalData = {
    'Beginner Yoga': [
        'Senin, 08.00 WIB', 'Senin, 20.45 WIB',
        'Rabu, 15.15 WIB', 'Rabu, 21.00 WIB',
        'Jumat, 13.00 WIB', 'Jumat, 20.45 WIB',
        'Minggu, 10.00 WIB', 'Minggu, 17.10 WIB',
    ],
    'Pilates Core Strength': [
        'Senin, 16.30 WIB', 'Senin, 20.10 WIB',
        'Rabu, 10.00 WIB', 'Rabu, 19.25 WIB', 'Rabu, 21.00 WIB',
        'Jumat, 16.30 WIB', 'Jumat, 20.10 WIB',
        'Minggu, 15.15 WIB', 'Minggu, 21.00 WIB',
    ],
    'Yoga Relax & Stretch': [
        'Senin, 12.15 WIB',
        'Rabu, 17.10 WIB',
        'Jumat, 08.00 WIB',
        'Minggu, 19.25 WIB',
    ],
};

function updateJadwal() {
    const kelas = document.getElementById('kelas').value;
    const jadwalEl = document.getElementById('jadwal');
    jadwalEl.innerHTML = '';
    if (!kelas) {
        jadwalEl.innerHTML = '<option value="" style="background:#b5848c;">— Pilih kelas dulu —</option>';
        return;
    }
    jadwalEl.innerHTML = '<option value="" style="background:#b5848c;">— Pilih jadwal —</option>';
    (jadwalData[kelas] || []).forEach(j => {
        const opt = document.createElement('option');
        opt.value = j;
        opt.textContent = j;
        opt.style.background = '#b5848c';
        jadwalEl.appendChild(opt);
    });
}

function showErr(id, msg) {
    const el = document.getElementById(id);
    el.textContent = msg;
    el.classList.remove('hidden');
}

function clearErr(id) {
    document.getElementById(id).classList.add('hidden');
}

function generateKode() {
    const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    let code = 'ASH-';
    for (let i = 0; i < 6; i++) code += chars[Math.floor(Math.random() * chars.length)];
    return code;
}

function submitBooking() {
    let valid = true;

    const nama = document.getElementById('nama').value.trim();
    const email = document.getElementById('email').value.trim();
    const wa = document.getElementById('wa').value.trim();
    const kelas = document.getElementById('kelas').value;
    const jadwal = document.getElementById('jadwal').value;

    if (!nama) { showErr('err-nama', 'Nama lengkap wajib diisi.'); valid = false; }
    if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { showErr('err-email', 'Masukkan alamat email yang valid.'); valid = false; }
    if (!wa || !/^[0-9]{9,14}$/.test(wa.replace(/\s/g,''))) { showErr('err-wa', 'Masukkan nomor WhatsApp yang valid.'); valid = false; }
    if (!kelas) { showErr('err-kelas', 'Pilih kelas terlebih dahulu.'); valid = false; }
    if (!jadwal) { showErr('err-jadwal', 'Pilih jadwal terlebih dahulu.'); valid = false; }

    if (!valid) return;

    // Tampilkan sukses
    document.getElementById('kode-booking').textContent = generateKode();
    document.getElementById('booking-form-wrap').classList.add('hidden');
    document.getElementById('success-card').classList.remove('hidden');
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>
@endpush