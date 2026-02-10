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
            <div class="card custom-card-kategori">
                <div class="card-body p-4">

                   <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title-kategori mb-1">Data Kategori</h4>
                            <p class="card-subtitle-kategori">Kelola kategori barang inventaris</p>
                        </div>

                        <div class="header-actions-kategori">

                            <!-- Search -->
                            <div class="search-wrapper-kategori">
                                <i class="fas fa-search search-icon-kategori"></i>
                                <input type="text"
                                    id="searchKategori"
                                    class="search-input-kategori"
                                    placeholder="Cari kategori...">
                            </div>

                            <!-- Tombol Tambah -->
                            <a href="{{ route('admin.kategori.create') }}" class="btn-add-kategori">
                                <i class="fas fa-plus-circle"></i>
                                <span>Tambah Kategori</span>
                            </a>

                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table custom-table-kategori">
                            <thead>
                                <tr>
                                    <th class="col-no-kategori">No</th>
                                    <th class="col-nama-kategori">Nama Kategori</th>
                                    <th class="text-center col-aksi-kategori">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kategoris as $kategori)
                                <tr>
                                    <td class="col-number-kategori">{{ $loop->iteration }}</td>
                                    <td class="col-nama-kategori-value">{{ $kategori->nama_kategori }}</td>

                                    <td>
                                        <div class="action-buttons-kategori">
                                            <!-- Edit -->
                                            <a href="{{ route('admin.kategori.edit', $kategori->id) }}"
                                               class="btn-action-kategori btn-edit-kategori"
                                               title="Edit">
                                                <i class="far fa-edit"></i>
                                            </a>

                                            <!-- Hapus -->
                                            <form action="{{ route('admin.kategori.destroy', $kategori->id) }}"
                                                  method="POST"
                                                  class="d-inline-block"
                                                  onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action-kategori btn-delete-kategori" title="Hapus">
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
/* ===== TYPOGRAPHY KATEGORI ===== */
:root {
    --font-primary-kategori: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    --font-mono-kategori: "SF Mono", Monaco, "Cascadia Code", "Roboto Mono", Consolas, monospace;
}

body {
    font-family: var(--font-primary-kategori);
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* ===== CARD KATEGORI ===== */
.custom-card-kategori {
    border: none;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04), 0 1px 2px rgba(0, 0, 0, 0.06);
    transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.custom-card-kategori:hover {
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08), 0 2px 4px rgba(0, 0, 0, 0.06);
}

/* ===== HEADER KATEGORI ===== */
.card-title-kategori {
    font-size: 24px;
    font-weight: 700;
    letter-spacing: -0.5px;
    color: #1a1a1a;
    margin: 0;
}

.card-subtitle-kategori {
    font-size: 13px;
    color: #6c757d;
    margin: 4px 0 0 0;
    font-weight: 400;
}

.header-actions-kategori {
    display: flex;
    gap: 16px;
    align-items: center;
}

/* ===== SEARCH KATEGORI ===== */
.search-wrapper-kategori {
    position: relative;
    width: 340px;
}

.search-icon-kategori {
    position: absolute;
    top: 50%;
    left: 16px;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 14px;
    pointer-events: none;
    transition: color 0.2s ease;
}

.search-input-kategori {
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

.search-input-kategori::placeholder {
    color: #9ca3af;
}

.search-input-kategori:hover {
    border-color: #cbd5e1;
    background: #fff;
}

.search-input-kategori:focus {
    outline: none;
    border-color: #3b82f6;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
}

.search-input-kategori:focus + .search-icon-kategori {
    color: #3b82f6;
}

/* ===== BUTTON TAMBAH KATEGORI ===== */
.btn-add-kategori {
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

.btn-add-kategori:hover {
    background: #138496;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(23, 162, 184, 0.3);
}

.btn-add-kategori:active {
    transform: translateY(0);
}

.btn-add-kategori i {
    font-size: 15px;
}

/* ===== TABLE KATEGORI ===== */
.custom-table-kategori {
    margin: 0;
    border-collapse: separate;
    border-spacing: 0;
}

.custom-table-kategori thead {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.custom-table-kategori thead tr th {
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

.custom-table-kategori thead tr th:first-child {
    border-radius: 12px 0 0 0;
}

.custom-table-kategori thead tr th:last-child {
    border-radius: 0 12px 0 0;
}

/* Column widths kategori */
.col-no-kategori {
    width: 100px;
    text-align: center;
}

.col-nama-kategori {
    width: auto;
    min-width: 300px;
}

.col-aksi-kategori {
    width: 150px;
}

.custom-table-kategori tbody tr {
    border-bottom: 1px solid #f1f5f9;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.custom-table-kategori tbody tr:last-child {
    border-bottom: none;
}

.custom-table-kategori tbody tr:hover {
    background: linear-gradient(to right, #fafbfc 0%, #f8fafc 100%);
    transform: scale(1.002);
}

.custom-table-kategori tbody td {
    padding: 18px 20px;
    vertical-align: middle;
    color: #374151;
    font-size: 14px;
}

/* ===== TABLE CELLS KATEGORI ===== */
.col-number-kategori {
    font-weight: 600;
    color: #9ca3af;
    font-size: 13px;
    text-align: center;
}

.col-nama-kategori-value {
    font-weight: 600;
    color: #1f2937;
    font-size: 14px;
}

/* ===== ACTION BUTTONS KATEGORI ===== */
.action-buttons-kategori {
    display: flex;
    gap: 10px;
    justify-content: center;
    align-items: center;
}

.btn-action-kategori {
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

.btn-edit-kategori {
    background: #6c757d;
    color: #fff;
}

.btn-edit-kategori:hover {
    background: #5a6268;
    color: #fff;
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 6px 16px rgba(108, 117, 125, 0.35);
}

.btn-delete-kategori {
    background: #dc3545;
    color: #fff;
}

.btn-delete-kategori:hover {
    background: #c82333;
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 6px 16px rgba(220, 53, 69, 0.35);
}

.btn-action-kategori:active {
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

/* ===== RESPONSIVE KATEGORI ===== */
@media (max-width: 1200px) {
    .header-actions-kategori {
        flex-wrap: wrap;
    }

    .search-wrapper-kategori {
        width: 280px;
    }
}

@media (max-width: 768px) {
    .card-title-kategori {
        font-size: 20px;
    }

    .header-actions-kategori {
        width: 100%;
        flex-direction: column;
        gap: 12px;
    }

    .search-wrapper-kategori {
        width: 100%;
    }

    .btn-add-kategori {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
document.getElementById('searchKategori').addEventListener('keyup', function(e) {
    const keyword = e.target.value.toLowerCase();
    document.querySelectorAll('.custom-table-kategori tbody tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(keyword) ? '' : 'none';
    });
});
</script>

@endsection
