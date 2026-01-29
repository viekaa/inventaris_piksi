@extends('layouts.backend')

@section('content')

<div class="container-fluid">

    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle me-2" style="font-size: 20px;"></i>
            <div>
                <strong>Berhasil!</strong> {{ session('success') }}
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-body p-4">

                   <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title mb-1">Data Barang</h4>
                            <p class="card-subtitle">Kelola inventori barang Anda</p>
                        </div>

                        <div class="header-actions">

                            <!-- Search -->
                            <div class="search-wrapper">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text"
                                    id="searchBarang"
                                    class="search-input"
                                    placeholder="Cari barang...">
                            </div>

                            <!-- Tombol Tambah -->
                            <a href="{{ route('barang.create') }}" class="btn-add">
                                <i class="fas fa-plus-circle"></i>
                                <span>Tambah Barang</span>
                            </a>

                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th class="col-no">No</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Lokasi</th>
                                    <th class="text-center col-stok">Stok</th>
                                    <th class="text-center col-total">Jumlah Total</th>
                                    <th class="text-center col-kondisi">Kondisi</th>
                                    <th class="text-center col-aksi">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barang as $item)
                                <tr>
                                    <td class="col-number">{{ $loop->iteration }}</td>
                                    <td class="col-nama">{{ $item->nama_barang }}</td>
                                    <td>
                                        <span class="badge-kategori">
                                            {{ $item->kategori->nama_kategori }}
                                        </span>
                                    </td>
                                    <td class="col-lokasi">
                                        <i class="fas fa-map-marker-alt icon-lokasi"></i>
                                        {{ $item->lokasi->nama_lokasi }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-stok">{{ $item->stok }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-total">{{ $item->jumlah_total }}</span>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $badge = match($item->kondisi) {
                                                'baik'            => ['bg' => '#E8F8F0', 'text' => '#2E7D32', 'label' => 'Baik'],
                                                'rusak'           => ['bg' => '#FDECEA', 'text' => '#C62828', 'label' => 'Rusak'],
                                                'perlu_perbaikan' => ['bg' => '#FFF8E1', 'text' => '#F9A825', 'label' => 'Perlu Perbaikan'],
                                                default           => ['bg' => '#ECEFF1', 'text' => '#546E7A', 'label' => ucfirst($item->kondisi)],
                                            };
                                        @endphp

                                        <span class="badge-kondisi" style="background: {{ $badge['bg'] }}; color: {{ $badge['text'] }};">
                                            {{ $badge['label'] }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="action-buttons">
                                            <!-- Detail -->
                                            <a href="{{ route('barang.show', $item->id) }}"
                                            class="btn-action btn-detail"
                                            title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <!-- Edit -->
                                            <a href="{{ route('barang.edit', $item->id) }}"
                                               class="btn-action btn-edit"
                                               title="Edit">
                                                <i class="far fa-edit"></i>
                                            </a>

                                            <!-- Hapus -->
                                            <form action="{{ route('barang.destroy', $item->id) }}"
                                                  method="POST"
                                                  class="d-inline-block"
                                                  onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-delete" title="Hapus">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                  </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
}

.custom-card:hover {
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08), 0 2px 4px rgba(0, 0, 0, 0.06);
}

/* ===== HEADER ===== */
.card-title {
    font-size: 24px;
    font-weight: 700;
    letter-spacing: -0.5px;
    color: #1a1a1a;
    margin: 0;
}

.card-subtitle {
    font-size: 13px;
    color: #6c757d;
    margin: 4px 0 0 0;
    font-weight: 400;
}

.header-actions {
    display: flex;
    gap: 16px;
    align-items: center;
}

/* ===== SEARCH ===== */
.search-wrapper {
    position: relative;
    width: 340px;
}

.search-icon {
    position: absolute;
    top: 50%;
    left: 16px;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 14px;
    pointer-events: none;
    transition: color 0.2s ease;
}

.search-input {
    width: 100%;
    padding: 11px 18px 11px 42px;
    border: 1.5px solid #e5e7eb;
    border-radius: 12px;
    background: #fafafa;
    font-size: 14px;
    font-weight: 400;
    color: #374151;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}

.search-input::placeholder {
    color: #9ca3af;
}

.search-input:hover {
    border-color: #cbd5e1;
    background: #fff;
}

.search-input:focus {
    outline: none;
    border-color: #3b82f6;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
}

.search-input:focus + .search-icon {
    color: #3b82f6;
}

/* ===== BUTTON TAMBAH ===== */
.btn-add {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 24px;
    background: #17a2b8;
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    white-space: nowrap;
    box-shadow: 0 2px 4px rgba(23, 162, 184, 0.2);
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}

.btn-add:hover {
    background: #138496;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(23, 162, 184, 0.3);
}

.btn-add:active {
    transform: translateY(0);
}

.btn-add i {
    font-size: 15px;
}

/* ===== TABLE ===== */
.custom-table {
    margin: 0;
    border-collapse: separate;
    border-spacing: 0;
}

.custom-table thead {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.custom-table thead tr th {
    padding: 18px 16px;
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    border: none;
    vertical-align: middle;
}

.custom-table thead tr th:first-child {
    border-radius: 12px 0 0 0;
}

.custom-table thead tr th:last-child {
    border-radius: 0 12px 0 0;
}

/* Column widths */
.col-no { width: 70px; }
.col-stok { width: 100px; }
.col-total { width: 130px; }
.col-kondisi { width: 140px; }
.col-aksi { width: 170px; }

.custom-table tbody tr {
    border-bottom: 1px solid #f1f5f9;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.custom-table tbody tr:last-child {
    border-bottom: none;
}

.custom-table tbody tr:hover {
    background: linear-gradient(to right, #fafbfc 0%, #f8fafc 100%);
    transform: scale(1.002);
}

.custom-table tbody td {
    padding: 16px;
    vertical-align: middle;
    color: #374151;
    font-size: 14px;
}

/* ===== TABLE CELLS ===== */
.col-number {
    font-weight: 600;
    color: #9ca3af;
    font-size: 13px;
}

.col-nama {
    font-weight: 600;
    color: #1f2937;
    font-size: 14px;
}

.col-lokasi {
    color: #6b7280;
    font-size: 13px;
}

.icon-lokasi {
    color: #ef4444;
    margin-right: 6px;
    font-size: 12px;
}

/* ===== BADGES ===== */
.badge-kategori {
    display: inline-block;
    padding: 6px 14px;
    background: #f3f4f6;
    color: #4b5563;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.2px;
}

.badge-stok,
.badge-total {
    display: inline-block;
    padding: 6px 14px;
    background: #eff6ff;
    color: #1e40af;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    font-family: var(--font-mono);
    letter-spacing: 0.3px;
}

.badge-kondisi {
    display: inline-block;
    padding: 7px 18px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.4px;
    text-transform: capitalize;
}

/* ===== ACTION BUTTONS ===== */
.action-buttons {
    display: flex;
    gap: 8px;
    justify-content: center;
    align-items: center;
}

.btn-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border: none;
    border-radius: 10px;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}

.btn-detail {
    background: #ffc107;
    color: #fff;
}

.btn-detail:hover {
    background: #e0a800;
    color: #fff;
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 6px 16px rgba(255, 193, 7, 0.35);
}

.btn-edit {
    background: #6c757d;
    color: #fff;
}

.btn-edit:hover {
    background: #5a6268;
    color: #fff;
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 6px 16px rgba(108, 117, 125, 0.35);
}

.btn-delete {
    background: #dc3545;
    color: #fff;
}

.btn-delete:hover {
    background: #c82333;
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 6px 16px rgba(220, 53, 69, 0.35);
}

.btn-action:active {
    transform: translateY(0) scale(0.98);
}

/* ===== ALERT ===== */
.alert-success {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    border: none;
    border-left: 4px solid #10b981;
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 24px;
    animation: slideDown 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.alert-success i {
    color: #059669;
}

.alert-success strong {
    color: #065f46;
}

.alert-success div {
    color: #047857;
}

.btn-close {
    opacity: 0.6;
}

.btn-close:hover {
    opacity: 1;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ===== RESPONSIVE ===== */
@media (max-width: 1200px) {
    .header-actions {
        flex-wrap: wrap;
    }

    .search-wrapper {
        width: 280px;
    }
}

@media (max-width: 768px) {
    .card-title {
        font-size: 20px;
    }

    .header-actions {
        width: 100%;
        flex-direction: column;
        gap: 12px;
    }

    .search-wrapper {
        width: 100%;
    }

    .btn-add {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
document.getElementById('searchBarang').addEventListener('keyup', function(e) {
    const keyword = e.target.value.toLowerCase();
    document.querySelectorAll('.custom-table tbody tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(keyword) ? '' : 'none';
    });
});
</script>

@endsection
