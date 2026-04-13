@extends('layouts.backend')
@section('title','Detail Barang')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">

            <div class="card detail-card">
                <div class="card-body p-4">

                    {{-- ===== HEADER ===== --}}
                    <div class="detail-header">
                        <div>
                            <h4 class="detail-title">Detail Barang</h4>
                            <p class="detail-subtitle">Informasi lengkap tentang barang</p>
                        </div>
                        @php
                            $badge = match($barang->kondisi) {
                                'baik'            => ['bg' => '#edf7f0', 'border' => '#b8e6c8', 'text' => '#1e7e3e', 'icon' => 'check-circle',      'label' => 'Baik'],
                                'perlu_perbaikan' => ['bg' => '#fff8e1', 'border' => '#ffe082', 'text' => '#e65100', 'icon' => 'exclamation-circle', 'label' => 'Perlu Perbaikan'],
                                'rusak'           => ['bg' => '#fdecea', 'border' => '#f5a8a8', 'text' => '#c62828', 'icon' => 'times-circle',       'label' => 'Rusak'],
                                default           => ['bg' => '#eceff1', 'border' => '#cfd8dc', 'text' => '#546e7a', 'icon' => 'info-circle',        'label' => ucfirst($barang->kondisi)],
                            };
                        @endphp
                        <span class="status-badge" style="background:{{ $badge['bg'] }};color:{{ $badge['text'] }};border-color:{{ $badge['border'] }};">
                            <i class="fas fa-{{ $badge['icon'] }}"></i>
                            {{ $badge['label'] }}
                        </span>
                    </div>

                    {{-- ===== INFORMASI UTAMA ===== --}}
                    <div class="section-label">
                        <span class="section-icon" style="background:#ebf0fd;">
                            <i class="fas fa-info-circle" style="color:#3b5de7;"></i>
                        </span>
                        Informasi Utama
                    </div>

                    <div class="top-grid mb-4">
                        {{-- Foto --}}
                        <div class="img-box">
                            @if($barang->foto)
                                <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}" class="detail-img">
                            @else
                                <div class="no-img">
                                    <i class="fas fa-camera fa-2x"></i>
                                    <span>Tidak ada foto</span>
                                </div>
                            @endif
                        </div>

                        {{-- Info Grid --}}
                        <div class="info-grid">
                            <div class="info-item">
                                <label><i class="fas fa-box me-1"></i> Nama Barang</label>
                                <div class="val">{{ $barang->nama_barang }}</div>
                            </div>
                            <div class="info-item">
                                <label><i class="fas fa-tags me-1"></i> Kategori</label>
                                <div class="val">
                                    <span class="pill-kat">{{ $barang->kategori->nama_kategori }}</span>
                                </div>
                            </div>
                            <div class="info-item">
                                <label><i class="fas fa-map-marker-alt me-1"></i> Lokasi</label>
                                <div class="val">{{ $barang->lokasi->nama_lokasi }}</div>
                            </div>
                            <div class="info-item">
                                <label><i class="fas fa-building me-1"></i> Bidang</label>
                                <div class="val">{{ $barang->bidang->nama_bidang }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="section-divider"></div>

                    {{-- ===== INFORMASI STOK ===== --}}
                    <div class="section-label">
                        <span class="section-icon" style="background:#f0ebfd;">
                            <i class="fas fa-cubes" style="color:#764ba2;"></i>
                        </span>
                        Informasi Stok
                    </div>

                    <div class="stok-grid mb-3">
                        <div class="stok-card">
                            <label><i class="fas fa-hashtag me-1"></i> Jumlah Total</label>
                            <div class="stok-num-row">
                                <span class="num-badge">{{ $barang->jumlah_total }}</span>
                                <span class="stok-unit">unit</span>
                            </div>
                        </div>
                        <div class="stok-card">
                            <label><i class="fas fa-layer-group me-1"></i> Stok Tersedia</label>
                            <div class="stok-num-row">
                                <span class="num-badge">{{ $barang->stok }}</span>
                                <span class="stok-unit">unit</span>
                            </div>
                        </div>
                    </div>

                    @php
                        $percentage = $barang->jumlah_total > 0
                            ? round(($barang->stok / $barang->jumlah_total) * 100)
                            : 0;
                        $terpakai = $barang->jumlah_total - $barang->stok;
                    @endphp

                    <div class="bar-card mb-4">
                        <div class="bar-top">
                            <span>Penggunaan Stok</span>
                            <strong>{{ $percentage }}%</strong>
                        </div>
                        <div class="bar-track">
                            <div class="bar-fill" style="width:{{ $percentage }}%"></div>
                        </div>
                        <div class="bar-meta">
                            <span class="txt-g"><span class="dot dot-g"></span> Tersedia: {{ $barang->stok }}</span>
                            <span class="txt-o"><span class="dot dot-o"></span> Terpakai: {{ $terpakai }}</span>
                        </div>
                    </div>

                    <div class="section-divider"></div>

                    {{-- ===== KONDISI BARANG ===== --}}
                    <div class="section-label">
                        <span class="section-icon" style="background:#edf7f0;">
                            <i class="fas fa-clipboard-check" style="color:#1e7e3e;"></i>
                        </span>
                        Kondisi Barang
                    </div>

                    <div class="kondisi-wrap mb-4"
                         style="background:{{ $badge['bg'] }};border-color:{{ $badge['border'] }};border-left-color:{{ $badge['text'] }};">
                        <div class="kondisi-icon-wrap" style="background:{{ $badge['border'] }};">
                            <i class="fas fa-{{ $badge['icon'] }}" style="color:{{ $badge['text'] }};font-size:18px;"></i>
                        </div>
                        <div>
                            <div class="kondisi-title" style="color:{{ $badge['text'] }};">{{ $badge['label'] }}</div>
                            <div class="kondisi-desc" style="color:{{ $badge['text'] }};opacity:.8;">
                                @if($barang->kondisi == 'baik') Barang dalam kondisi baik dan siap digunakan.
                                @elseif($barang->kondisi == 'perlu_perbaikan') Barang memerlukan pemeliharaan rutin.
                                @elseif($barang->kondisi == 'rusak') Barang rusak dan perlu penggantian.
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- ===== ACTIONS ===== --}}
                    <div class="detail-actions">
                        <a href="{{ route('barang.index') }}" class="btn-back">
                            <i class="fas fa-arrow-left me-2"></i>&nbsp; Kembali
                        </a>
                        <a href="{{ route('barang.edit', $barang->id) }}" class="btn-edit text-decoration-none">
                            <i class="far fa-edit me-2"></i> &nbsp;Edit Barang
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<style>
/* =====================
   FONT & BASE
   ===================== */
.detail-card,
.detail-card * {
    font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
}

/* =====================
   CARD
   ===================== */
.detail-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 2px 16px rgba(0,0,0,0.07);
    overflow: hidden;
}

/* =====================
   HEADER
   ===================== */
.detail-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding-bottom: 22px;
    border-bottom: 1.5px solid #f0f2f7;
    margin-bottom: 24px;
}
.detail-title {
    font-size: 18px;
    font-weight: 700;
    color: #1a1d2e;
    margin: 0 0 4px;
}
.detail-subtitle {
    font-size: 13px;
    color: #8a92a6;
    margin: 0;
}
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 7px 16px;
    border-radius: 24px;
    font-size: 13px;
    font-weight: 600;
    border: 1px solid transparent;
}

/* =====================
   SECTION LABEL
   ===================== */
.section-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    font-weight: 700;
    color: #4a5568;
    text-transform: uppercase;
    letter-spacing: .6px;
    margin-bottom: 16px;
}
.section-icon {
    width: 28px;
    height: 28px;
    border-radius: 7px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 14px;
}
.section-divider {
    height: 1.5px;
    background: #f0f2f7;
    margin: 22px 0;
}

/* =====================
   TOP GRID (foto + info)
   ===================== */
.top-grid {
    display: grid;
    grid-template-columns: 240px 1fr;
    gap: 24px;
}
.img-box {
    background: #f7f8fc;
    border-radius: 14px;
    border: 1.5px solid #e8eaf0;
    height: 220px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}
.detail-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 12px;
}
.no-img {
    color: #b0b8cc;
    font-size: 13px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}

/* =====================
   INFO GRID
   ===================== */
.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}
.info-item {
    background: #f7f8fc;
    border-radius: 12px;
    border: 1.5px solid #ebedf5;
    padding: 14px 16px;
}
.info-item label {
    font-size: 10px;
    font-weight: 700;
    color: #9aa0b4;
    text-transform: uppercase;
    letter-spacing: .5px;
    display: block;
    margin-bottom: 7px;
}
.info-item .val {
    font-size: 14px;
    font-weight: 600;
    color: #1a1d2e;
}
.pill-kat {
    background: #ebf0fd;
    color: #3b5de7;
    padding: 3px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

/* =====================
   STOK
   ===================== */
.stok-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
.stok-card {
    background: #f7f8fc;
    border-radius: 12px;
    border: 1.5px solid #ebedf5;
    padding: 16px 18px;
}
.stok-card label {
    font-size: 10px;
    font-weight: 700;
    color: #9aa0b4;
    text-transform: uppercase;
    letter-spacing: .5px;
    display: block;
    margin-bottom: 10px;
}
.stok-num-row {
    display: flex;
    align-items: baseline;
    gap: 7px;
}
.num-badge {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: #fff;
    font-size: 14px;
    font-weight: 700;
    padding: 4px 14px;
    border-radius: 8px;
}
.stok-unit {
    font-size: 13px;
    color: #9aa0b4;
    font-weight: 500;
}

/* =====================
   PROGRESS BAR
   ===================== */
.bar-card {
    background: #f7f8fc;
    border-radius: 12px;
    border: 1.5px solid #ebedf5;
    padding: 18px 20px;
}
.bar-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}
.bar-top span {
    font-size: 13px;
    font-weight: 600;
    color: #4a5568;
}
.bar-top strong {
    font-size: 13px;
    font-weight: 700;
    color: #667eea;
}
.bar-track {
    height: 8px;
    background: #e2e6f0;
    border-radius: 8px;
    overflow: hidden;
}
.bar-fill {
    height: 100%;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 8px;
    transition: width .5s ease;
}
.bar-meta {
    display: flex;
    gap: 20px;
    margin-top: 12px;
}
.bar-meta span {
    font-size: 12px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 6px;
}
.dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    flex-shrink: 0;
}
.dot-g  { background: #22c55e; }
.dot-o  { background: #f59e0b; }
.txt-g  { color: #16a34a; }
.txt-o  { color: #d97706; }

/* =====================
   KONDISI
   ===================== */
.kondisi-wrap {
    display: flex;
    align-items: center;
    gap: 18px;
    border: 1.5px solid transparent;
    border-left-width: 5px;
    border-radius: 12px;
    padding: 18px 22px;
}
.kondisi-icon-wrap {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.kondisi-title {
    font-size: 15px;
    font-weight: 700;
    margin-bottom: 4px;
}
.kondisi-desc {
    font-size: 13px;
    font-weight: 400;
}

/* =====================
   ACTIONS
   ===================== */
.detail-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 22px;
    border-top: 1.5px solid #f0f2f7;
}
.btn-back {
    font-size: 13px;
    font-weight: 600;
    color: #6b7280;
    border: 1.5px solid #dde0ea;
    border-radius: 10px;
    padding: 9px 20px;
    background: #fff;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: background .15s;
}
.btn-back:hover { background: #f7f8fc; color: #374151; }
.btn-edit {
    font-size: 13px;
    font-weight: 600;
    color: #fff !important;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border: none;
    border-radius: 10px;
    padding: 10px 24px;
    display: inline-flex;
    align-items: center;
    box-shadow: 0 4px 14px rgba(102,126,234,0.35);
    transition: opacity .15s;
}
.btn-edit:hover { opacity: .9; }

/* =====================
   RESPONSIVE
   ===================== */
@media (max-width: 768px) {
    .top-grid { grid-template-columns: 1fr; }
    .img-box  { height: 180px; }
    .stok-grid { grid-template-columns: 1fr; }
    .detail-header { flex-direction: column; gap: 14px; }
}
</style>

@endsection
