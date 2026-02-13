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
            <div class="card pg-card">
                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="pg-title mb-1">Data Pengembalian</h4>
                            <p class="pg-subtitle">Kelola pengembalian barang inventaris</p>
                        </div>
                        <div class="pg-header-actions">
                            <div class="pg-search-wrapper">
                                <i class="fas fa-search pg-search-icon"></i>
                                <input type="text" id="searchPg" class="pg-search-input" placeholder="Cari pengembalian...">
                            </div>
                            @if(auth()->user()->role == 'petugas')
                            <a href="{{ route('petugas.pengembalian.create') }}" class="pg-btn-add">
                                <i class="fas fa-plus-circle"></i>
                                <span>Tambah Pengembalian</span>
                            </a>
                            @endif
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table pg-table">
                            <thead>
                                <tr>
                                    <th class="pg-col-no">No</th>
                                    <th class="pg-col-barang">Barang</th>
                                    <th class="pg-col-peminjam">Peminjam</th>
                                    <th class="text-center pg-col-jumlah">Jumlah</th>
                                    <th class="text-center pg-col-tgl">Tgl Kembali</th>
                                    <th class="text-center pg-col-telat">Keterlambatan</th>
                                    <th class="text-center pg-col-kondisi">Kondisi</th>
                                    <th class="text-center pg-col-aksi">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengembalian as $item)
                                <tr>
                                    <td class="pg-cell-no">{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="pg-badge-item">{{ $item->peminjaman->barang->nama_barang }}</span>
                                    </td>
                                    <td class="pg-cell-peminjam">{{ $item->peminjaman->nama_peminjam }}</td>
                                    <td class="text-center">
                                        <span class="pg-badge-num">{{ $item->peminjaman->jumlah }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="pg-badge-date">{{ \Carbon\Carbon::parse($item->tgl_kembali_real)->format('d/m/Y') }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($item->hari_telat > 0)
                                            <span class="pg-badge-late">{{ $item->hari_telat }} hari</span>
                                        @else
                                            <span class="pg-badge-ontime"><i class="fas fa-check-circle"></i> Tepat</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="pg-kondisi-pills">
                                            @php
                                                $baik = $item->details()->where('kondisi', 'baik')->value('jumlah') ?? 0;
                                                $rusak = $item->details()->where('kondisi', 'rusak')->value('jumlah') ?? 0;
                                                $perlu = $item->details()->where('kondisi', 'perlu_perbaikan')->value('jumlah') ?? 0;
                                            @endphp
                                            @if($baik > 0)
                                                <span class="pg-pill pg-pill-ok">{{ $baik }} baik</span>
                                            @endif
                                            @if($rusak > 0)
                                                <span class="pg-pill pg-pill-bad">{{ $rusak }} rusak</span>
                                            @endif
                                            @if($perlu > 0)
                                                <span class="pg-pill pg-pill-warn">{{ $perlu }} perlu perbaikan</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="pg-action-btns">
                                                                            {{-- Detail --}}
                                            @if(auth()->user()->role == 'admin')
                                                <a href="{{ route('admin.pengembalian.show', $item->id) }}" class="pg-btn-action pg-btn-detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('petugas.pengembalian.show', $item->id) }}" class="pg-btn-action pg-btn-detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endif
                                            @if(auth()->user()->role == 'petugas')
                                            <a href="{{ route('petugas.pengembalian.edit', $item->id) }}"
                                               class="pg-btn-action pg-btn-edit" title="Edit">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <form action="{{ route('petugas.pengembalian.destroy', $item->id) }}"
                                                  method="POST" class="d-inline-block"
                                                  onsubmit="return confirm('Yakin hapus? Stok akan disesuaikan.')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="pg-btn-action pg-btn-delete" title="Hapus">
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
                                        <div class="pg-empty">
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
/* Card */
.pg-card { border:none; border-radius:16px; box-shadow:0 2px 8px rgba(0,0,0,0.04), 0 1px 2px rgba(0,0,0,0.06); }
.pg-card:hover { box-shadow:0 4px 16px rgba(0,0,0,0.08); }

/* Header */
.pg-title { font-size:24px; font-weight:700; letter-spacing:-0.5px; color:#1a1a1a; margin:0; }
.pg-subtitle { font-size:13px; color:#6c757d; }
.pg-header-actions { display:flex; gap:16px; align-items:center; }

/* Search */
.pg-search-wrapper { position:relative; width:340px; }
.pg-search-icon { position:absolute; top:50%; left:16px; transform:translateY(-50%); color:#9ca3af; font-size:14px; pointer-events:none; }
.pg-search-input {
    width:100%; padding:11px 18px 11px 42px;
    border:1.5px solid #e5e7eb; border-radius:12px;
    background:#fafafa; font-size:14px; color:#374151;
    transition:all 0.25s ease;
}
.pg-search-input::placeholder { color:#9ca3af; }
.pg-search-input:hover { border-color:#cbd5e1; background:#fff; }
.pg-search-input:focus { outline:none; border-color:#3b82f6; background:#fff; box-shadow:0 0 0 4px rgba(59,130,246,0.1); }

/* Btn Add */
.pg-btn-add {
    display:inline-flex; align-items:center; gap:8px;
    padding:11px 24px; background:#17a2b8; color:#fff;
    border-radius:12px; font-size:14px; font-weight:600;
    text-decoration:none; box-shadow:0 2px 4px rgba(23,162,184,0.2);
    transition:all 0.25s ease;
}
.pg-btn-add:hover { background:#138496; color:#fff; transform:translateY(-2px); box-shadow:0 6px 16px rgba(23,162,184,0.3); }

/* Table */
.pg-table { margin:0; border-collapse:separate; border-spacing:0; }
.pg-table thead { background:linear-gradient(135deg,#667eea 0%, #764ba2 100%); }
.pg-table thead tr th {
    padding:18px 20px; color:#fff;
    font-size:12px; font-weight:700; text-transform:uppercase;
    letter-spacing:0.8px; border:none; white-space:nowrap;
}
.pg-table thead tr th:first-child { border-radius:12px 0 0 0; }
.pg-table thead tr th:last-child  { border-radius:0 12px 0 0; }

/* Cols */
.pg-col-no      { width:60px; text-align:center; }
.pg-col-barang  { width:180px; }
.pg-col-peminjam{ width:160px; }
.pg-col-jumlah  { width:90px; }
.pg-col-tgl     { width:120px; }
.pg-col-telat   { width:140px; }
.pg-col-kondisi { width:200px; }
.pg-col-aksi    { width:160px; }

.pg-table tbody tr { border-bottom:1px solid #f1f5f9; transition:all 0.2s ease; }
.pg-table tbody tr:last-child { border-bottom:none; }
.pg-table tbody tr:hover { background:linear-gradient(to right, #fafbfc, #f8fafc); transform:scale(1.002); }
.pg-table tbody td { padding:16px 20px; vertical-align:middle; color:#374151; font-size:14px; }

/* Cells */
.pg-cell-no { font-weight:600; color:#9ca3af; font-size:13px; text-align:center; }
.pg-cell-peminjam { font-weight:600; color:#1f2937; }

/* Badges */
.pg-badge-item {
    display:inline-block; padding:6px 14px;
    background:#f3f4f6; color:#4b5563; border:1px solid #e5e7eb;
    border-radius:8px; font-size:12px; font-weight:600;
}
.pg-badge-num, .pg-badge-date {
    display:inline-block; padding:6px 14px;
    background:#eff6ff; color:#1e40af;
    border-radius:8px; font-size:13px; font-weight:700;
    font-family:"SF Mono",Monaco,Consolas,monospace;
}
.pg-badge-late {
    display:inline-block; padding:6px 14px;
    background:#FDECEA; color:#C62828;
    border-radius:8px; font-size:12px; font-weight:700;
}
.pg-badge-ontime {
    display:inline-flex; align-items:center; gap:4px;
    padding:6px 14px;
    background:#E8F8F0; color:#2E7D32;
    border-radius:20px; font-size:12px; font-weight:700;
}

/* Kondisi Pills */
.pg-kondisi-pills { display:flex; flex-direction:column; gap:4px; align-items:center; }
.pg-pill {
    display:inline-block; padding:4px 10px;
    border-radius:6px; font-size:11px; font-weight:700; white-space:nowrap;
}
.pg-pill-ok   { background:#E8F8F0; color:#2E7D32; }
.pg-pill-warn { background:#FFF8E1; color:#F9A825; }
.pg-pill-bad  { background:#FDECEA; color:#C62828; }

/* Actions */
.pg-action-btns { display:flex; gap:8px; justify-content:center; }
.pg-btn-action {
    display:inline-flex; align-items:center; justify-content:center;
    width:38px; height:38px; border:none; border-radius:10px;
    font-size:14px; cursor:pointer; text-decoration:none;
    transition:all 0.25s ease; box-shadow:0 1px 3px rgba(0,0,0,0.08);
}
.pg-btn-detail { background:#ffc107; color:#fff; }
.pg-btn-detail:hover { background:#e0a800; color:#fff; transform:translateY(-3px) scale(1.05); box-shadow:0 6px 16px rgba(255,193,7,0.35); }
.pg-btn-edit { background:#6c757d; color:#fff; }
.pg-btn-edit:hover { background:#5a6268; color:#fff; transform:translateY(-3px) scale(1.05); box-shadow:0 6px 16px rgba(108,117,125,0.35); }
.pg-btn-delete { background:#dc3545; color:#fff; }
.pg-btn-delete:hover { background:#c82333; transform:translateY(-3px) scale(1.05); box-shadow:0 6px 16px rgba(220,53,69,0.35); }

/* Empty */
.pg-empty { color:#9ca3af; display:flex; flex-direction:column; align-items:center; gap:12px; }
.pg-empty i { font-size:48px; opacity:0.4; }
.pg-empty p { font-size:15px; margin:0; }

/* Alerts */
.pg-alert {
    padding:16px 20px; border-radius:12px; margin-bottom:24px;
    display:flex; justify-content:space-between; align-items:center;
    animation:pgSlideDown 0.4s ease;
}
.pg-alert-success { background:linear-gradient(135deg,#d1fae5,#a7f3d0); border-left:4px solid #10b981; }
.pg-alert-danger  { background:linear-gradient(135deg,#fee2e2,#fecaca); border-left:4px solid #ef4444; }
@keyframes pgSlideDown {
    from { opacity:0; transform:translateY(-20px); }
    to   { opacity:1; transform:translateY(0); }
}

@media (max-width:1200px) {
    .pg-header-actions { flex-wrap:wrap; }
    .pg-search-wrapper { width:280px; }
}
@media (max-width:768px) {
    .pg-title { font-size:20px; }
    .pg-header-actions { width:100%; flex-direction:column; gap:12px; }
    .pg-search-wrapper { width:100%; }
    .pg-btn-add { width:100%; justify-content:center; }
}
</style>

<script>
document.getElementById('searchPg').addEventListener('keyup', function(e) {
    const keyword = e.target.value.toLowerCase();
    document.querySelectorAll('.pg-table tbody tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(keyword) ? '' : 'none';
    });
});
</script>

@endsection
