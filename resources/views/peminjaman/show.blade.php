@extends('layouts.backend')
@section('title','Detail Peminjaman')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">

            <!-- Detail Card -->
            <div class="card custom-card-show-peminjaman">
                <div class="card-body p-4">

                    <!-- Header -->
                    <div class="detail-header-peminjaman">
                        <div>
                            <h4 class="detail-title-peminjaman">Detail Peminjaman</h4>
                            <p class="detail-subtitle-peminjaman">Informasi lengkap tentang peminjaman barang</p>
                        </div>
                        <div class="header-badge-peminjaman">
                            @php
                                $badge = match($peminjaman->kondisi_saat_pinjam) {
                                    'baik'            => ['bg' => '#E8F8F0', 'text' => '#2E7D32', 'icon' => 'check-circle', 'label' => 'Baik'],
                                    'perlu_perbaikan' => ['bg' => '#FFF8E1', 'text' => '#F9A825', 'icon' => 'exclamation-circle', 'label' => 'Perlu Perbaikan'],
                                    'rusak'           => ['bg' => '#FDECEA', 'text' => '#C62828', 'icon' => 'times-circle', 'label' => 'Rusak'],
                                    default           => ['bg' => '#ECEFF1', 'text' => '#546E7A', 'icon' => 'info-circle', 'label' => ucfirst($peminjaman->kondisi_saat_pinjam)],
                                };
                            @endphp
                            <span class="status-badge-peminjaman" style="background: {{ $badge['bg'] }}; color: {{ $badge['text'] }};">
                                <i class="fas fa-{{ $badge['icon'] }}"></i>
                                Kondisi: {{ $badge['label'] }}
                            </span>
                        </div>
                    </div>

                    <!-- Detail Content -->
                    <div class="detail-content-peminjaman">

                        <!-- Data Peminjam -->
                        <div class="detail-section-peminjaman">
                            <h5 class="section-title-peminjaman">
                                <i class="fas fa-user"></i>
                                Data Peminjam
                            </h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="detail-item-peminjaman h-100">
                                        <label class="detail-label-peminjaman">
                                            <i class="fas fa-user-circle"></i>
                                            Nama Peminjam
                                        </label>
                                        <div class="detail-value-peminjaman">{{ $peminjaman->nama_peminjam }}</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-item-peminjaman h-100">
                                        <label class="detail-label-peminjaman">
                                            <i class="fas fa-id-card"></i>
                                            NPM
                                        </label>
                                        <div class="detail-value-peminjaman">{{ $peminjaman->npm }}</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-item-peminjaman h-100">
                                        <label class="detail-label-peminjaman">
                                            <i class="fas fa-graduation-cap"></i>
                                            Jurusan
                                        </label>
                                        <div class="detail-value-peminjaman">{{ $peminjaman->jurusan->nama_jurusan }}</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-item-peminjaman h-100">
                                        <label class="detail-label-peminjaman">
                                            <i class="fas fa-calendar"></i>
                                            Angkatan
                                        </label>
                                        <div class="detail-value-peminjaman">{{ $peminjaman->angkatan }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Data Barang -->
                        <div class="detail-section-peminjaman">
                            <h5 class="section-title-peminjaman">
                                <i class="fas fa-box"></i>
                                Data Barang yang Dipinjam
                            </h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="detail-item-peminjaman h-100">
                                        <label class="detail-label-peminjaman">
                                            <i class="fas fa-box-open"></i>
                                            Nama Barang
                                        </label>
                                        <div class="detail-value-peminjaman">
                                            <span class="badge-barang-show-peminjaman">{{ $peminjaman->barang->nama_barang }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-item-peminjaman h-100">
                                        <label class="detail-label-peminjaman">
                                            <i class="fas fa-hashtag"></i>
                                            Jumlah Dipinjam
                                        </label>
                                        <div class="detail-value-peminjaman">
                                            <span class="badge-number-peminjaman">{{ $peminjaman->jumlah }}</span>
                                            <span class="unit-text-peminjaman">unit</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Waktu Peminjaman -->
                        <div class="detail-section-peminjaman">
                            <h5 class="section-title-peminjaman">
                                <i class="fas fa-calendar-alt"></i>
                                Waktu Peminjaman
                            </h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="detail-item-peminjaman h-100">
                                        <label class="detail-label-peminjaman">
                                            <i class="fas fa-calendar-check"></i>
                                            Tanggal Pinjam
                                        </label>
                                        <div class="detail-value-peminjaman">{{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d F Y') }}</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-item-peminjaman h-100">
                                        <label class="detail-label-peminjaman">
                                            <i class="fas fa-calendar-times"></i>
                                            Rencana Kembali
                                        </label>
                                        <div class="detail-value-peminjaman">{{ \Carbon\Carbon::parse($peminjaman->tgl_kembali_rencana)->format('d F Y') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kondisi Barang -->
                        <div class="detail-section-peminjaman">
                            <h5 class="section-title-peminjaman">
                                <i class="fas fa-clipboard-check"></i>
                                Kondisi Barang Saat Dipinjam
                            </h5>
                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="kondisi-card-peminjaman" style="background: {{ $badge['bg'] }}; border-left: 4px solid {{ $badge['text'] }};">
                                        <div class="kondisi-icon-peminjaman" style="color: {{ $badge['text'] }};">
                                            <i class="fas fa-{{ $badge['icon'] }}"></i>
                                        </div>
                                        <div class="kondisi-content-peminjaman">
                                            <div class="kondisi-status-peminjaman" style="color: {{ $badge['text'] }};">
                                                {{ $badge['label'] }}
                                            </div>
                                            <div class="kondisi-description-peminjaman">
                                                @if($peminjaman->kondisi_saat_pinjam == 'baik')
                                                    Barang dipinjam dalam kondisi baik dan siap digunakan
                                                @elseif($peminjaman->kondisi_saat_pinjam == 'perlu_perbaikan')
                                                    Barang dipinjam dalam kondisi memerlukan perbaikan
                                                @elseif($peminjaman->kondisi_saat_pinjam == 'rusak')
                                                    Barang dipinjam dalam kondisi rusak
                                                @else
                                                    Kondisi barang saat dipinjam
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Action Buttons -->
                    <div class="detail-actions-peminjaman">
                        <a href="{{ route('petugas.peminjaman.index') }}" class="btn-back-peminjaman">
                            <i class="fas fa-arrow-left"></i>
                            <span>Kembali ke Daftar</span>
                        </a>
                        <div class="detail-actions-right-peminjaman">
                            <a href="{{ route('petugas.peminjaman.edit', $peminjaman->id) }}" class="btn-edit-peminjaman">
                                <i class="far fa-edit"></i>
                                <span>Edit Peminjaman</span>
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
    --font-primary-show: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    --font-mono-show: "SF Mono", Monaco, "Cascadia Code", "Roboto Mono", Consolas, monospace;
    --color-primary-show: #667eea;
    --color-primary-dark-show: #5568d3;
}

body {
    font-family: var(--font-primary-show);
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* ===== CARD ===== */
.custom-card-show-peminjaman {
    border: none;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04), 0 1px 2px rgba(0, 0, 0, 0.06);
    transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    animation: slideUp-peminjaman 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

/* ===== DETAIL HEADER ===== */
.detail-header-peminjaman {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 24px;
    border-bottom: 2px solid #f3f4f6;
    margin-bottom: 32px;
}

.detail-title-peminjaman {
    font-size: 24px;
    font-weight: 700;
    letter-spacing: -0.5px;
    color: #111827;
    margin: 0 0 6px 0;
}

.detail-subtitle-peminjaman {
    font-size: 14px;
    color: #6b7280;
    margin: 0;
    font-weight: 400;
}

.header-badge-peminjaman {
    display: flex;
    align-items: center;
}

.status-badge-peminjaman {
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

.status-badge-peminjaman i {
    font-size: 16px;
}

/* ===== DETAIL CONTENT ===== */
.detail-content-peminjaman {
    padding-top: 8px;
}

.detail-section-peminjaman {
    margin-bottom: 48px;
}

.detail-section-peminjaman:last-child {
    margin-bottom: 0;
}

.section-title-peminjaman {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 16px;
    font-weight: 700;
    color: #374151;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 2px solid #f3f4f6;
}

.section-title-peminjaman i {
    color: var(--color-primary-show);
    font-size: 18px;
}

/* ===== DETAIL ITEMS ===== */
.detail-item-peminjaman {
    background: #fafafa;
    padding: 18px 20px;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}

.detail-item-peminjaman:hover {
    background: #fff;
    border-color: #d1d5db;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    transform: translateY(-2px);
}

.detail-label-peminjaman {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.detail-label-peminjaman i {
    font-size: 13px;
    color: #9ca3af;
}

.detail-value-peminjaman {
    font-size: 15px;
    font-weight: 600;
    color: #111827;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* ===== BADGES ===== */
.badge-barang-show-peminjaman {
    display: inline-block;
    padding: 6px 14px;
    background: linear-gradient(135deg, var(--color-primary-show) 0%, #764ba2 100%);
    color: #fff;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 0.2px;
}

.badge-number-peminjaman {
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
    font-family: var(--font-mono-show);
    letter-spacing: 0.5px;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
}

.unit-text-peminjaman {
    font-size: 13px;
    color: #6b7280;
    font-weight: 500;
}

/* ===== KONDISI CARD ===== */
.kondisi-card-peminjaman {
    display: flex;
    gap: 20px;
    padding: 24px;
    border-radius: 12px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.kondisi-card-peminjaman:hover {
    transform: translateX(4px);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
}

.kondisi-icon-peminjaman {
    font-size: 48px;
    line-height: 1;
    opacity: 0.8;
}

.kondisi-content-peminjaman {
    flex: 1;
}

.kondisi-status-peminjaman {
    font-size: 20px;
    font-weight: 700;
    letter-spacing: 0.3px;
    margin-bottom: 6px;
}

.kondisi-description-peminjaman {
    font-size: 14px;
    color: #374151;
    font-weight: 400;
    line-height: 1.5;
}

/* ===== DETAIL ACTIONS ===== */
.detail-actions-peminjaman {
    display: flex;
    gap: 12px;
    justify-content: space-between;
    align-items: center;
    margin-top: 40px;
    padding-top: 24px;
    border-top: 2px solid #f3f4f6;
}

.detail-actions-right-peminjaman {
    display: flex;
    gap: 12px;
    align-items: center;
}

/* Back Button */
.btn-back-peminjaman {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: #fff;
    color: #374151;
    border: 1.5px solid #d1d5db;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

.btn-back-peminjaman:hover {
    background: #fafafa;
    color: #111827;
    border-color: #9ca3af;
    transform: translateX(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.btn-back-peminjaman i {
    font-size: 13px;
}

/* Edit Button */
.btn-edit-peminjaman {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 28px;
    background: linear-gradient(135deg, var(--color-primary-show) 0%, #764ba2 100%);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.btn-edit-peminjaman:hover {
    background: linear-gradient(135deg, var(--color-primary-dark-show) 0%, #6b3fa0 100%);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
}

.btn-edit-peminjaman:active {
    transform: translateY(0);
}

.btn-edit-peminjaman i {
    font-size: 14px;
}

/* ===== ANIMATIONS ===== */
@keyframes slideUp-peminjaman {
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
    .detail-header-peminjaman {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }

    .detail-title-peminjaman {
        font-size: 20px;
    }

    .detail-subtitle-peminjaman {
        font-size: 13px;
    }

    .detail-actions-peminjaman {
        flex-direction: column;
        gap: 12px;
    }

    .detail-actions-right-peminjaman {
        width: 100%;
    }

    .btn-back-peminjaman,
    .btn-edit-peminjaman {
        width: 100%;
        justify-content: center;
    }

    .kondisi-card-peminjaman {
        flex-direction: column;
        text-align: center;
        gap: 16px;
    }

    .kondisi-icon-peminjaman {
        font-size: 36px;
    }
}
</style>

@endsection
