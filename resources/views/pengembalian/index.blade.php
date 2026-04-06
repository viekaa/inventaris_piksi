@extends('layouts.backend')

@section('content')

<div class="container-fluid">

    @if(session('ok'))
    <div class="pg-alert pg-alert-success alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-center gap-2">
            <i class="fas fa-check-circle" style="font-size:20px;color:#059669;"></i>
            <div><strong style="color:#065f46;">Berhasil!</strong> <span style="color:#047857;">{{ session('ok') }}</span></div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="pg-alert pg-alert-danger alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-center gap-2">
            <i class="fas fa-exclamation-circle" style="font-size:20px;color:#dc2626;"></i>
            <div><strong style="color:#991b1b;">Error!</strong> <span style="color:#b91c1c;">{{ session('error') }}</span></div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title-pengembalian mb-1">Data Pengembalian</h4>
                            <p class="card-subtitle">Kelola pengembalian barang inventaris</p>
                        </div>
                        <div class="header-actions">
                            <div class="search-wrapper">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text" id="searchPg" class="search-input" placeholder="Cari pengembalian...">
                            </div>
                            <a href="{{ auth()->user()->role == 'admin'
                                    ? route('admin.pengembalian.export-pdf', request()->query())
                                    : route('petugas.pengembalian.export-pdf', request()->query()) }}"
                            class="btn-export-pdf"
                            target="_blank">
                                <i class="fas fa-file-pdf"></i>
                                <span>Export PDF</span>
                            </a>
                            @if(auth()->user()->role == 'petugas')
                            <a href="{{ route('petugas.pengembalian.create') }}" class="btn-add">
                                <i class="fas fa-plus-circle"></i>
                                <span>Tambah Pengembalian</span>
                            </a>
                            @endif
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th class="col-no-pengembalian">No</th>
                                    <th>Barang</th>
                                    <th>Peminjam</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-center">Tanggal Kembali</th>
                                    <th class="text-center">Keterlambatan</th>
                                    <th class="text-center">Kondisi</th>
                                    <th class="text-center col-aksi">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengembalian as $item)
                                <tr>
                                    <td class="col-number">{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="badge-kategori">{{ $item->peminjaman->barang->nama_barang }}</span>
                                    </td>
                                    <td class="col-nama">{{ $item->peminjaman->nama_peminjam }}</td>
                                    <td class="text-center">
                                        <span class="badge-kondisi" style="background:#E8F8F0;color:#2E7D32;">
                                            {{ $item->peminjaman->jumlah }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-total">
                                            {{ \Carbon\Carbon::parse($item->tgl_kembali_real)->format('d/m/Y') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($item->hari_telat > 0)
                                            <span class="badge-kondisi" style="background:#FDECEA;color:#C62828;">
                                                {{ $item->hari_telat }} hari
                                            </span>
                                        @else
                                            <span class="badge-ontime">
                                                <i class="fas fa-check-circle"></i> Tepat
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="kondisi-pills">
                                            @php
                                                $baik  = $item->details()->where('kondisi', 'baik')->value('jumlah') ?? 0;
                                                $rusak = $item->details()->where('kondisi', 'rusak')->value('jumlah') ?? 0;
                                                $perlu = $item->details()->where('kondisi', 'perlu_perbaikan')->value('jumlah') ?? 0;
                                            @endphp
                                            @if($baik > 0)
                                                <span class="badge-kondisi" style="background:#E8F8F0;color:#2E7D32;">{{ $baik }} baik</span>
                                            @endif
                                            @if($rusak > 0)
                                                <span class="badge-kondisi" style="background:#FDECEA;color:#C62828;">{{ $rusak }} rusak</span>
                                            @endif
                                            @if($perlu > 0)
                                                <span class="badge-kondisi" style="background:#FFF8E1;color:#F9A825;">{{ $perlu }} perlu perbaikan</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            @if(auth()->user()->role == 'admin')
                                                <a href="{{ route('admin.pengembalian.show', $item->id) }}" class="btn-action btn-detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('petugas.pengembalian.show', $item->id) }}" class="btn-action btn-detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endif
                                            @if(auth()->user()->role == 'petugas')
                                            <a href="{{ route('petugas.pengembalian.edit', $item->id) }}"
                                               class="btn-action btn-edit" title="Edit">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <form action="{{ route('petugas.pengembalian.destroy', $item->id) }}"
                                                  method="POST" class="d-inline-block"
                                                  onsubmit="return confirm('Yakin hapus? Stok akan disesuaikan.')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn-action btn-delete" title="Hapus">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-inbox"></i>
                                            <p>Belum ada data pengembalian</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ===== CARD ===== */
.custom-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04), 0 1px 2px rgba(0,0,0,0.06);
    transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.custom-card:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.08), 0 2px 4px rgba(0,0,0,0.06);
}

/* ===== HEADER ===== */
.card-title-pengembalian{
    font-size: 23px;
    font-weight: 400;
    letter-spacing: -0.5px;
    color: #1a1a1a;
    margin: 0;
}
.card-subtitle {
    font-size: 13px;
    color: #6c757d;
    margin: 4px 0 0 0;
    font-weight: 300;
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
.search-input::placeholder { color: #9ca3af; }
.search-input:hover { border-color: #cbd5e1; background: #fff; }
.search-input:focus {
    outline: none;
    border-color: #3b82f6;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(59,130,246,0.1);
}

/* ===== EXPORT PDF ===== */
.btn-export-pdf {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 22px;
    background: #fff;
    color: #dc2626;
    border: 1.5px solid #dc2626;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    white-space: nowrap;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}
.btn-export-pdf:hover {
    background: #dc2626;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(220,38,38,0.3);
    text-decoration: none;
}
.btn-export-pdf i { font-size: 15px; }

/* ===== BTN ADD ===== */
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
    font-weight: 400;
    text-decoration: none;
    white-space: nowrap;
    box-shadow: 0 2px 4px rgba(23,162,184,0.2);
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}
.btn-add:hover {
    background: #138496;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(23,162,184,0.3);
}
.btn-add i { font-size: 15px; }

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
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    border: none;
    vertical-align: middle;
    white-space: nowrap;
}
.custom-table thead tr th:first-child { border-radius: 12px 0 0 0; }
.custom-table thead tr th:last-child  { border-radius: 0 12px 0 0; }

.col-no-pengembalian{
    width: 70px;
    text-align: center;
 }
.col-aksi { width: 180px; }

.custom-table tbody tr {
    border-bottom: 1px solid #f1f5f9;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}
.custom-table tbody tr:last-child { border-bottom: none; }
.custom-table tbody tr:hover {
    background: linear-gradient(to right, #fafbfc 0%, #f8fafc 100%);
    transform: scale(1.002);
}
.custom-table tbody td {
    padding: 10px 20px;
    vertical-align: middle;
    color: #374151;
    font-size: 13px;
}

/* ===== CELLS ===== */
.col-number {
    font-weight: 500;
    color: #9ca3af;
    font-size: 13px;
    text-align: center;
}
.col-nama {
    font-weight: 500;
    color: #1f2937;
    font-size: 14px;
}

/* ===== BADGES — sama persis dengan peminjaman ===== */
.badge-kategori {
    display: inline-block;
    padding: 7px 16px;
    background: #f3f4f6;
    color: #4b5563;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 500;
}
.badge-total {
    display: inline-block;
    padding: 7px 16px;
    background: #eff6ff;
    color: #1e40af;
    border-radius: 8px;
    font-size: 12.5px;
    font-weight: 500;
}
.badge-kondisi {
    display: inline-block;
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 500;
}
.badge-ontime {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 6px 14px;
    background: #E8F8F0;
    color: #2E7D32;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 500;
}

/* ===== KONDISI PILLS ===== */
.kondisi-pills {
    display: flex;
    flex-direction: column;
    gap: 4px;
    align-items: center;
}

/* ===== ACTION BUTTONS ===== */
.action-buttons {
    display: flex;
    gap: 10px;
    justify-content: center;
    align-items: center;
    overflow: visible;
}
.custom-table td,
.custom-table tr { overflow: visible; }

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
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
}
.btn-detail { background: #ffc107; color: #fff; }
.btn-detail:hover {
    background: #e0a800; color: #fff;
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 6px 16px rgba(255,193,7,0.35);
}
.btn-edit { background: #6c757d; color: #fff; }
.btn-edit:hover {
    background: #5a6268; color: #fff;
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 6px 16px rgba(108,117,125,0.35);
}
.btn-delete { background: #dc3545; color: #fff; }
.btn-delete:hover {
    background: #c82333;
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 6px 16px rgba(220,53,69,0.35);
}
.btn-action:active { transform: translateY(0) scale(0.98); }

/* ===== EMPTY ===== */
.empty-state {
    color: #9ca3af;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
}
.empty-state i { font-size: 48px; opacity: 0.4; }
.empty-state p { font-size: 15px; margin: 0; }

/* ===== ALERTS ===== */
.pg-alert {
    padding: 16px 20px;
    border-radius: 12px;
    margin-bottom: 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    animation: pgSlideDown 0.4s ease;
}
.pg-alert-success {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    border-left: 4px solid #10b981;
}
.pg-alert-danger {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    border-left: 4px solid #ef4444;
}
@keyframes pgSlideDown {
    from { opacity: 0; transform: translateY(-20px); }
    to   { opacity: 1; transform: translateY(0); }
}

@media (max-width: 1200px) {
    .header-actions { flex-wrap: wrap; }
    .search-wrapper { width: 280px; }
}
@media (max-width: 768px) {
    .card-title { font-size: 20px; }
    .header-actions { width: 100%; flex-direction: column; gap: 12px; }
    .search-wrapper { width: 100%; }
    .btn-add { width: 100%; justify-content: center; }
}
</style>

<script>
document.getElementById('searchPg').addEventListener('keyup', function(e) {
    const keyword = e.target.value.toLowerCase();
    document.querySelectorAll('.custom-table tbody tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(keyword) ? '' : 'none';
    });
});
</script>

@endsection
