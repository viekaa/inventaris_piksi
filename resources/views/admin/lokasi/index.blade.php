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
            <div class="card custom-card-lokasi">
                <div class="card-body p-4">

                   <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title-lokasi mb-1">Data Lokasi</h4>
                            <p class="card-subtitle-lokasi">Kelola lokasi penyimpanan barang</p>
                        </div>

                        <div class="header-actions-lokasi">

                            <!-- Search -->
                            <div class="search-wrapper-lokasi">
                                <i class="fas fa-search search-icon-lokasi"></i>
                                <input type="text"
                                    id="searchLokasi"
                                    class="search-input-lokasi"
                                    placeholder="Cari lokasi...">
                            </div>

                            <!-- Tombol Tambah -->
                            <a href="{{ route('admin.lokasi.create') }}" class="btn-add-lokasi">
                                <i class="fas fa-plus-circle"></i>
                                <span>Tambah Lokasi</span>
                            </a>

                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table custom-table-lokasi">
                            <thead>
                                <tr>
                                    <th class="col-no-lokasi">No</th>
                                    <th class="col-nama-lokasi">Nama Lokasi</th>
                                    <th class="text-center col-aksi-lokasi">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lokasis as $lokasi)
                                <tr>
                                    <td class="col-number-lokasi">{{ $loop->iteration }}</td>
                                    <td class="col-nama-lokasi-value">{{ $lokasi->nama_lokasi }}</td>

                                    <td>
                                        <div class="action-buttons-lokasi">
                                            <!-- Edit -->
                                            <a href="{{ route('admin.lokasi.edit', $lokasi->id) }}"
                                               class="btn-action-lokasi btn-edit-lokasi"
                                               title="Edit">
                                                <i class="far fa-edit"></i>
                                            </a>

                                            <!-- Hapus -->
                                            <form action="{{ route('admin.lokasi.destroy', $lokasi->id) }}"
                                                  method="POST"
                                                  class="d-inline-block"
                                                  onsubmit="return confirm('Yakin ingin menghapus lokasi ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action-lokasi btn-delete-lokasi" title="Hapus">
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
/* ===== TYPOGRAPHY LOKASI ===== */
:root {
    --font-primary-lokasi: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    --font-mono-lokasi: "SF Mono", Monaco, "Cascadia Code", "Roboto Mono", Consolas, monospace;
}

body {
    font-family: var(--font-primary-lokasi);
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* ===== CARD LOKASI ===== */
.custom-card-lokasi {
    border: none;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04), 0 1px 2px rgba(0, 0, 0, 0.06);
    transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.custom-card-lokasi:hover {
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08), 0 2px 4px rgba(0, 0, 0, 0.06);
}

/* ===== HEADER LOKASI ===== */
.card-title-lokasi {
    font-size: 24px;
    font-weight: 700;
    letter-spacing: -0.5px;
    color: #1a1a1a;
    margin: 0;
}

.card-subtitle-lokasi {
    font-size: 13px;
    color: #6c757d;
    margin: 4px 0 0 0;
    font-weight: 400;
}

.header-actions-lokasi {
    display: flex;
    gap: 16px;
    align-items: center;
}

/* ===== SEARCH LOKASI ===== */
.search-wrapper-lokasi {
    position: relative;
    width: 340px;
}

.search-icon-lokasi {
    position: absolute;
    top: 50%;
    left: 16px;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 14px;
    pointer-events: none;
    transition: color 0.2s ease;
}

.search-input-lokasi {
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

.search-input-lokasi::placeholder {
    color: #9ca3af;
}

.search-input-lokasi:hover {
    border-color: #cbd5e1;
    background: #fff;
}

.search-input-lokasi:focus {
    outline: none;
    border-color: #3b82f6;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
}

.search-input-lokasi:focus + .search-icon-lokasi {
    color: #3b82f6;
}

/* ===== BUTTON TAMBAH LOKASI ===== */
.btn-add-lokasi {
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

.btn-add-lokasi:hover {
    background: #138496;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(23, 162, 184, 0.3);
}

.btn-add-lokasi:active {
    transform: translateY(0);
}

.btn-add-lokasi i {
    font-size: 15px;
}

/* ===== TABLE LOKASI ===== */
.custom-table-lokasi {
    margin: 0;
    border-collapse: separate;
    border-spacing: 0;
}

.custom-table-lokasi thead {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.custom-table-lokasi thead tr th {
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

.custom-table-lokasi thead tr th:first-child {
    border-radius: 12px 0 0 0;
}

.custom-table-lokasi thead tr th:last-child {
    border-radius: 0 12px 0 0;
}

/* Column widths lokasi */
.col-no-lokasi {
    width: 100px;
    text-align: center;
}

.col-nama-lokasi {
    width: auto;
    min-width: 300px;
}

.col-aksi-lokasi {
    width: 150px;
}

.custom-table-lokasi tbody tr {
    border-bottom: 1px solid #f1f5f9;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.custom-table-lokasi tbody tr:last-child {
    border-bottom: none;
}

.custom-table-lokasi tbody tr:hover {
    background: linear-gradient(to right, #fafbfc 0%, #f8fafc 100%);
    transform: scale(1.002);
}

.custom-table-lokasi tbody td {
    padding: 18px 20px;
    vertical-align: middle;
    color: #374151;
    font-size: 14px;
}

/* ===== TABLE CELLS LOKASI ===== */
.col-number-lokasi {
    font-weight: 600;
    color: #9ca3af;
    font-size: 13px;
    text-align: center;
}

.col-nama-lokasi-value {
    font-weight: 600;
    color: #1f2937;
    font-size: 14px;
}

/* ===== ACTION BUTTONS LOKASI ===== */
.action-buttons-lokasi {
    display: flex;
    gap: 10px;
    justify-content: center;
    align-items: center;
}

.btn-action-lokasi {
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

.btn-edit-lokasi {
    background: #6c757d;
    color: #fff;
}

.btn-edit-lokasi:hover {
    background: #5a6268;
    color: #fff;
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 6px 16px rgba(108, 117, 125, 0.35);
}

.btn-delete-lokasi {
    background: #dc3545;
    color: #fff;
}

.btn-delete-lokasi:hover {
    background: #c82333;
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 6px 16px rgba(220, 53, 69, 0.35);
}

.btn-action-lokasi:active {
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

/* ===== RESPONSIVE LOKASI ===== */
@media (max-width: 1200px) {
    .header-actions-lokasi {
        flex-wrap: wrap;
    }

    .search-wrapper-lokasi {
        width: 280px;
    }
}

@media (max-width: 768px) {
    .card-title-lokasi {
        font-size: 20px;
    }

    .header-actions-lokasi {
        width: 100%;
        flex-direction: column;
        gap: 12px;
    }

    .search-wrapper-lokasi {
        width: 100%;
    }

    .btn-add-lokasi {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
document.getElementById('searchLokasi').addEventListener('keyup', function(e) {
    const keyword = e.target.value.toLowerCase();
    document.querySelectorAll('.custom-table-lokasi tbody tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(keyword) ? '' : 'none';
    });
});
</script>

@endsection
