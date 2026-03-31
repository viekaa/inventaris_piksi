@extends('layouts.backend')

@section('content')

<div class="container-fluid">

    {{-- Alert --}}
    @if(session('ok'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle mr-2" style="font-size:18px;color:#059669"></i>
            <div><strong>Berhasil!</strong> {{ session('ok') }}</div>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    {{-- ============================================================ --}}
    {{-- SECTION: PERLU PERBAIKAN                                     --}}
    {{-- ============================================================ --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title mb-1">
                                <span class="badge-kondisi-header badge-perbaikan mr-2">
                                    <i class="fas fa-tools"></i>
                                </span>
                                Barang Perlu Perbaikan
                            </h4>
                            <p class="card-subtitle">Barang yang dikembalikan dalam kondisi perlu diperbaiki</p>
                        </div>
                        <span class="count-badge badge-perbaikan-count">
                            {{ $perluPerbaikan->count() }} barang
                        </span>
                    </div>

                    <div class="table-responsive">
                        <table class="table custom-table" id="tablePerbaikan">
                            <thead>
                                <tr>
                                    <th class="col-no">No</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Bidang</th>
                                    <th>Lokasi</th>
                                    <th class="text-center col-stok">Stok Saat Ini</th>
                                    <th class="text-center col-kondisi">Kondisi Sekarang</th>
                                    <th class="text-center col-aksi">Update Kondisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($perluPerbaikan as $item)
                                <tr>
                                    <td class="col-number">{{ $loop->iteration }}</td>
                                    <td class="col-nama">{{ $item->nama_barang }}</td>
                                    <td>
                                        <span class="badge-kategori">{{ $item->kategori->nama_kategori }}</span>
                                    </td>
                                    <td>
                                        <span class="badge-bidang">{{ $item->bidang->nama_bidang ?? '-' }}</span>
                                    </td>
                                    <td class="col-lokasi">
                                        <i class="fas fa-map-marker-alt icon-lokasi"></i>
                                        {{ $item->lokasi->nama_lokasi }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-stok">{{ $item->stok }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-kondisi" style="background:#FFF8E1;color:#F9A825;">
                                            Perlu Perbaikan
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.perbaikan.update', $item->id) }}"
                                              method="POST"
                                              class="form-inline justify-content-center form-update"
                                              onsubmit="return confirmUpdate(this)">
                                            @csrf
                                            @method('PATCH')
                                            <select name="kondisi" class="select-kondisi mr-2">
                                                <option value="perlu_perbaikan" selected>Perlu Perbaikan</option>
                                                <option value="baik">✓ Sudah Baik</option>
                                                <option value="rusak">✗ Rusak</option>
                                            </select>
                                            <button type="submit" class="btn-update">
                                                <i class="fas fa-save"></i> Simpan
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-check-circle empty-icon text-success"></i>
                                            <p class="mt-2 text-muted">Tidak ada barang yang perlu perbaikan</p>
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

    {{-- ============================================================ --}}
    {{-- SECTION: RUSAK                                               --}}
    {{-- ============================================================ --}}
    <div class="row mt-2">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title mb-1">
                                <span class="badge-kondisi-header badge-rusak mr-2">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </span>
                                Barang Rusak
                            </h4>
                            <p class="card-subtitle">Barang yang dikembalikan dalam kondisi rusak</p>
                        </div>
                        <span class="count-badge badge-rusak-count">
                            {{ $rusak->count() }} barang
                        </span>
                    </div>

                    <div class="table-responsive">
                        <table class="table custom-table" id="tableRusak">
                            <thead>
                                <tr>
                                    <th class="col-no">No</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Bidang</th>
                                    <th>Lokasi</th>
                                    <th class="text-center col-stok">Stok Saat Ini</th>
                                    <th class="text-center col-kondisi">Kondisi Sekarang</th>
                                    <th class="text-center col-aksi">Update Kondisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rusak as $item)
                                <tr>
                                    <td class="col-number">{{ $loop->iteration }}</td>
                                    <td class="col-nama">{{ $item->nama_barang }}</td>
                                    <td>
                                        <span class="badge-kategori">{{ $item->kategori->nama_kategori }}</span>
                                    </td>
                                    <td>
                                        <span class="badge-bidang">{{ $item->bidang->nama_bidang ?? '-' }}</span>
                                    </td>
                                    <td class="col-lokasi">
                                        <i class="fas fa-map-marker-alt icon-lokasi"></i>
                                        {{ $item->lokasi->nama_lokasi }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-stok">{{ $item->stok }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-kondisi" style="background:#FDECEA;color:#C62828;">
                                            Rusak
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.perbaikan.update', $item->id) }}"
                                              method="POST"
                                              class="form-inline justify-content-center form-update"
                                              onsubmit="return confirmUpdate(this)">
                                            @csrf
                                            @method('PATCH')
                                            <select name="kondisi" class="select-kondisi mr-2">
                                                <option value="rusak" selected>Rusak</option>
                                                <option value="baik">✓ Sudah Baik</option>
                                                <option value="perlu_perbaikan">⚠ Perlu Perbaikan</option>
                                            </select>
                                            <button type="submit" class="btn-update">
                                                <i class="fas fa-save"></i> Simpan
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-check-circle empty-icon text-success"></i>
                                            <p class="mt-2 text-muted">Tidak ada barang yang rusak</p>
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

{{-- ============================================================ --}}
{{-- STYLE                                                         --}}
{{-- ============================================================ --}}
<style>
/* ===== CARD ===== */
.custom-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04), 0 1px 2px rgba(0,0,0,0.06);
    transition: box-shadow 0.3s;
}
.custom-card:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
}

/* ===== HEADER ===== */
.card-title {
    font-size: 20px;
    font-weight: 700;
    letter-spacing: -0.3px;
    color: #1a1a1a;
    margin: 0;
    display: flex;
    align-items: center;
}
.card-subtitle {
    font-size: 13px;
    color: #6c757d;
    margin: 4px 0 0 0;
}

/* ===== BADGE HEADER ICONS ===== */
.badge-kondisi-header {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 34px;
    height: 34px;
    border-radius: 10px;
    font-size: 14px;
}
.badge-perbaikan { background: #FFF8E1; color: #F9A825; }
.badge-rusak     { background: #FDECEA; color: #C62828; }

/* ===== COUNT BADGES ===== */
.count-badge {
    display: inline-block;
    padding: 8px 20px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 700;
}
.badge-perbaikan-count { background: #FFF8E1; color: #F57F17; border: 1.5px solid #FFE082; }
.badge-rusak-count     { background: #FDECEA; color: #C62828; border: 1.5px solid #FFCDD2; }

/* ===== TABLE ===== */
.custom-table { margin: 0; border-collapse: separate; border-spacing: 0; }
.custom-table thead { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.custom-table thead tr th {
    padding: 16px;
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    border: none;
    vertical-align: middle;
}
.custom-table thead tr th:first-child { border-radius: 12px 0 0 0; }
.custom-table thead tr th:last-child  { border-radius: 0 12px 0 0; }
.custom-table tbody tr { border-bottom: 1px solid #f1f5f9; transition: all 0.2s; }
.custom-table tbody tr:last-child { border-bottom: none; }
.custom-table tbody tr:hover { background: #fafbfc; }
.custom-table tbody td { padding: 14px 16px; vertical-align: middle; color: #374151; font-size: 14px; }

/* ===== COLUMN WIDTHS ===== */
.col-no    { width: 60px; }
.col-stok  { width: 110px; }
.col-kondisi { width: 150px; }
.col-aksi  { width: 240px; }

/* ===== CELLS ===== */
.col-number { font-weight: 600; color: #9ca3af; font-size: 13px; }
.col-nama   { font-weight: 600; color: #1f2937; }
.col-lokasi { color: #6b7280; font-size: 13px; }
.icon-lokasi { color: #ef4444; margin-right: 4px; font-size: 12px; }

/* ===== BADGES ===== */
.badge-kategori {
    display: inline-block;
    padding: 5px 12px;
    background: #f3f4f6;
    color: #4b5563;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
}
.badge-bidang {
    display: inline-block;
    padding: 5px 12px;
    background: #eef2ff;
    color: #3730a3;
    border: 1px solid #c7d2fe;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
}
.badge-stok {
    display: inline-block;
    padding: 5px 14px;
    background: #eff6ff;
    color: #1e40af;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
}
.badge-kondisi {
    display: inline-block;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
}

/* ===== FORM UPDATE ===== */
.select-kondisi {
    padding: 8px 12px;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 500;
    color: #374151;
    background: #fafafa;
    cursor: pointer;
    transition: border-color 0.2s;
    min-width: 160px;
}
.select-kondisi:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102,126,234,0.15);
}
.btn-update {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 18px;
    background: #667eea;
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
}
.btn-update:hover {
    background: #5a6fd6;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102,126,234,0.35);
}
.btn-update:active { transform: translateY(0); }

/* ===== EMPTY STATE ===== */
.empty-state { padding: 16px 0; }
.empty-icon  { font-size: 36px; display: block; margin: 0 auto 8px; }

/* ===== ALERT ===== */
.alert-success {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    border: none;
    border-left: 4px solid #10b981;
    border-radius: 12px;
    padding: 14px 18px;
    margin-bottom: 20px;
}
</style>

{{-- ============================================================ --}}
{{-- SCRIPT                                                        --}}
{{-- ============================================================ --}}
<script>
function confirmUpdate(form) {
    const select = form.querySelector('select[name="kondisi"]');
    const kondisi = select.options[select.selectedIndex].text;
    return confirm('Update kondisi barang menjadi "' + kondisi + '"?\n\nJika diubah ke "Sudah Baik", stok akan otomatis bertambah 1.');
}
</script>

@endsection
