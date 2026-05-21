@extends('layouts.admin')

@section('title', 'Pengaturan Akun')
@section('page-title', 'Pengaturan')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        /* ── Pengaturan Layout ── */
        .pengaturan-wrap {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 24px;
            align-items: start;
        }
        @media (max-width: 900px) {
            .pengaturan-wrap { grid-template-columns: 1fr; }
        }

        /* ── Profile Card (kiri) ── */
        .profile-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            text-align: center;
        }
        .profile-card-banner {
            height: 80px;
            background: linear-gradient(135deg, var(--dark) 0%, #7a3a3a 60%, var(--primary) 100%);
            position: relative;
        }
        .profile-avatar {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: var(--primary);
            color: #fff;
            font-family: 'Cormorant Garamond', serif;
            font-size: 30px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: -36px auto 0;
            border: 4px solid var(--white);
            position: relative;
            z-index: 1;
            box-shadow: 0 4px 16px rgba(90,46,46,0.18);
        }
        .profile-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 20px;
            font-weight: 600;
            color: var(--dark);
            margin: 14px 0 4px;
            padding: 0 20px;
        }
        .profile-username {
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 6px;
        }
        .profile-role-badge {
            display: inline-block;
            padding: 3px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-bottom: 20px;
        }
        .profile-role-badge.superadmin {
            background: rgba(166,124,115,.14);
            color: var(--primary);
        }
        .profile-role-badge.admin {
            background: rgba(122,158,181,.14);
            color: var(--info);
        }
        .profile-meta-list {
            border-top: 1px solid var(--border);
            padding: 16px 0;
        }
        .profile-meta-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 24px;
            font-size: 13px;
            color: var(--text-muted);
        }
        .profile-meta-item i {
            width: 16px;
            color: var(--primary);
            font-size: 13px;
        }
        .profile-meta-item span {
            color: var(--dark);
            font-weight: 500;
        }
        .profile-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .profile-status::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--success);
        }
        .profile-status.nonaktif::before { background: var(--danger); }

        /* ── Tab Nav ── */
        .tab-nav {
            display: flex;
            gap: 4px;
            border-bottom: 1px solid var(--border);
            padding: 0 24px;
            margin-bottom: 0;
        }
        .tab-btn {
            padding: 14px 20px;
            font-size: 13.5px;
            font-weight: 500;
            color: var(--text-muted);
            border: none;
            background: none;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            margin-bottom: -1px;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .tab-btn:hover { color: var(--dark); }
        .tab-btn.active {
            color: var(--primary);
            border-bottom-color: var(--primary);
            font-weight: 600;
        }

        /* ── Tab Content ── */
        .tab-content { display: none; padding: 28px 24px; }
        .tab-content.active { display: block; }

        /* ── Form ── */
        .pg-form-group {
            margin-bottom: 20px;
        }
        .pg-form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--text-muted);
            margin-bottom: 8px;
        }
        .pg-form-group input {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 11px 16px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            color: var(--dark);
            background: var(--light);
            outline: none;
            transition: var(--transition);
            box-sizing: border-box;
        }
        .pg-form-group input:focus {
            border-color: var(--primary);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(166,124,115,.10);
        }
        .pg-form-group input:disabled {
            background: var(--cream);
            color: var(--text-muted);
            cursor: not-allowed;
        }
        .pg-field-note {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 5px;
        }
        .pg-field-error {
            font-size: 12px;
            color: var(--danger);
            margin-top: 5px;
        }
        .pg-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        @media (max-width: 600px) { .pg-form-row { grid-template-columns: 1fr; } }

        /* ── Password strength ── */
        .pw-strength-bar {
            height: 4px;
            border-radius: 4px;
            background: var(--border);
            margin-top: 8px;
            overflow: hidden;
        }
        .pw-strength-fill {
            height: 100%;
            border-radius: 4px;
            width: 0%;
            transition: width .3s ease, background .3s ease;
        }
        .pw-strength-label {
            font-size: 11px;
            margin-top: 4px;
            color: var(--text-muted);
        }

        /* ── Alert ── */
        .alert-success-pg {
            background: rgba(106,158,127,.10);
            border: 1px solid rgba(106,158,127,.3);
            color: #2d6a4f;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 13.5px;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        .alert-error-pg {
            background: rgba(184,92,92,.08);
            border: 1px solid rgba(184,92,92,.25);
            color: var(--danger);
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 13.5px;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        /* ── Readonly info row ── */
        .info-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid rgba(232,221,216,.5);
        }
        .info-row:last-child { border-bottom: none; }
        .info-row-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: var(--text-muted);
        }
        .info-row-value {
            font-size: 14px;
            font-weight: 500;
            color: var(--dark);
        }
        .info-section-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 17px;
            font-weight: 600;
            color: var(--dark);
            margin: 0 0 16px;
        }
    </style>
@endsection

@section('content')

@php $tabAktif = session('tab_aktif', 'profil'); @endphp

<div class="pengaturan-wrap">

    {{-- ══ KIRI: Profile Card ══ --}}
    <div class="profile-card">
        <div class="profile-card-banner"></div>
        <div class="profile-avatar">
            {{ strtoupper(substr($user->nama_user, 0, 1)) }}
        </div>
        <div class="profile-name">{{ $user->nama_user }}</div>
        <div class="profile-username">@{{ $user->username }}</div>
        <span class="profile-role-badge {{ $user->role }}">
            {{ $user->role === 'superadmin' ? 'Super Admin' : 'Admin' }}
        </span>

        <div class="profile-meta-list">
            <div class="profile-meta-item">
                <i class="fas fa-shield-alt"></i>
                <span>{{ $user->role === 'superadmin' ? 'Super Admin' : 'Admin' }}</span>
            </div>
            <div class="profile-meta-item">
                <i class="fas fa-circle"></i>
                <span class="profile-status {{ $user->status !== 'aktif' ? 'nonaktif' : '' }}">
                    {{ $user->status === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                </span>
            </div>
            <div class="profile-meta-item">
                <i class="fas fa-calendar-alt"></i>
                <span>Bergabung {{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('M Y') : '—' }}</span>
            </div>
        </div>
    </div>

    {{-- ══ KANAN: Panel Tab ══ --}}
    <div class="panel" style="padding:0; overflow:hidden;">

        {{-- Tab Nav --}}
        <div class="tab-nav">
            <button class="tab-btn {{ $tabAktif === 'profil' ? 'active' : '' }}"
                onclick="switchTab('profil', this)">
                <i class="fas fa-user"></i> Edit Profil
            </button>
            <button class="tab-btn {{ $tabAktif === 'password' ? 'active' : '' }}"
                onclick="switchTab('password', this)">
                <i class="fas fa-lock"></i> Ganti Password
            </button>
            <button class="tab-btn {{ $tabAktif === 'info' ? 'active' : '' }}"
                onclick="switchTab('info', this)">
                <i class="fas fa-info-circle"></i> Info Akun
            </button>
        </div>

        {{-- ── TAB: Edit Profil ── --}}
        <div id="tab-profil" class="tab-content {{ $tabAktif === 'profil' ? 'active' : '' }}">

            @if(session('success_profil'))
                <div class="alert-success-pg">
                    <i class="fas fa-check-circle"></i> {{ session('success_profil') }}
                </div>
            @endif

            <form action="{{ route('admin.pengaturan.profil') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="pg-form-row">
                    <div class="pg-form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_user"
                            value="{{ old('nama_user', $user->nama_user) }}"
                            maxlength="35" required
                            placeholder="Nama lengkap Anda">
                        @error('nama_user')
                            <div class="pg-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="pg-form-group">
                        <label>Username</label>
                        <input type="text" name="username"
                            value="{{ old('username', $user->username) }}"
                            maxlength="25" required
                            placeholder="Username untuk login">
                        @error('username')
                            <div class="pg-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="pg-form-group">
                    <label>Role</label>
                    <input type="text" value="{{ $user->role === 'superadmin' ? 'Super Admin' : 'Admin' }}" disabled>
                    <div class="pg-field-note">Role tidak dapat diubah sendiri.</div>
                </div>

                <button type="submit" class="btn-primary" style="margin-top:4px;">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </form>
        </div>

        {{-- ── TAB: Ganti Password ── --}}
        <div id="tab-password" class="tab-content {{ $tabAktif === 'password' ? 'active' : '' }}">

            @if(session('success_password'))
                <div class="alert-success-pg">
                    <i class="fas fa-check-circle"></i> {{ session('success_password') }}
                </div>
            @endif

            @if($errors->has('password_lama'))
                <div class="alert-error-pg">
                    <i class="fas fa-exclamation-circle"></i> {{ $errors->first('password_lama') }}
                </div>
            @endif

            <form action="{{ route('admin.pengaturan.password') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="pg-form-group">
                    <label>Password Saat Ini</label>
                    <input type="password" name="password_lama"
                        placeholder="Masukkan password saat ini" required>
                </div>

                <div class="pg-form-group">
                    <label>Password Baru</label>
                    <input type="password" name="password" id="passwordBaru"
                        placeholder="Minimal 8 karakter" required
                        oninput="checkStrength(this.value)">
                    <div class="pw-strength-bar">
                        <div class="pw-strength-fill" id="strengthFill"></div>
                    </div>
                    <div class="pw-strength-label" id="strengthLabel"></div>
                    @error('password')
                        <div class="pg-field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="pg-form-group">
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation"
                        placeholder="Ulangi password baru" required>
                </div>

                <button type="submit" class="btn-primary" style="margin-top:4px;">
                    <i class="fas fa-key"></i> Ganti Password
                </button>
            </form>
        </div>

        {{-- ── TAB: Info Akun ── --}}
        <div id="tab-info" class="tab-content {{ $tabAktif === 'info' ? 'active' : '' }}">
            <p class="info-section-title">Informasi Akun</p>

            <div class="info-row">
                <span class="info-row-label">ID Akun</span>
                <span class="info-row-value">#{{ $user->id_user }}</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Nama Lengkap</span>
                <span class="info-row-value">{{ $user->nama_user }}</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Username</span>
                <span class="info-row-value">@{{ $user->username }}</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Role</span>
                <span class="info-row-value">
                    <span class="profile-role-badge {{ $user->role }}" style="margin:0;">
                        {{ $user->role === 'superadmin' ? 'Super Admin' : 'Admin' }}
                    </span>
                </span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Status</span>
                <span class="info-row-value">
                    <span class="profile-status {{ $user->status !== 'aktif' ? 'nonaktif' : '' }}">
                        {{ $user->status === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Dibuat</span>
                <span class="info-row-value">
                    {{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->translatedFormat('d F Y, H:i') : '—' }}
                </span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Terakhir Diperbarui</span>
                <span class="info-row-value">
                    {{ $user->updated_at ? \Carbon\Carbon::parse($user->updated_at)->translatedFormat('d F Y, H:i') : '—' }}
                </span>
            </div>
        </div>

    </div>{{-- end panel --}}
</div>

@endsection

@push('scripts')
<script>
    // ── Tab Switcher ──────────────────────────────
    function switchTab(name, btn) {
        document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.getElementById('tab-' + name).classList.add('active');
        btn.classList.add('active');
    }

    // ── Password Strength ─────────────────────────
    function checkStrength(val) {
        const fill  = document.getElementById('strengthFill');
        const label = document.getElementById('strengthLabel');
        let score = 0;
        if (val.length >= 8)               score++;
        if (/[A-Z]/.test(val))             score++;
        if (/[0-9]/.test(val))             score++;
        if (/[^A-Za-z0-9]/.test(val))      score++;

        const levels = [
            { pct: '0%',   color: '',                    text: '' },
            { pct: '25%',  color: 'var(--danger)',       text: 'Lemah' },
            { pct: '50%',  color: 'var(--warning)',      text: 'Cukup' },
            { pct: '75%',  color: 'var(--info)',         text: 'Kuat' },
            { pct: '100%', color: 'var(--success)',      text: 'Sangat Kuat' },
        ];

        const lvl = val.length === 0 ? levels[0] : levels[score] || levels[1];
        fill.style.width      = lvl.pct;
        fill.style.background = lvl.color;
        label.textContent     = lvl.text;
        label.style.color     = lvl.color;
    }
</script>
@endpush