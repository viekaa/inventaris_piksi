@extends('layouts.backend')
@section('title','Detail Pengembalian')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">

            <!-- Detail Card -->
            <div class="card custom-card-show-pengembalian">
                <div class="card-body p-4">

                    <!-- Header -->
                    <div class="detail-header-pengembalian">
                        <div>
                            <h4 class="detail-title-pengembalian">Detail Pengembalian</h4>
                            <p class="detail-subtitle-pengembalian">Informasi lengkap tentang pengembalian barang</p>
                        </div>
                        <div class="header-badge-pengembalian">
                            @php
                                $badge = match($pengembalian->kondisi_saat_kembali) {
                                    'baik'            => ['bg' => '#E8F8F0', 'text' => '#2E7D32', 'icon' => 'check-circle', 'label' => 'Baik'],
                                    'perlu_perbaikan' => ['bg' => '#FFF8E1', 'text' => '#F9A825', 'icon' => 'exclamation-circle', 'label' => 'Perlu Perbaikan'],
                                    'rusak'           => ['bg' => '#FDECEA', 'text' => '#C62828', 'icon' => 'times-circle', 'label' => 'Rusak'],
                                    default           => ['bg' => '#ECEFF1', 'text' => '#546E7A', 'icon' => 'info-circle', 'label' => ucfirst($pengembalian->kondisi_saat_kembali)],
                                };
                            @endphp
                            <span class="status-badge-pengembalian" style="background: {{ $badge['bg'] }}; color: {{ $badge['text'] }};">
                                <i class="fas fa-{{ $badge['icon'] }}"></i>
                                Kondisi: {{ $badge['label'] }}
                            </span>
                        </div>
                    </div>

                    <!-- Detail Content -->
                    <div class="detail-content-pengembalian">

                        <!-- Data Peminjam -->
                        <div class="detail-section-pengembalian">
                            <h5 class="section-title-pengembalian">
                                <i class="fas fa-user"></i>
                                Data Peminjam
                            </h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="detail-item-pengembalian">
                                        <label class="detail-label-pengembalian">
                                            <i class="fas fa-user-circle"></i>
                                            Nama Peminjam
                                        </label>
                                        <div class="detail-value-pengembalian">{{ $pengembalian->peminjaman->nama_peminjam }}</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-item-pengembalian">
                                        <label class="detail-label-pengembalian">
                                            <i class="fas fa-id-card"></i>
                                            NPM
                                        </label>
                                        <div class="detail-value-pengembalian">{{ $pengembalian->peminjaman->npm }}</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-item-pengembalian">
                                        <label class="detail-label-pengembalian">
                                            <i class="fas fa-graduation-cap"></i>
                                            Jurusan
                                        </label>
                                        <div class="detail-value-pengembalian">{{ $pengembalian->peminjaman->jurusan }}</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-item-pengembalian">
                                        <label class="detail-label-pengembalian">
                                            <i class="fas fa-calendar"></i>
                                            Angkatan
                                        </label>
                                        <div class="detail-value-pengembalian">{{ $pengembalian->peminjaman->angkatan }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Data Barang -->
                        <div class="detail-section-pengembalian">
                            <h5 class="section-title-pengembalian">
                                <i class="fas fa-box"></i>
                                Data Barang yang Dikembalikan
                            </h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="detail-item-pengembalian">
                                        <label class="detail-label-pengembalian">
                                            <i class="fas fa-box-open"></i>
                                            Nama Barang
                                        </label>
                                        <div class="detail-value-pengembalian">
                                            <span class="badge-barang-show-pengembalian">{{ $pengembalian->peminjaman->barang->nama_barang }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-item-pengembalian">
                                        <label class="detail-label-pengembalian">
                                            <i class="fas fa-hashtag"></i>
                                            Jumlah Dikembalikan
                                        </label>
                                        <div class="detail-value-pengembalian">
                                            <span class="badge-number-pengembalian">{{ $pengembalian->peminjaman->jumlah }}</span>
                                            <span class="unit-text-pengembalian">unit</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Waktu Peminjaman & Pengembalian -->
                        <div class="detail-section-pengembalian">
                            <h5 class="section-title-pengembalian">
                                <i class="fas fa-calendar-alt"></i>
                                Waktu Peminjaman & Pengembalian
                            </h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="detail-item-pengembalian">
                                        <label class="detail-label-pengembalian">
                                            <i class="fas fa-calendar-check"></i>
                                            Tanggal Pinjam
                                        </label>
                                        <div class="detail-value-pengembalian">{{ \Carbon\Carbon::parse($pengembalian->peminjaman->tgl_pinjam)->format('d F Y') }}</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-item-pengembalian">
                                        <label class="detail-label-pengembalian">
                                            <i class="fas fa-calendar-times"></i>
                                            Rencana Kembali
                                        </label>
                                        <div class="detail-value-pengembalian">{{ \Carbon\Carbon::parse($pengembalian->peminjaman->tgl_kembali_rencana)->format('d F Y') }}</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-item-pengembalian highlight-pengembalian">
                                        <label class="detail-label-pengembalian">
                                            <i class="fas fa-calendar-day"></i>
                                            Tanggal Kembali Aktual
                                        </label>
                                        <div class="detail-value-pengembalian">
                                            <span class="badge-date-pengembalian">{{ \Carbon\Carbon::parse($pengembalian->tgl_kembali)->format('d F Y') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-item-pengembalian">
                                        <label class="detail-label-pengembalian">
                                            <i class="fas fa-hourglass-half"></i>
                                            Lama Peminjaman
                                        </label>
                                        <div class="detail-value-pengembalian">
                                            @php
                                                $tglPinjam = \Carbon\Carbon::parse($pengembalian->peminjaman->tgl_pinjam);
                                                $tglKembali = \Carbon\Carbon::parse($pengembalian->tgl_kembali);
                                                $durasi = $tglPinjam->diffInDays($tglKembali);
                                            @endphp
                                            <span class="badge-duration-pengembalian">{{ $durasi }} hari</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kondisi Barang -->
                        <div class="detail-section-pengembalian">
                            <h5 class="section-title-pengembalian">
                                <i class="fas fa-clipboard-check"></i>
                                Kondisi Barang
                            </h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="kondisi-comparison-pengembalian">
                                        <div class="kondisi-label-pengembalian">Saat Dipinjam</div>
                                        @php
                                            $badgePinjam = match($pengembalian->peminjaman->kondisi_saat_pinjam) {
                                                'baik'            => ['bg' => '#E8F8F0', 'text' => '#2E7D32', 'label' => 'Baik'],
                                                'perlu_perbaikan' => ['bg' => '#FFF8E1', 'text' => '#F9A825', 'label' => 'Perlu Perbaikan'],
                                                'rusak'           => ['bg' => '#FDECEA', 'text' => '#C62828', 'label' => 'Rusak'],
                                                default           => ['bg' => '#ECEFF1', 'text' => '#546E7A', 'label' => ucfirst($pengembalian->peminjaman->kondisi_saat_pinjam)],
                                            };
                                        @endphp
                                        <span class="badge-kondisi-mini-pengembalian" style="background: {{ $badgePinjam['bg'] }}; color: {{ $badgePinjam['text'] }};">
                                            {{ $badgePinjam['label'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="kondisi-comparison-pengembalian">
                                        <div class="kondisi-label-pengembalian">Saat Dikembalikan</div>
                                        <span class="badge-kondisi-mini-pengembalian" style="background: {{ $badge['bg'] }}; color: {{ $badge['text'] }};">
                                            {{ $badge['label'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="kondisi-card-pengembalian" style="background: {{ $badge['bg'] }}; border-left: 4px solid {{ $badge['text'] }};">
                                        <div class="kondisi-icon-pengembalian" style="color: {{ $badge['text'] }};">
                                            <i class="fas fa-{{ $badge['icon'] }}"></i>
                                        </div>
                                        <div class="kondisi-content-pengembalian">
                                            <div class="kondisi-status-pengembalian" style="color: {{ $badge['text'] }};">
                                                Kondisi Saat Dikembalikan: {{ $badge['label'] }}
                                            </div>
                                            <div class="kondisi-description-pengembalian">
                                                @if($pengembalian->kondisi_saat_kembali == 'baik')
                                                    Barang dikembalikan dalam kondisi baik dan dapat digunakan kembali
                                                @elseif($pengembalian->kondisi_saat_kembali == 'perlu_perbaikan')
                                                    Barang dikembalikan dalam kondisi memerlukan perbaikan
                                                @elseif($pengembalian->kondisi_saat_kembali == 'rusak')
                                                    Barang dikembalikan dalam kondisi rusak
                                                @else
                                                    Kondisi barang saat dikembalikan
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Action Buttons -->
                    <div class="detail-actions-pengembalian">
                        <a href="{{ route('petugas.pengembalian.index') }}" class="btn-back-pengembalian">
                            <i class="fas fa-arrow-left"></i>
                            <span>Kembali ke Daftar</span>
                        </a>
                        @if(auth()->user()->role == 'petugas')
                        <div class="detail-actions-right-pengembalian">
                            <a href="{{ route('petugas.pengembalian.edit', $pengembalian->id) }}" class="btn-edit-pengembalian">
                                <i class="far fa-edit"></i>
                                <span>Edit Pengembalian</span>
                            </a>
                        </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<style>
/* Reuse sama dengan peminjaman show, tapi dengan suffix -pengembalian */
:root {
    --font-primary-show-pg: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    --font-mono-show-pg: "SF Mono", Monaco, "Cascadia Code", "Roboto Mono", Consolas, monospace;
    --color-primary-show-pg: #667eea;
    --color-primary-dark-show-pg: #5568d3;
}

body {
    font-family: var(--font-primary-show-pg);
}

.custom-card-show-pengembalian {
    border: none;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04), 0 1px 2px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    animation: slideUp-pengembalian 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.detail-header-pengembalian {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 24px;
    border-bottom: 2px solid #f3f4f6;
    margin-bottom: 32px;
}

.detail-title-pengembalian {
    font-size: 24px;
    font-weight: 700;
    letter-spacing: -0.5px;
    color: #111827;
    margin: 0 0 6px 0;
}

.detail-subtitle-pengembalian {
    font-size: 14px;
    color: #6b7280;
    margin: 0;
}

.status-badge-pengembalian {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 700;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.detail-section-pengembalian {
    margin-bottom: 40px;
}

.section-title-pengembalian {
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

.section-title-pengembalian i {
    color: var(--color-primary-show-pg);
    font-size: 18px;
}

.detail-item-pengembalian {
    background: #fafafa;
    padding: 18px 20px;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}

.detail-item-pengembalian:hover {
    background: #fff;
    border-color: #d1d5db;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    transform: translateY(-2px);
}

.highlight-pengembalian {
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%) !important;
    border: 2px solid #3b82f6 !important;
}

.detail-label-pengembalian {
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

.detail-value-pengembalian {
    font-size: 15px;
    font-weight: 600;
    color: #111827;
    display: flex;
    align-items: center;
    gap: 8px;
}

.badge-barang-show-pengembalian {
    display: inline-block;
    padding: 6px 14px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
}

.badge-number-pengembalian {
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
    font-family: var(--font-mono-show-pg);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
}

.badge-date-pengembalian {
    display: inline-block;
    padding: 6px 14px;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: #fff;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
}

.badge-duration-pengembalian {
    display: inline-block;
    padding: 6px 14px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #fff;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
}

.unit-text-pengembalian {
    font-size: 13px;
    color: #6b7280;
}

.kondisi-comparison-pengembalian {
    background: #f9fafb;
    padding: 16px;
    border-radius: 10px;
    text-align: center;
    border: 1px solid #e5e7eb;
}

.kondisi-label-pengembalian {
    font-size: 11px;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.badge-kondisi-mini-pengembalian {
    display: inline-block;
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
}

.kondisi-card-pengembalian {
    display: flex;
    gap: 20px;
    padding: 24px;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.kondisi-card-pengembalian:hover {
    transform: translateX(4px);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
}

.kondisi-icon-pengembalian {
    font-size: 48px;
    opacity: 0.8;
}

.kondisi-status-pengembalian {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 6px;
}

.kondisi-description-pengembalian {
    font-size: 14px;
    color: #374151;
    line-height: 1.5;
}

.detail-actions-pengembalian {
    display: flex;
    gap: 12px;
    justify-content: space-between;
    align-items: center;
    margin-top: 40px;
    padding-top: 24px;
    border-top: 2px solid #f3f4f6;
}

.btn-back-pengembalian {
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
    transition: all 0.25s ease;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

.btn-back-pengembalian:hover {
    background: #fafafa;
    color: #111827;
    border-color: #9ca3af;
    transform: translateX(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.btn-edit-pengembalian {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 28px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.25s ease;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.btn-edit-pengembalian:hover {
    background: linear-gradient(135deg, #5568d3 0%, #6b3fa0 100%);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
}

@keyframes slideUp-pengembalian {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 768px) {
    .detail-header-pengembalian {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }

    .detail-actions-pengembalian {
        flex-direction: column;
    }

    .btn-back-pengembalian,
    .btn-edit-pengembalian {
        width: 100%;
        justify-content: center;
    }

    .kondisi-card-pengembalian {
        flex-direction: column;
        text-align: center;
    }
}
</style>

@endsection
