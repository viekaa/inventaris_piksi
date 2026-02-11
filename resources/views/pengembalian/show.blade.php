@extends('layouts.backend')
@section('title','Detail Pengembalian')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">

            <div class="card pgs-card">
                <div class="card-body p-5">

                    @php
                        $k = match($pengembalian->kondisi_saat_kembali) {
                            'baik'            => ['bg'=>'#E8F8F0','text'=>'#2E7D32','icon'=>'check-circle',    'label'=>'Baik'],
                            'perlu_perbaikan' => ['bg'=>'#FFF8E1','text'=>'#F9A825','icon'=>'exclamation-circle','label'=>'Perlu Perbaikan'],
                            'rusak'           => ['bg'=>'#FDECEA','text'=>'#C62828','icon'=>'times-circle',    'label'=>'Rusak'],
                            default           => ['bg'=>'#ECEFF1','text'=>'#546E7A','icon'=>'info-circle',     'label'=>ucfirst($pengembalian->kondisi_saat_kembali)],
                        };
                        $kp = match($pengembalian->peminjaman->kondisi_saat_pinjam) {
                            'baik'            => ['bg'=>'#E8F8F0','text'=>'#2E7D32','label'=>'Baik'],
                            'perlu_perbaikan' => ['bg'=>'#FFF8E1','text'=>'#F9A825','label'=>'Perlu Perbaikan'],
                            'rusak'           => ['bg'=>'#FDECEA','text'=>'#C62828','label'=>'Rusak'],
                            default           => ['bg'=>'#ECEFF1','text'=>'#546E7A','label'=>ucfirst($pengembalian->peminjaman->kondisi_saat_pinjam)],
                        };
                        $durasi = \Carbon\Carbon::parse($pengembalian->peminjaman->tgl_pinjam)
                                    ->diffInDays(\Carbon\Carbon::parse($pengembalian->tgl_kembali_real));
                        // Fix jurusan: bisa object atau string
                        $jurusanName = is_object($pengembalian->peminjaman->jurusan)
                                        ? $pengembalian->peminjaman->jurusan->nama_jurusan
                                        : $pengembalian->peminjaman->jurusan;
                    @endphp

                    {{-- ===== HEADER ===== --}}
                    <div class="pgs-header">
                        <div>
                            <h4 class="pgs-title">Detail Pengembalian</h4>
                            <p class="pgs-subtitle">Informasi lengkap data pengembalian barang</p>
                        </div>
                        <span class="pgs-status-badge" style="background:{{ $k['bg'] }};color:{{ $k['text'] }};">
                            <i class="fas fa-{{ $k['icon'] }}"></i> Kondisi: {{ $k['label'] }}
                        </span>
                    </div>

                    {{-- ========================================
                         SECTION 1 — DATA PEMINJAM
                    ======================================== --}}
                    <div class="pgs-section">
                        <div class="pgs-stitle"><i class="fas fa-user"></i> Data Peminjam</div>

                        <div class="pgs-row">
                            <div class="pgs-item">
                                <div class="pgs-lbl"><i class="fas fa-user-circle"></i> Nama Peminjam</div>
                                <div class="pgs-val">{{ $pengembalian->peminjaman->nama_peminjam }}</div>
                            </div>
                            <div class="pgs-item">
                                <div class="pgs-lbl"><i class="fas fa-id-card"></i> NPM</div>
                                <div class="pgs-val">{{ $pengembalian->peminjaman->npm }}</div>
                            </div>
                        </div>

                        <div class="pgs-row">
                            <div class="pgs-item">
                                <div class="pgs-lbl"><i class="fas fa-graduation-cap"></i> Jurusan</div>
                                <div class="pgs-val">{{ $jurusanName }}</div>
                            </div>
                            <div class="pgs-item">
                                <div class="pgs-lbl"><i class="fas fa-calendar"></i> Angkatan</div>
                                <div class="pgs-val">{{ $pengembalian->peminjaman->angkatan }}</div>
                            </div>
                        </div>
                    </div>

                    {{-- ========================================
                         SECTION 2 — DATA BARANG
                    ======================================== --}}
                    <div class="pgs-section">
                        <div class="pgs-stitle"><i class="fas fa-box"></i> Data Barang yang Dikembalikan</div>

                        <div class="pgs-row">
                            <div class="pgs-item">
                                <div class="pgs-lbl"><i class="fas fa-box-open"></i> Nama Barang</div>
                                <div class="pgs-val">
                                    <span class="pgs-badge-purple">{{ $pengembalian->peminjaman->barang->nama_barang }}</span>
                                </div>
                            </div>
                            <div class="pgs-item">
                                <div class="pgs-lbl"><i class="fas fa-hashtag"></i> Jumlah Dikembalikan</div>
                                <div class="pgs-val">
                                    <span class="pgs-badge-number">{{ $pengembalian->peminjaman->jumlah }}</span>
                                    <span class="pgs-unit">unit</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ========================================
                         SECTION 3 — WAKTU
                    ======================================== --}}
                    <div class="pgs-section">
                        <div class="pgs-stitle"><i class="fas fa-calendar-alt"></i> Waktu Peminjaman & Pengembalian</div>

                        <div class="pgs-row">
                            <div class="pgs-item">
                                <div class="pgs-lbl"><i class="fas fa-calendar-check"></i> Tanggal Pinjam</div>
                                <div class="pgs-val">{{ \Carbon\Carbon::parse($pengembalian->peminjaman->tgl_pinjam)->format('d F Y') }}</div>
                            </div>
                            <div class="pgs-item">
                                <div class="pgs-lbl"><i class="fas fa-calendar-times"></i> Rencana Kembali</div>
                                <div class="pgs-val">{{ \Carbon\Carbon::parse($pengembalian->peminjaman->tgl_kembali_rencana)->format('d F Y') }}</div>
                            </div>
                        </div>

                        <div class="pgs-row">
                            <div class="pgs-item pgs-item-blue">
                                <div class="pgs-lbl"><i class="fas fa-calendar-day"></i> Tanggal Kembali Aktual</div>
                                <div class="pgs-val">
                                    <span class="pgs-badge-blue">{{ \Carbon\Carbon::parse($pengembalian->tgl_kembali_real)->format('d F Y') }}</span>
                                </div>
                            </div>
                            <div class="pgs-item">
                                <div class="pgs-lbl"><i class="fas fa-hourglass-half"></i> Lama Peminjaman</div>
                                <div class="pgs-val">
                                    <span class="pgs-badge-green">{{ $durasi }} hari</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ========================================
                         SECTION 4 — STATUS & CATATAN
                    ======================================== --}}
                    <div class="pgs-section">
                        <div class="pgs-stitle"><i class="fas fa-clock"></i> Status & Catatan</div>

                        <div class="pgs-row">
                            <div class="pgs-item">
                                <div class="pgs-lbl"><i class="fas fa-exclamation-triangle"></i> Keterlambatan</div>
                                <div class="pgs-val">
                                    @if($pengembalian->hari_telat > 0)
                                        <span class="pgs-badge-red">{{ $pengembalian->hari_telat }} hari terlambat</span>
                                    @else
                                        <span class="pgs-badge-ok"><i class="fas fa-check-circle"></i> Tepat Waktu</span>
                                    @endif
                                </div>
                            </div>
                            <div class="pgs-item">
                                <div class="pgs-lbl"><i class="fas fa-sticky-note"></i> Catatan</div>
                                <div class="pgs-val pgs-catatan">{{ $pengembalian->catatan ?: '—' }}</div>
                            </div>
                        </div>
                    </div>

                    {{-- ========================================
                         SECTION 5 — KONDISI
                    ======================================== --}}
                    <div class="pgs-section" style="margin-bottom:0;">
                        <div class="pgs-stitle"><i class="fas fa-clipboard-check"></i> Kondisi Barang</div>

                        <div class="pgs-row">
                            <div class="pgs-item pgs-center">
                                <div class="pgs-lbl" style="justify-content:center;"><i class="fas fa-sign-out-alt"></i> Saat Dipinjam</div>
                                <div class="pgs-val" style="justify-content:center;">
                                    <span class="pgs-kondisi-pill" style="background:{{ $kp['bg'] }};color:{{ $kp['text'] }};">{{ $kp['label'] }}</span>
                                </div>
                            </div>
                            <div class="pgs-item pgs-center">
                                <div class="pgs-lbl" style="justify-content:center;"><i class="fas fa-sign-in-alt"></i> Saat Dikembalikan</div>
                                <div class="pgs-val" style="justify-content:center;">
                                    <span class="pgs-kondisi-pill" style="background:{{ $k['bg'] }};color:{{ $k['text'] }};">{{ $k['label'] }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="pgs-kondisi-card" style="background:{{ $k['bg'] }};border-left:4px solid {{ $k['text'] }};">
                            <div class="pgs-kondisi-icon" style="color:{{ $k['text'] }};"><i class="fas fa-{{ $k['icon'] }}"></i></div>
                            <div>
                                <div class="pgs-kondisi-title" style="color:{{ $k['text'] }};">Kondisi Saat Dikembalikan: {{ $k['label'] }}</div>
                                <div class="pgs-kondisi-desc">
                                    @if($pengembalian->kondisi_saat_kembali == 'baik') Barang dikembalikan dalam kondisi baik dan siap digunakan kembali
                                    @elseif($pengembalian->kondisi_saat_kembali == 'perlu_perbaikan') Barang dikembalikan dalam kondisi memerlukan perbaikan
                                    @elseif($pengembalian->kondisi_saat_kembali == 'rusak') Barang dikembalikan dalam kondisi rusak dan perlu penanganan
                                    @else Kondisi barang saat dikembalikan @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ===== ACTIONS ===== --}}
                    <div class="pgs-actions">
                       @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.pengembalian.index') }}" class="pgs-btn-back">
                                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                            </a>
                        @else
                            <a href="{{ route('petugas.pengembalian.index') }}" class="pgs-btn-back">
                                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                            </a>
                        @endif

                        @if(auth()->user()->role == 'petugas')
                        <a href="{{ route('petugas.pengembalian.edit', $pengembalian->id) }}" class="pgs-btn-edit">
                            <i class="far fa-edit"></i> Edit Pengembalian
                        </a>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --pgs-primary:    #667eea;
    --pgs-purple-end: #764ba2;
    --pgs-g50:  #fafafa;
    --pgs-g100: #f3f4f6;
    --pgs-g200: #e5e7eb;
    --pgs-g300: #d1d5db;
    --pgs-g400: #9ca3af;
    --pgs-g500: #6b7280;
    --pgs-g700: #374151;
    --pgs-g800: #1f2937;
    --pgs-g900: #111827;
    --pgs-ease: cubic-bezier(0.4,0,0.2,1);
    --pgs-mono: "SF Mono", Monaco, Consolas, monospace;
}

/* ─── CARD ─── */
.pgs-card {
    border: none; border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05), 0 1px 3px rgba(0,0,0,0.06);
    overflow: hidden;
    animation: pgs-up 0.4s var(--pgs-ease);
}

/* ─── HEADER ─── */
.pgs-header {
    display: flex; justify-content: space-between; align-items: flex-start;
    padding-bottom: 28px;
    border-bottom: 2px solid var(--pgs-g100);
    margin-bottom: 40px;
}
.pgs-title {
    font-size: 26px; font-weight: 700; letter-spacing: -0.5px;
    color: var(--pgs-g900); margin: 0 0 6px;
}
.pgs-subtitle { font-size: 14px; color: var(--pgs-g500); margin: 0; }
.pgs-status-badge {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 11px 22px; border-radius: 12px;
    font-size: 14px; font-weight: 700; white-space: nowrap;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* ─── SECTION ─── */
.pgs-section { margin-bottom: 44px; }
.pgs-stitle {
    display: flex; align-items: center; gap: 10px;
    font-size: 16px; font-weight: 700; color: var(--pgs-g800);
    margin-bottom: 20px; padding-bottom: 13px;
    border-bottom: 2px solid var(--pgs-g100);
}
.pgs-stitle i { color: var(--pgs-primary); font-size: 17px; }

/* ─── ROW = dua kolom selalu sama tinggi ─── */
.pgs-row {
    display: flex;
    gap: 24px;
    margin-bottom: 20px;
    align-items: stretch; /* ← KUNCI: stretch biar sama tinggi */
}
.pgs-row:last-child { margin-bottom: 0; }

/* ─── ITEM ─── */
.pgs-item {
    flex: 1 1 0;          /* 50/50, tidak boleh lebih atau kurang */
    min-width: 0;
    background: var(--pgs-g50);
    border: 1.5px solid var(--pgs-g200);
    border-radius: 12px;
    padding: 20px 24px;
    min-height: 86px;
    display: flex; flex-direction: column; justify-content: center;
    transition: all 0.2s var(--pgs-ease);
}
.pgs-item:hover {
    background: #fff; border-color: var(--pgs-g300);
    box-shadow: 0 4px 14px rgba(0,0,0,0.06);
    transform: translateY(-2px);
}
.pgs-item-blue {
    background: linear-gradient(135deg,#eff6ff,#dbeafe) !important;
    border: 2px solid #93c5fd !important;
}
.pgs-center { text-align: center; align-items: center; }

.pgs-lbl {
    display: flex; align-items: center; gap: 7px;
    font-size: 11px; font-weight: 700; color: var(--pgs-g400);
    text-transform: uppercase; letter-spacing: 0.6px;
    margin-bottom: 10px;
}
.pgs-lbl i { font-size: 11px; }

.pgs-val {
    font-size: 15px; font-weight: 600; color: var(--pgs-g900);
    display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
}
.pgs-catatan { font-weight: 400; font-size: 14px; color: var(--pgs-g700); line-height: 1.6; }
.pgs-unit { font-size: 13px; color: var(--pgs-g400); font-weight: 400; }

/* ─── BADGES ─── */
.pgs-badge-purple {
    display: inline-block; padding: 7px 16px;
    background: linear-gradient(135deg,var(--pgs-primary),var(--pgs-purple-end));
    color:#fff; border-radius:8px; font-size:13px; font-weight:600;
}
.pgs-badge-number {
    display:inline-flex; align-items:center; justify-content:center;
    min-width:52px; padding:8px 16px;
    background: linear-gradient(135deg,var(--pgs-primary),var(--pgs-purple-end));
    color:#fff; border-radius:10px;
    font-size:20px; font-weight:700; font-family:var(--pgs-mono);
    box-shadow:0 4px 12px rgba(102,126,234,0.3);
}
.pgs-badge-blue {
    display:inline-block; padding:7px 16px;
    background:linear-gradient(135deg,#3b82f6,#2563eb);
    color:#fff; border-radius:8px; font-size:13px; font-weight:700;
}
.pgs-badge-green {
    display:inline-block; padding:7px 16px;
    background:linear-gradient(135deg,#10b981,#059669);
    color:#fff; border-radius:8px; font-size:13px; font-weight:700;
}
.pgs-badge-red {
    display:inline-block; padding:7px 16px;
    background:#FDECEA; color:#C62828;
    border-radius:8px; font-size:13px; font-weight:700;
}
.pgs-badge-ok {
    display:inline-flex; align-items:center; gap:6px; padding:7px 16px;
    background:#E8F8F0; color:#2E7D32;
    border-radius:20px; font-size:13px; font-weight:700;
}
.pgs-kondisi-pill {
    display:inline-block; padding:8px 22px;
    border-radius:20px; font-size:13px; font-weight:700;
}

/* ─── KONDISI CARD ─── */
.pgs-kondisi-card {
    display:flex; align-items:flex-start; gap:20px;
    padding:24px; border-radius:12px; margin-top:20px;
    transition: transform 0.3s var(--pgs-ease), box-shadow 0.3s var(--pgs-ease);
}
.pgs-kondisi-card:hover { transform:translateX(4px); box-shadow:0 4px 16px rgba(0,0,0,0.08); }
.pgs-kondisi-icon { font-size:44px; opacity:.85; line-height:1; flex-shrink:0; }
.pgs-kondisi-title { font-size:17px; font-weight:700; margin-bottom:6px; }
.pgs-kondisi-desc { font-size:14px; color:var(--pgs-g700); line-height:1.6; }

/* ─── ACTIONS ─── */
.pgs-actions {
    display:flex; gap:12px;
    justify-content:space-between; align-items:center;
    margin-top:44px; padding-top:28px;
    border-top:2px solid var(--pgs-g100);
}
.pgs-btn-back {
    display:inline-flex; align-items:center; gap:8px;
    padding:12px 24px; background:#fff; color:var(--pgs-g700);
    border:1.5px solid var(--pgs-g300); border-radius:10px;
    font-size:14px; font-weight:600; text-decoration:none;
    transition:all 0.25s var(--pgs-ease);
}
.pgs-btn-back:hover {
    color:var(--pgs-g900); border-color:var(--pgs-g400);
    background:var(--pgs-g50); transform:translateX(-2px);
    box-shadow:0 4px 12px rgba(0,0,0,0.1);
}
.pgs-btn-edit {
    display:inline-flex; align-items:center; gap:8px;
    padding:12px 28px;
    background:linear-gradient(135deg,var(--pgs-primary),var(--pgs-purple-end));
    color:#fff; border-radius:10px;
    font-size:14px; font-weight:600; text-decoration:none;
    transition:all 0.25s var(--pgs-ease);
    box-shadow:0 4px 12px rgba(102,126,234,0.3);
}
.pgs-btn-edit:hover {
    color:#fff; transform:translateY(-2px);
    box-shadow:0 8px 20px rgba(102,126,234,0.4);
}

@keyframes pgs-up {
    from { opacity:0; transform:translateY(16px); }
    to   { opacity:1; transform:translateY(0); }
}

@media (max-width:768px) {
    .pgs-header { flex-direction:column; gap:16px; }
    .pgs-title  { font-size:20px; }
    .pgs-row    { flex-direction:column; gap:14px; }
    .pgs-actions { flex-direction:column; }
    .pgs-btn-back, .pgs-btn-edit { width:100%; justify-content:center; }
    .pgs-kondisi-card { flex-direction:column; }
}
</style>

@endsection
