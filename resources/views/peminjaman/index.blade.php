@extends('layouts.backend')

@section('content')

<div class="container-fluid">
    </div>


    <!-- Error Message -->
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-circle me-2" style="font-size: 20px;"></i>
            <div>
                <strong>Error!</strong> {{ session('error') }}
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
                            <h4 class="card-title mb-1">Data Peminjaman</h4>
                            <p class="card-subtitle">Kelola peminjaman barang inventaris</p>
                        </div>

                        <div class="header-actions">

                            <!-- Search -->
                            <div class="search-wrapper">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text"
                                    id="searchPeminjaman"
                                    class="search-input"
                                    placeholder="Cari peminjaman...">
                            </div>

                            <!-- Tombol Tambah -->
                        @if(auth()->user()->role == 'petugas')
                        <a href="{{ route('petugas.peminjaman.create') }}" class="btn-add">
                            <i class="fas fa-plus-circle"></i>
                            <span>Tambah Peminjaman</span>
                        </a>
                        @endif


                        </div>
                    </div>

                 <div class="table-responsive">
        <table class="table custom-table">
    <thead>
        <tr>
            <th class="col-no">No</th>
            <th class="col-nama">Nama Peminjam</th>
            <th class="col-barang">Barang</th>
            <th class="col-jumlah text-center">Jumlah</th>

            @if(auth()->user()->role == 'admin')
                <th class="col-bidang text-center">Bidang</th>
                <th class="col-tanggal text-center">Tanggal Pinjam</th>
            @else
                <th class="col-tanggal text-center">Tanggal Pinjam</th>
                <th class="col-tanggal text-center">Rencana Kembali</th>
            @endif

            <th class="col-status text-center">Status</th> {{-- ✅ Tambah Status --}}
            <th class="col-aksi text-center">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($peminjaman as $item)
        <tr>

            {{-- No --}}
            <td class="col-number">{{ $loop->iteration }}</td>

            {{-- Nama --}}
            <td class="col-nama">{{ $item->nama_peminjam }}</td>

            {{-- Barang --}}
            <td>
                <span class="badge-kategori">
                    {{ $item->barang->nama_barang }}
                </span>
            </td>

            {{-- Jumlah --}}
            <td class="text-center">
                <span class="badge-kondisi" style="background:#E8F8F0;color:#2E7D32">
                    {{ $item->jumlah }}
                </span>
            </td>

            {{-- ADMIN --}}
            @if(auth()->user()->role == 'admin')
                <td class="text-center">
                    <span class="badge-stok">
                        {{ $item->barang->bidang->nama_bidang ?? '-' }}
                    </span>
                </td>

                <td class="text-center">
                    <span class="badge-total">
                        {{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d/m/Y') }}
                    </span>
                </td>

            {{-- PETUGAS --}}
            @else
                <td class="text-center">
                    <span class="badge-total">
                        {{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d/m/Y') }}
                    </span>
                </td>

                <td class="text-center">
                    <span class="badge-total">
                        {{ \Carbon\Carbon::parse($item->tgl_kembali_rencana)->format('d/m/Y') }}
                    </span>
                </td>
            @endif

            {{-- STATUS --}}
            <td class="text-center">
                @if($item->status == 'dipinjam')
                    <span class="badge bg-warning">Dipinjam</span>
                @else
                    <span class="badge bg-success">Dikembalikan</span>
                @endif
            </td>

            {{-- AKSI --}}
            <td>
                <div class="action-buttons">

                    {{-- Detail --}}
                 @if(auth()->user()->role == 'admin')
                    <a href="{{ route('admin.peminjaman.show', $item->id) }}" class="btn-action btn-detail">
                        <i class="fas fa-eye"></i>
                    </a>
                @else
                    <a href="{{ route('petugas.peminjaman.show', $item->id) }}" class="btn-action btn-detail">
                        <i class="fas fa-eye"></i>
                    </a>
                @endif


                    {{-- Edit & Delete hanya untuk petugas + status dipinjam --}}
                    @if(auth()->user()->role == 'petugas' && $item->status == 'dipinjam')
                        <a href="{{ route('petugas.peminjaman.edit', $item->id) }}"
                           class="btn-action btn-edit">
                            <i class="far fa-edit"></i>
                        </a>

                        <form action="{{ route('petugas.peminjaman.destroy', $item->id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn-action btn-delete">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </form>
                    @endif

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
/* Biar dropdown bisa keluar */
.table td,
.table tr {
    overflow: visible !important;
}

/* Container tombol aksi */
.action-buttons {
    display: flex;
    align-items: center;
    gap: 6px;
    overflow: visible !important;
}

/* Dropdown kondisi */
.select-kondisi {
    height: 34px;
    padding: 4px 8px;
    font-size: 13px;
    border-radius: 8px;
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
    padding: 18px 20px;
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    border: none;
    vertical-align: middle;
    white-space: nowrap;
}

.custom-table thead tr th:first-child {
    border-radius: 12px 0 0 0;
}

.custom-table thead tr th:last-child {
    border-radius: 0 12px 0 0;
}

/* Column widths - Proportional & Balanced */
.col-no {
    width: 70px;
    text-align: center;
}

.col-nama-peminjam {
    width: 200px;
    min-width: 180px;
}

.col-barang {
    width: 220px;
    min-width: 200px;
}

.col-jumlah {
    width: 110px;
}

.col-tgl-pinjam {
    width: 150px;
}

.col-rencana-kembali {
    width: 160px;
}

.col-aksi {
    width: 180px;
}

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
    padding: 18px 20px;
    vertical-align: middle;
    color: #374151;
    font-size: 14px;
}

/* ===== TABLE CELLS ===== */
.col-number {
    font-weight: 600;
    color: #9ca3af;
    font-size: 13px;
    text-align: center;
}

.col-nama {
    font-weight: 600;
    color: #1f2937;
    font-size: 14px;
}

/* ===== BADGES ===== */
.badge-kategori {
    display: inline-block;
    padding: 7px 16px;
    background: #f3f4f6;
    color: #4b5563;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.2px;
    margin-left: -15px;
}

.badge-stok,
.badge-total {
    display: inline-block;
    padding: 7px 16px;
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
    padding: 8px 20px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.4px;
}

/* ===== ACTION BUTTONS ===== */
.action-buttons {
    display: flex;
    gap: 10px;
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

.alert-danger {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    border: none;
    border-left: 4px solid #ef4444;
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 24px;
    animation: slideDown 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.alert-danger i {
    color: #dc2626;
}

.alert-danger strong {
    color: #991b1b;
}

.alert-danger div {
    color: #b91c1c;
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
document.getElementById('searchPeminjaman').addEventListener('keyup', function(e) {
    const keyword = e.target.value.toLowerCase();
    document.querySelectorAll('.custom-table tbody tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(keyword) ? '' : 'none';
    });
});
</script>

@endsection
