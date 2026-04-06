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
            <div class="card custom-card-petugas">
                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title-petugas mb-1">Data Pengguna</h4>
                            <p class="card-subtitle-petugas">Kelola data pengguna sistem</p>
                        </div>

                        <div class="header-actions-petugas">

                            <!-- Search -->
                            <div class="search-wrapper-petugas">
                                <i class="fas fa-search search-icon-petugas"></i>
                                <input type="text"
                                    id="searchPetugas"
                                    class="search-input-petugas"
                                    placeholder="Cari pengguna...">
                            </div>

                            <!-- Tombol Tambah -->
                            <a href="{{ route('admin.petugas.create') }}" class="btn-add-petugas">
                                <i class="fas fa-plus-circle"></i>
                                <span>Tambah Pengguna</span>
                            </a>

                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table custom-table-petugas">
                            <thead>
                                <tr>
                                    <th class="col-no-petugas">No</th>
                                    <th class="col-nama-petugas">Nama</th>
                                    <th class="col-email-petugas">Email</th>
                                    <th class="col-bidang-petugas">Bidang</th>
                                    <th class="text-center col-role-petugas">Role</th>
                                    <th class="text-center col-status-petugas">Status</th>
                                    <th class="text-center col-aksi-petugas">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($petugas as $item)
                                <tr>
                                    <td class="col-number-petugas">{{ $loop->iteration }}</td>
                                    <td class="col-nama-petugas-value">{{ $item->name }}</td>
                                    <td class="col-email-petugas-value">{{ $item->email }}</td>
                                    <td class="col-bidang-petugas-value">{{ $item->bidang->nama_bidang ?? '-' }}</td>
                                    <td class="text-center">
                                        <span class="badge-role-petugas badge-{{ $item->role }}">
                                            {{ ucfirst($item->role) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($item->status == 'aktif')
                                            <span class="badge-status-petugas badge-aktif">Aktif</span>
                                        @else
                                            <span class="badge-status-petugas badge-nonaktif">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons-petugas">

                                            <!-- Tombol Edit -->
                                            <a href="{{ route('admin.petugas.edit', $item->id) }}"
                                               class="btn-action-petugas btn-edit-petugas"
                                               title="Edit">
                                                <i class="far fa-edit"></i>
                                            </a>

                                            @if($item->status == 'aktif')
                                                <!-- NONAKTIFKAN -->
                                                <form action="{{ route('admin.petugas.destroy', $item->id) }}"
                                                      method="POST"
                                                      class="d-inline-block"
                                                      onsubmit="return confirm('Nonaktifkan akun ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn-action-petugas btn-delete-petugas"
                                                            title="Nonaktifkan">
                                                        <i class=" fas fa-fire"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <!-- AKTIFKAN -->
                                                <form action="{{ route('admin.petugas.aktifkan', $item->id) }}"
                                                      method="POST"
                                                      class="d-inline-block"
                                                      onsubmit="return confirm('Aktifkan kembali akun ini?')">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit"
                                                            class="btn-action-petugas btn-activate-petugas"
                                                            title="Aktifkan">
                                                        <i class="fas fa-user"></i>
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
    --font-primary-petugas: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
     --font-mono-petugas: "SF Mono", Monaco, "Cascadia Code", "Roboto Mono", Consolas, monospace;
}

/* ===== CARD PETUGAS ===== */
.custom-card-petugas {
    border: none;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04), 0 1px 2px rgba(0, 0, 0, 0.06);
    transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.custom-card-petugas:hover {
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08), 0 2px 4px rgba(0, 0, 0, 0.06);
}

/* ===== HEADER ===== */
.card-title-petugas {
    font-size: 24px;
    font-weight: 400;
    letter-spacing: -0.5px;
    color: #1a1a1a;
    margin: 0;
}
.card-subtitle-petugas {
    font-size: 13px;
    color: #6c757d;
    margin: 4px 0 0 0;
    font-weight: 400;
}

.header-actions-petugas {
    display: flex;
    gap: 16px;
    align-items: center; fas fa-fire
}

/* ===== SEARCH ===== */
.search-wrapper-petugas {
    position: relative;
    width: 340px;
}

.search-icon-petugas {
    position: absolute;
    top: 50%;
    left: 16px;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 14px;
    pointer-events: none;
    transition: color 0.2s ease;
}

.search-input-petugas {
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

.search-input-petugas::placeholder { color: #9ca3af; }

.search-input-petugas:hover {
    border-color: #cbd5e1;
    background: #fff;
}

.search-input-petugas:focus {
    outline: none;
    border-color: #3b82f6;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
}

/* ===== BUTTON TAMBAH ===== */
.btn-add-petugas {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 24px;
    background: #17a2b8;
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: 13.5px;
    font-weight: 500;
    text-decoration: none;
    white-space: nowrap;
    box-shadow: 0 2px 4px rgba(23, 162, 184, 0.2);
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}

.btn-add-petugas:hover {
    background: #138496;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(23, 162, 184, 0.3);
}

.btn-add-petugas:active { transform: translateY(0); }
.btn-add-petugas i { font-size: 15px; }

/* ===== TABLE ===== */
.custom-table-petugas {
    margin: 0;
    border-collapse: separate;
    border-spacing: 0;
}

.custom-table-petugas thead {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.custom-table-petugas thead tr th {
    padding: 18px 20px;
    color: #fff;
    font-size: 12.5px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    border: none;
    vertical-align: middle;
    white-space: nowrap;
}

.custom-table-petugas thead tr th:first-child { border-radius: 12px 0 0 0; }
.custom-table-petugas thead tr th:last-child  { border-radius: 0 12px 0 0; }

/* Column widths */
.col-no-petugas     { width: 100px; text-align: center; }
.col-nama-petugas   { min-width: 160px; }
.col-email-petugas  { min-width: 200px; }
.col-bidang-petugas { min-width: 140px; }
.col-role-petugas   { width: 110px; }
.col-status-petugas { width: 110px; }
.col-aksi-petugas   { width: 150px; }

.custom-table-petugas tbody tr {
    border-bottom: 1px solid #f1f5f9;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.custom-table-petugas tbody tr:last-child { border-bottom: none; }

.custom-table-petugas tbody tr:hover {
    background: linear-gradient(to right, #fafbfc 0%, #f8fafc 100%);
    transform: scale(1.002);
}

.custom-table-petugas tbody td {
    padding: 18px 20px;
    vertical-align: middle;
    color: #374151;
    font-size: 14px;
}

/* ===== TABLE CELLS ===== */
.col-number-petugas       { font-weight: 500; color: #9ca3af; font-size: 13px; text-align: center; }
.col-nama-petugas-value   { font-weight: 500; color: #1f2937; font-size: 14px; }
.col-email-petugas-value  { color: #4b5563; font-size: 13px; }
.col-bidang-petugas-value { color: #4b5563; font-size: 13px; }

/* ===== BADGE ROLE ===== */
.badge-role-petugas {
    display: inline-flex;
    align-items: center;
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    letter-spacing: 0.3px;
}

.badge-admin   { background: rgba(102,126,234,0.12); color: #667eea; }
.badge-petugas { background: rgba(23,162,184,0.12);  color: #138496; }

/* ===== BADGE STATUS ===== */
.badge-status-petugas {
    display: inline-flex;
    align-items: center;
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

.badge-aktif    { background: rgba(16,185,129,0.12); color: #059669; }
.badge-nonaktif { background: rgba(239,68,68,0.12);  color: #dc2626; }

/* ===== ACTION BUTTONS ===== */
.action-buttons-petugas {
    display: flex;
    gap: 10px;
    justify-content: center;
    align-items: center;
}

.btn-action-petugas {
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

/* Edit — abu, icon far fa-edit (sama dengan Lokasi) */
.btn-edit-petugas { background: #6c757d; color: #fff; }
.btn-edit-petugas:hover {
    background: #5a6268;
    color: #fff;
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 6px 16px rgba(108, 117, 125, 0.35);
}

/* Delete — merah, icon far fa-trash-alt (sama dengan Lokasi) */
.btn-delete-petugas { background: #dc3545; color: #fff; }
.btn-delete-petugas:hover {
    background: #c82333;
    color: #fff;
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 6px 16px rgba(220, 53, 69, 0.35);
}

/* Aktifkan — hijau, icon fas fa-user-check */
.btn-activate-petugas { background: #28a745; color: #fff; }
.btn-activate-petugas:hover {
    background: #218838;
    color: #fff;
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 6px 16px rgba(40, 167, 69, 0.35);
}

.btn-action-petugas:active { transform: translateY(0) scale(0.98); }

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

.alert-success i      { color: #059669; }
.alert-success strong { color: #065f46; }
.alert-success div    { color: #047857; }

.btn-close { opacity: 0.6; }
.btn-close:hover { opacity: 1; }

@keyframes slideDown {
    from { opacity: 0; transform: translateY(-20px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ===== RESPONSIVE ===== */
@media (max-width: 1200px) {
    .header-actions-petugas { flex-wrap: wrap; }
    .search-wrapper-petugas { width: 280px; }
}

@media (max-width: 768px) {
    .card-title-petugas { font-size: 20px; }
    .header-actions-petugas { width: 100%; flex-direction: column; gap: 12px; }
    .search-wrapper-petugas { width: 100%; }
    .btn-add-petugas { width: 100%; justify-content: center; }
}
</style>

<script>
document.getElementById('searchPetugas').addEventListener('keyup', function(e) {
    const keyword = e.target.value.toLowerCase();
    document.querySelectorAll('.custom-table-petugas tbody tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(keyword) ? '' : 'none';
    });
});
</script>

@endsection
