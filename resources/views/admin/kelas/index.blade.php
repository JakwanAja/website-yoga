@extends('layouts.admin')

@section('title', 'Manajemen Kelas')
@section('page-title', 'Manajemen Kelas')

@section('styles')
    <link rel="stylesheet" href="/css/dashboard.css">
    <link rel="stylesheet" href="/css/booking.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .kelas-thumb {
            width: 72px;
            height: 56px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="bk-summary">
            <div class="bk-stat-card">
                <div class="bk-stat-icon" style="background:rgba(166,124,115,0.12);color:var(--primary)">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div>
                    <div class="bk-stat-value">{{ $total }}</div>
                    <div class="bk-stat-label">Total Kelas</div>
                </div>
            </div>
            <div class="bk-stat-card">
                <div class="bk-stat-icon" style="background:rgba(122,158,181,0.12);color:var(--info)">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div>
                    <div class="bk-stat-value">{{ $instrukturCount ?? '—' }}</div>
                    <div class="bk-stat-label">Instruktur</div>
                </div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-header">
                <div class="panel-title">
                    <i class="fas fa-layer-group" style="color:var(--primary);margin-right:8px;font-size:16px"></i>
                    Daftar Kelas
                </div>

                <form method="GET" action="{{ route('admin.kelas') }}" class="bk-filter-bar">
                    <div class="bk-search-wrap">
                        <i class="fas fa-search bk-search-icon"></i>
                        <input type="text" name="search" placeholder="Cari nama, instruktur..."
                            value="{{ request('search') }}" class="bk-search-input">
                    </div>

                    <select name="instruktur" class="bk-select">
                        <option value="">Semua Instruktur</option>
                        @foreach(\App\Models\Kelas::select('instruktur')->distinct()->pluck('instruktur') as $inst)
                            <option value="{{ $inst }}" {{ request('instruktur') == $inst ? 'selected' : '' }}>{{ $inst }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn-primary">
                        <i class="fas fa-search"></i> Filter
                    </button>

                    <button type="button" class="btn-primary" onclick="openAddModal()" style="display:flex;align-items:center;gap:8px">
                        <i class="fas fa-plus"></i> Tambah Kelas
                    </button>

                    @if(request('search') || request('instruktur'))
                        <a href="{{ route('admin.kelas') }}" class="bk-reset-btn">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    @endif
                </form>
            </div>

            <div class="bk-table-wrap">
                @if($kelas->isEmpty())
                    <div class="bk-empty">
                        <i class="fas fa-layer-group"></i>
                        <p>Tidak ada data kelas ditemukan.</p>
                        @if(request('search') || request('instruktur'))
                            <a href="{{ route('admin.kelas') }}" class="btn-primary" style="margin-top:12px">
                                Lihat Semua Kelas
                            </a>
                        @endif
                    </div>
                @else
                    <table class="booking-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Gambar</th>
                                <th>Nama Kelas</th>
                                <th>Instruktur</th>
                                <th>Biaya</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kelas as $i => $k)
                                <tr>
                                    <td class="bk-num">{{ $kelas->firstItem() + $i }}</td>
                                    <td>
                                        @if($k->foto)
                                            <img src="{{ url('uploads/kelas/' . $k->foto) }}" alt="" class="kelas-thumb" />
                                        @else
                                            <div class="text-muted">—</div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="bk-peserta">
                                            <div class="bk-avatar">{{ strtoupper(substr($k->nama_kelas, 0, 1)) }}</div>
                                            <span>{{ $k->nama_kelas }}</span>
                                        </div>
                                        <div class="bk-jam" style="margin-top:6px">
                                            {{ \Illuminate\Support\Str::limit($k->deskripsi, 80) }}</div>
                                    </td>
                                    <td class="bk-email">{{ $k->instruktur }}</td>
                                    <td>{{ $k->biaya_rp ?? ('Rp ' . number_format($k->biaya, 0, ',', '.')) }}</td>
                                    <td>
                                        <div class="bk-actions">
                                            <a href="{{ route('admin.kelas.edit', $k->id_kelas) }}" class="bk-btn-edit"
                                                title="Edit Kelas">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <button onclick="confirmDelete({{ $k->id_kelas }}, '{{ addslashes($k->nama_kelas) }}')"
                                                class="bk-btn-delete" title="Hapus Kelas">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <form id="delete-form-{{ $k->id_kelas }}" action="{{ route('admin.kelas.destroy', $k->id_kelas) }}"
                                                method="POST" style="display:none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            @if($kelas->hasPages())
                <div class="bk-pagination">
                    <div class="bk-pag-info">
                        Menampilkan {{ $kelas->firstItem() }}–{{ $kelas->lastItem() }} dari {{ $kelas->total() }} data
                    </div>
                    <div class="bk-pag-links">
                        @if($kelas->onFirstPage())
                            <span class="bk-pag-btn disabled"><i class="fas fa-chevron-left"></i></span>
                        @else
                            <a href="{{ $kelas->previousPageUrl() }}" class="bk-pag-btn"><i class="fas fa-chevron-left"></i></a>
                        @endif

                        @foreach($kelas->getUrlRange(1, $kelas->lastPage()) as $page => $url)
                            @if($page == $kelas->currentPage())
                                <span class="bk-pag-btn active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="bk-pag-btn">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if($kelas->hasMorePages())
                            <a href="{{ $kelas->nextPageUrl() }}" class="bk-pag-btn"><i class="fas fa-chevron-right"></i></a>
                        @else
                            <span class="bk-pag-btn disabled"><i class="fas fa-chevron-right"></i></span>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        {{-- Modal Konfirmasi Hapus --}}
        <div id="modal-delete" class="bk-modal-overlay" onclick="closeModal()">
            <div class="bk-modal" onclick="event.stopPropagation()">
                <div class="bk-modal-icon"><i class="fas fa-trash-alt"></i></div>
                <h3 class="bk-modal-title">Hapus Kelas?</h3>
                <p class="bk-modal-desc">
                    Data kelas <strong id="modal-nama"></strong> akan dihapus permanen.
                </p>
                <div class="bk-modal-actions">
                    <button onclick="closeModal()" class="bk-modal-cancel">Batal</button>
                    <button onclick="doDelete()" class="bk-modal-confirm">
                        <i class="fas fa-trash-alt"></i> Ya, Hapus
                    </button>
                </div>
            </div>
        </div>

        {{-- Modal Tambah Kelas --}}
        <div id="modal-add" class="bk-modal-overlay" onclick="closeAddModal()">
            <div class="bk-modal" onclick="event.stopPropagation()" style="max-width:720px;">
                <h3 class="bk-modal-title">Tambah Kelas</h3>
                <div class="bk-edit-body">
                    <form id="add-kelas-form" action="{{ route('admin.kelas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="bk-field">
                            <label class="bk-label"><i class="fas fa-image"></i> Gambar</label>
                            <input type="file" name="foto" class="bk-input">
                            @error('foto') <div class="bk-field-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="bk-field">
                            <label class="bk-label"><i class="fas fa-heading"></i> Nama Yoga</label>
                            <input type="text" name="nama_kelas" class="bk-input" value="{{ old('nama_kelas') }}" required>
                            @error('nama_kelas') <div class="bk-field-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="bk-field">
                            <label class="bk-label"><i class="fas fa-align-left"></i> Keterangan</label>
                            <textarea name="deskripsi" class="bk-input" rows="4" required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi') <div class="bk-field-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="bk-field">
                            <label class="bk-label"><i class="fas fa-chalkboard-teacher"></i> Nama Instruktur</label>
                            <input type="text" name="instruktur" class="bk-input" value="{{ old('instruktur') }}" required>
                            @error('instruktur') <div class="bk-field-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="bk-field">
                            <label class="bk-label"><i class="fas fa-money-bill-wave"></i> Biaya</label>
                            <input type="number" step="0.01" name="biaya" class="bk-input" value="{{ old('biaya', 0) }}" required>
                            @error('biaya') <div class="bk-field-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="bk-field">
                            <label class="bk-label"><i class="fas fa-users"></i> Kuota (per kelas)</label>
                            <input type="number" name="kuota" class="bk-input" value="{{ old('kuota', 0) }}" min="0">
                            @error('kuota') <div class="bk-field-error">{{ $message }}</div> @enderror
                        </div>

                        <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:18px">
                            <button type="button" class="bk-btn-cancel" onclick="closeAddModal()">Batal</button>
                            <button type="submit" class="bk-modal-confirm"><i class="fas fa-plus"></i> Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Delete modal handling (same as booking view)
        let targetFormId = null;

        function confirmDelete(id, nama) {
            targetFormId = id;
            document.getElementById('modal-nama').textContent = nama;
            document.getElementById('modal-delete').classList.add('show');
        }

        function closeModal() {
            document.getElementById('modal-delete').classList.remove('show');
            targetFormId = null;
        }

        function doDelete() {
            if (targetFormId) document.getElementById('delete-form-' + targetFormId).submit();
        }

        // Auto-dismiss flash
        setTimeout(() => {
            document.querySelectorAll('.alert-success, .alert-error')
                .forEach(el => el.style.opacity = '0');
        }, 4000);
        
        // Add modal handling
        function openAddModal() {
            document.getElementById('modal-add').classList.add('show');
        }

        function closeAddModal() {
            document.getElementById('modal-add').classList.remove('show');
        }

    </script>
@endpush