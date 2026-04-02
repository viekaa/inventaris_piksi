@extends('layouts.backend')

@section('content')

<div class="container-fluid">

    {{-- ── SECTION: PERLU PERBAIKAN ──────────────────────────────────── --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title mb-1">
                                <span class="icon-header icon-perbaikan mr-2">
                                    <i class="fas fa-tools"></i>
                                </span>
                                Barang Perlu Perbaikan
                            </h4>
                            <p class="card-subtitle">Barang yang dikembalikan dalam kondisi perlu diperbaiki</p>
                        </div>
                        <span class="count-badge count-perbaikan">{{ $perluPerbaikan->count() }} barang</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th class="col-no">No</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Bidang</th>
                                    <th>Lokasi</th>
                                    <th class="text-center">Stok</th>
                                    <th class="text-center">Kondisi</th>
                                    <th class="text-center col-aksi">Update Kondisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($perluPerbaikan as $item)
                                <tr>
                                    <td class="col-number">{{ $loop->iteration }}</td>
                                    <td class="col-nama">{{ $item->nama_barang }}</td>
                                    <td><span class="badge-kategori">{{ $item->kategori->nama_kategori }}</span></td>
                                    <td><span class="badge-bidang">{{ $item->bidang->nama_bidang ?? '-' }}</span></td>
                                    <td class="col-lokasi">
                                        <i class="fas fa-map-marker-alt icon-lokasi"></i>{{ $item->lokasi->nama_lokasi }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-total">{{ $item->stok }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-kondisi" style="background:#FFF8E1;color:#F9A825;">Perlu Perbaikan</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-inline-flex align-items-center gap-2">
                                            <select class="select-kondisi" data-id="{{ $item->id }}" data-current="perlu_perbaikan">
                                                <option value="perlu_perbaikan" selected>Perlu Perbaikan</option>
                                                <option value="baik">✓ Sudah Baik</option>
                                                <option value="rusak">✗ Rusak</option>
                                            </select>
                                            <button class="btn-update" onclick="updateKondisi(this)">
                                                <i class="fas fa-save"></i> Simpan
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-check-circle" style="color:#10b981;"></i>
                                            <p>Tidak ada barang yang perlu perbaikan</p>
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

    {{-- ── SECTION: RUSAK ─────────────────────────────────────────────── --}}
    <div class="row mt-2">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title mb-1">
                                <span class="icon-header icon-rusak mr-2">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </span>
                                Barang Rusak
                            </h4>
                            <p class="card-subtitle">Barang yang dikembalikan dalam kondisi rusak</p>
                        </div>
                        <span class="count-badge count-rusak">{{ $rusak->count() }} barang</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th class="col-no">No</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Bidang</th>
                                    <th>Lokasi</th>
                                    <th class="text-center">Stok</th>
                                    <th class="text-center">Kondisi</th>
                                    <th class="text-center col-aksi">Update Kondisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rusak as $item)
                                <tr>
                                    <td class="col-number">{{ $loop->iteration }}</td>
                                    <td class="col-nama">{{ $item->nama_barang }}</td>
                                    <td><span class="badge-kategori">{{ $item->kategori->nama_kategori }}</span></td>
                                    <td><span class="badge-bidang">{{ $item->bidang->nama_bidang ?? '-' }}</span></td>
                                    <td class="col-lokasi">
                                        <i class="fas fa-map-marker-alt icon-lokasi"></i>{{ $item->lokasi->nama_lokasi }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-total">{{ $item->stok }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-kondisi" style="background:#FDECEA;color:#C62828;">Rusak</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-inline-flex align-items-center gap-2">
                                            <select class="select-kondisi" data-id="{{ $item->id }}" data-current="rusak">
                                                <option value="rusak" selected>Rusak</option>
                                                <option value="baik">✓ Sudah Baik</option>
                                                <option value="perlu_perbaikan">⚠ Perlu Perbaikan</option>
                                            </select>
                                            <button class="btn-update" onclick="updateKondisi(this)">
                                                <i class="fas fa-save"></i> Simpan
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-check-circle" style="color:#10b981;"></i>
                                            <p>Tidak ada barang yang rusak</p>
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
.card-title {
    font-size: 20px;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.card-subtitle {
    font-size: 13px;
    color: #6c757d;
    margin: 4px 0 0 0;
    font-weight: 400;
}

/* ===== ICON HEADER ===== */
.icon-header {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 34px;
    height: 34px;
    border-radius: 10px;
    font-size: 14px;
    flex-shrink: 0;
}
.icon-perbaikan { background: #FFF8E1; color: #F9A825; }
.icon-rusak     { background: #FDECEA; color: #C62828; }

/* ===== COUNT BADGE ===== */
.count-badge {
    display: inline-block;
    padding: 7px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
}
.count-perbaikan { background: #FFF8E1; color: #F57F17; border: 1.5px solid #FFE082; }
.count-rusak     { background: #FDECEA; color: #C62828; border: 1.5px solid #FFCDD2; }

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
.custom-table thead tr th:first-child { border-radius: 12px 0 0 0; }
.custom-table thead tr th:last-child  { border-radius: 0 12px 0 0; }

.col-no   { width: 70px; text-align: center; }
.col-aksi { width: 300px; }

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
    padding: 18px 20px;
    vertical-align: middle;
    color: #374151;
    font-size: 14px;
}

/* ===== CELLS ===== */
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
.col-lokasi {
    color: #6b7280;
    font-size: 13px;
}
.icon-lokasi {
    color: #ef4444;
    margin-right: 4px;
    font-size: 12px;
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
    font-weight: 600;
}
.badge-bidang {
    display: inline-block;
    padding: 7px 16px;
    background: #eef2ff;
    color: #3730a3;
    border: 1px solid #c7d2fe;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
}
.badge-total {
    display: inline-block;
    padding: 7px 16px;
    background: #eff6ff;
    color: #1e40af;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
}
.badge-kondisi {
    display: inline-block;
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
}

/* ===== SELECT & UPDATE ===== */
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
    transition: all 0.2s ease;
    white-space: nowrap;
}
.btn-update:hover {
    background: #5a6fd6;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102,126,234,0.35);
}

/* ===== EMPTY STATE ===== */
.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
    color: #9ca3af;
}
.empty-state i  { font-size: 40px; opacity: 0.7; }
.empty-state p  { font-size: 14px; margin: 0; }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '{{ csrf_token() }}';

function updateKondisi(btn) {
    const row     = btn.closest('tr');
    const select  = row.querySelector('.select-kondisi');
    const id      = select.dataset.id;
    const kondisi = select.value;
    const labelMap = { baik: 'Sudah Baik', rusak: 'Rusak', perlu_perbaikan: 'Perlu Perbaikan' };

    const extra = kondisi === 'baik'
        ? '<br><small class="text-success">Stok akan otomatis bertambah 1</small>'
        : '';

    Swal.fire({
        title: 'Update Kondisi Barang',
        html: `Ubah kondisi menjadi <strong>${labelMap[kondisi]}</strong>?${extra}`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#667eea',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Update!',
        cancelButtonText: 'Batal',
    }).then(result => {
        if (!result.isConfirmed) return;

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

        fetch(`/admin/perbaikan/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'X-HTTP-Method-Override': 'PATCH',
            },
            body: JSON.stringify({ kondisi }),
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: data.message,
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false,
                }).then(() => location.reload());
            } else {
                throw new Error(data.message ?? 'Terjadi kesalahan');
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-save"></i> Simpan';
            Swal.fire('Gagal!', err.message, 'error');
        });
    });
}
</script>

@endsection
