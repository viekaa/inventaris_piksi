@extends('layouts.backend')
@section('title','Detail Barang')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">

            <!-- Detail Card -->
            <div class="card custom-card">
                <div class="card-body p-4">

                    <!-- Header -->
                    <div class="detail-header">
                        <div>
                            <h4 class="detail-title">Detail Barang</h4>
                            <p class="detail-subtitle">Informasi lengkap tentang barang</p>
                        </div>
                        <div class="header-badge">
                            @php
                                $badge = match($barang->kondisi) {
                                    'baik'            => ['bg' => '#E8F8F0', 'text' => '#2E7D32', 'icon' => 'check-circle', 'label' => 'Baik'],
                                    'perlu_perbaikan' => ['bg' => '#FFF8E1', 'text' => '#F9A825', 'icon' => 'exclamation-circle', 'label' => 'Perlu Perbaikan'],
                                    'rusak'           => ['bg' => '#FDECEA', 'text' => '#C62828', 'icon' => 'times-circle', 'label' => 'Rusak'],
                                    default           => ['bg' => '#ECEFF1', 'text' => '#546E7A', 'icon' => 'info-circle', 'label' => ucfirst($barang->kondisi)],
                                };
                            @endphp
                            <span class="status-badge" style="background: {{ $badge['bg'] }}; color: {{ $badge['text'] }};">
                                <i class="fas fa-{{ $badge['icon'] }}"></i>
                                {{ $badge['label'] }}
                            </span>
                        </div>
                    </div>

                    <!-- Detail Content -->
                    <div class="detail-content">

                        <!-- Informasi Utama -->
                        <div class="detail-section">
                            <h5 class="section-title">
                                <i class="fas fa-info-circle"></i>
                                Informasi Utama
                            </h5>
                            <div class="row g-5">
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <label class="detail-label">
                                            <i class="fas fa-box"></i>
                                            Nama Barang
                                        </label>
                                        <div class="detail-value">{{ $barang->nama_barang }}</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <label class="detail-label">
                                            <i class="fas fa-tags"></i>
                                            Kategori
                                        </label>
                                        <div class="detail-value">
                                            <span class="badge-kategori">{{ $barang->kategori->nama_kategori }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <label class="detail-label">
                                            <i class="fas fa-map-marker-alt"></i>
                                            Lokasi
                                        </label>
                                        <div class="detail-value">{{ $barang->lokasi->nama_lokasi }}</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <label class="detail-label">
                                            <i class="fas fa-building"></i>
                                            Bidang
                                        </label>
                                        <div class="detail-value">{{ $barang->bidang->nama_bidang }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Stok -->
                        <div class="detail-section">
                            <h5 class="section-title">
                                <i class="fas fa-cubes"></i>
                                Informasi Stok
                            </h5>
                            <div class="row g-5">
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <label class="detail-label">
                                            <i class="fas fa-hashtag"></i>
                                            Jumlah Total
                                        </label>
                                        <div class="detail-value">
                                            <span class="badge-number">{{ $barang->jumlah_total }}</span>
                                            <span class="unit-text">unit</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <label class="detail-label">
                                            <i class="fas fa-layer-group"></i>
                                            Stok Tersedia
                                        </label>
                                        <div class="detail-value">
                                            <span class="badge-number">{{ $barang->stok }}</span>
                                            <span class="unit-text">unit</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Stock Bar Visualization -->
                                <div class="col-12">
                                    <div class="stock-visualization">
                                        <div class="stock-label-group">
                                            <span class="stock-label">Penggunaan Stok</span>
                                            <span class="stock-percentage">
                                                @php
                                                    $percentage = $barang->jumlah_total > 0
                                                        ? round(($barang->stok / $barang->jumlah_total) * 100)
                                                        : 0;
                                                @endphp
                                                {{ $percentage }}%
                                            </span>
                                        </div>
                                        <div class="stock-bar">
                                            <div class="stock-bar-fill" style="width: {{ $percentage }}%">
                                            </div>
                                        </div>
                                        <div class="stock-info">
                                            <span class="stock-info-item">
                                                <i class="fas fa-check-circle text-success"></i>
                                                Tersedia: {{ $barang->stok }}
                                            </span>
                                            <span class="stock-info-item">
                                                <i class="fas fa-arrow-circle-right text-warning"></i>
                                                Terpakai: {{ $barang->jumlah_total - $barang->stok }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Kondisi -->
                        <div class="detail-section">
                            <h5 class="section-title">
                                <i class="fas fa-clipboard-check"></i>
                                Kondisi Barang
                            </h5>
                            <div class="row g-5">
                                <div class="col-12">
                                    <div class="kondisi-card" style="background: {{ $badge['bg'] }}; border-left: 4px solid {{ $badge['text'] }};">
                                        <div class="kondisi-icon" style="color: {{ $badge['text'] }};">
                                            <i class="fas fa-{{ $badge['icon'] }}"></i>
                                        </div>
                                        <div class="kondisi-content">
                                            <div class="kondisi-status" style="color: {{ $badge['text'] }};">
                                                {{ $badge['label'] }}
                                            </div>
                                            <div class="kondisi-description">
                                                @if($barang->kondisi == 'baik')
                                                    Barang dalam kondisi baik dan siap digunakan
                                                @elseif($barang->kondisi == 'perlu_perbaikan')
                                                    Barang memerlukan perbaikan atau pemeliharaan
                                                @elseif($barang->kondisi == 'rusak')
                                                    Barang rusak dan memerlukan penggantian atau perbaikan serius
                                                @else
                                                    Status kondisi barang
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Action Buttons -->
                    <div class="detail-actions">
                        <a href="{{ route('barang.index') }}" class="btn-back">
                            <i class="fas fa-arrow-left"></i>
                            <span>Kembali ke Daftar</span>
                        </a>
                        <div class="detail-actions-right">
                            <a href="{{ route('barang.edit', $barang->id) }}" class="btn-edit">
                                <i class="far fa-edit"></i>
                                <span>Edit Barang</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<style>
/* ===== TYPOGRAPHY ===== */
:root {
    --font-primary: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    --font-mono: "SF Mono", Monaco, "Cascadia Code", "Roboto Mono", Consolas, monospace;
    --color-primary: #667eea;
    --color-primary-dark: #5568d3;
    --color-success: #10b981;
    --color-danger: #ef4444;
    --color-warning: #f59e0b;
    --color-info: #17a2b8;
    --color-gray-50: #fafafa;
    --color-gray-100: #f3f4f6;
    --color-gray-200: #e5e7eb;
    --color-gray-300: #d1d5db;
    --color-gray-400: #9ca3af;
    --color-gray-500: #6b7280;
    --color-gray-600: #4b5563;
    --color-gray-700: #374151;
    --color-gray-800: #1f2937;
    --color-gray-900: #111827;
}

body {
    font-family: var(--font-primary);
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* ===== CARD ===== */
.custom-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04), 0 1px 2px rgba(0, 0, 0, 0.06);
    transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    animation: slideUp 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

/* ===== DETAIL HEADER ===== */
.detail-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 24px;
    border-bottom: 2px solid var(--color-gray-100);
    margin-bottom: 32px;
}

.detail-title {
    font-size: 24px;
    font-weight: 700;
    letter-spacing: -0.5px;
    color: var(--color-gray-900);
    margin: 0 0 6px 0;
}

.detail-subtitle {
    font-size: 14px;
    color: var(--color-gray-500);
    margin: 0;
    font-weight: 400;
}

.header-badge {
    display: flex;
    align-items: center;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 700;
    letter-spacing: 0.3px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.status-badge i {
    font-size: 16px;
}

/* ===== DETAIL CONTENT ===== */
.detail-content {
    padding-top: 8px;
}

.detail-section {
    margin-bottom: 40px;
}

.detail-section:last-child {
    margin-bottom: 0;
}

.section-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 16px;
    font-weight: 700;
    color: var(--color-gray-800);
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 2px solid var(--color-gray-100);
}

.section-title i {
    color: var(--color-primary);
    font-size: 18px;
}

/* ===== DETAIL ITEMS ===== */
.detail-item {
    background: var(--color-gray-50);
    padding: 18px 20px;
    border-radius: 12px;
    border: 1px solid var(--color-gray-200);
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
}

.detail-item:hover {
    background: #fff;
    border-color: var(--color-gray-300);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    transform: translateY(-2px);
}

.detail-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    font-weight: 600;
    color: var(--color-gray-500);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 10px;
}

.detail-label i {
    font-size: 13px;
    color: var(--color-gray-400);
}

.detail-value {
    font-size: 15px;
    font-weight: 600;
    color: var(--color-gray-900);
    display: flex;
    align-items: center;
    gap: 8px;
}

/* ===== BADGES ===== */
.badge-kategori {
    display: inline-block;
    padding: 6px 14px;
    background: linear-gradient(135deg, var(--color-primary) 0%, #764ba2 100%);
    color: #fff;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 0.2px;
}

.badge-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 60px;
    padding: 8px 16px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    border-radius: 10px;
    font-size: 18px;
    font-weight: 700;
    font-family: var(--font-mono);
    letter-spacing: 0.5px;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
}

.unit-text {
    font-size: 13px;
    color: var(--color-gray-500);
    font-weight: 500;
}

/* ===== STOCK VISUALIZATION ===== */
.stock-visualization {
    background: var(--color-gray-50);
    padding: 24px;
    border-radius: 12px;
    border: 1px solid var(--color-gray-200);
}

.stock-label-group {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

.stock-label {
    font-size: 13px;
    font-weight: 600;
    color: var(--color-gray-700);
}

.stock-percentage {
    font-size: 16px;
    font-weight: 700;
    color: var(--color-primary);
    font-family: var(--font-mono);
}

.stock-bar {
    width: 100%;
    height: 12px;
    background: var(--color-gray-200);
    border-radius: 999px;
    overflow: hidden;
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.06);
}

.stock-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    border-radius: 999px;
    transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.4);
}

.stock-info {
    display: flex;
    gap: 24px;
    margin-top: 12px;
}

.stock-info-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    font-weight: 500;
    color: var(--color-gray-700);
}

.stock-info-item i {
    font-size: 14px;
}

/* ===== KONDISI CARD ===== */
.kondisi-card {
    display: flex;
    gap: 20px;
    padding: 24px;
    border-radius: 12px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.kondisi-card:hover {
    transform: translateX(4px);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
}

.kondisi-icon {
    font-size: 48px;
    line-height: 1;
    opacity: 0.8;
}

.kondisi-content {
    flex: 1;
}

.kondisi-status {
    font-size: 20px;
    font-weight: 700;
    letter-spacing: 0.3px;
    margin-bottom: 6px;
}

.kondisi-description {
    font-size: 14px;
    color: var(--color-gray-700);
    font-weight: 400;
    line-height: 1.5;
}

/* ===== DETAIL ACTIONS ===== */
.detail-actions {
    display: flex;
    gap: 12px;
    justify-content: space-between;
    align-items: center;
    margin-top: 40px;
    padding-top: 24px;
    border-top: 2px solid var(--color-gray-100);
}

.detail-actions-right {
    display: flex;
    gap: 12px;
    align-items: center;
}

/* Back Button */
.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: #fff;
    color: var(--color-gray-700);
    border: 1.5px solid var(--color-gray-300);
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

.btn-back:hover {
    background: var(--color-gray-50);
    color: var(--color-gray-900);
    border-color: var(--color-gray-400);
    transform: translateX(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.btn-back i {
    font-size: 13px;
}

/* Edit Button */
.btn-edit {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 28px;
    background: linear-gradient(135deg, var(--color-primary) 0%, #764ba2 100%);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.btn-edit:hover {
    background: linear-gradient(135deg, var(--color-primary-dark) 0%, #6b3fa0 100%);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
}

.btn-edit:active {
    transform: translateY(0);
}

.btn-edit i {
    font-size: 14px;
}

/* ===== ANIMATIONS ===== */
@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .detail-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }

    .detail-title {
        font-size: 20px;
    }

    .detail-subtitle {
        font-size: 13px;
    }

    .detail-actions {
        flex-direction: column;
        gap: 12px;
    }

    .detail-actions-right {
        width: 100%;
    }

    .btn-back,
    .btn-edit {
        width: 100%;
        justify-content: center;
    }

    .kondisi-card {
        flex-direction: column;
        text-align: center;
        gap: 16px;
    }

    .kondisi-icon {
        font-size: 36px;
    }

    .stock-info {
        flex-direction: column;
        gap: 12px;
    }
}
</style>

@endsection
