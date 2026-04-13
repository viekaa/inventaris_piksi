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
                            <h4 class="card-title-perbaikan mb-1">Barang Perlu Perbaikan</h4>
                            <p class="card-subtitle">Barang yang dikembalikan dalam kondisi perlu diperbaiki</p>
                        </div>
                        <span class="count-badge count-perbaikan">{{ $perluPerbaikan->count() }} barang</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th class="col-no">No</th>
                                    <th class="col-nama">Nama Barang</th>
                                    <th class="col-kategori">Kategori</th>
                                    <th class="col-bidang">Bidang</th>
                                    <th class="col-lokasi">Lokasi</th>
                                    <th class="col-jumlah text-center">Jumlah</th>
                                    <th class="col-kondisi text-center">Kondisi</th>
                                    <th class="col-aksi text-center">Update Kondisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($perluPerbaikan as $item)
                                <tr>
                                    <td class="col-number">{{ $loop->iteration }}</td>
                                    <td class="col-nama">{{ $item->pengembalian->peminjaman->barang->nama_barang }}</td>
                                    <td><span class="badge-kategori">{{ $item->pengembalian->peminjaman->barang->kategori->nama_kategori }}</span></td>
                                    <td><span class="badge-bidang">{{ $item->pengembalian->peminjaman->barang->bidang->nama_bidang ?? '-' }}</span></td>
                                    <td class="col-lokasi-cell">
                                        <i class="fas fa-map-marker-alt icon-lokasi"></i>
                                        {{ $item->pengembalian->peminjaman->barang->lokasi->nama_lokasi }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-warning-count">{{ $item->jumlah }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-kondisi kondisi-perbaikan">
                                            <i class="fas fa-tools"></i> Perlu Perbaikan
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="aksi-wrapper">
                                            <select class="select-kondisi" data-id="{{ $item->id }}" data-current="perlu_perbaikan">
                                                <option value="perlu_perbaikan" selected>Perlu Perbaikan</option>
                                                <option value="baik">Sudah Baik</option>
                                                <option value="rusak">Rusak</option>
                                            </select>
                                            <button class="btn-check" onclick="updateKondisi(this)">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8">
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
                            <h4 class="card-title-rusak mb-1">Barang Rusak</h4>
                            <p class="card-subtitle">Barang yang dikembalikan dalam kondisi rusak</p>
                        </div>
                        <span class="count-badge count-rusak">{{ $rusak->count() }} barang</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th class="col-no">No</th>
                                    <th class="col-nama">Nama Barang</th>
                                    <th class="col-kategori">Kategori</th>
                                    <th class="col-bidang">Bidang</th>
                                    <th class="col-lokasi">Lokasi</th>
                                    <th class="col-jumlah text-center">Jumlah</th>
                                    <th class="col-kondisi text-center">Kondisi</th>
                                    <th class="col-aksi text-center">Update Kondisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rusak as $item)
                                <tr>
                                    <td class="col-number">{{ $loop->iteration }}</td>
                                    <td class="col-nama">{{ $item->pengembalian->peminjaman->barang->nama_barang }}</td>
                                    <td><span class="badge-kategori">{{ $item->pengembalian->peminjaman->barang->kategori->nama_kategori }}</span></td>
                                    <td><span class="badge-bidang">{{ $item->pengembalian->peminjaman->barang->bidang->nama_bidang ?? '-' }}</span></td>
                                    <td class="col-lokasi-cell">
                                        <i class="fas fa-map-marker-alt icon-lokasi"></i>
                                        {{ $item->pengembalian->peminjaman->barang->lokasi->nama_lokasi }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-danger-count">{{ $item->jumlah }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-kondisi kondisi-rusak">
                                            <i class="fas fa-exclamation-circle"></i> Rusak
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="aksi-wrapper">
                                            <select class="select-kondisi" data-id="{{ $item->id }}" data-current="rusak">
                                                <option value="rusak" selected>Rusak</option>
                                                <option value="baik">Sudah Baik</option>
                                                <option value="perlu_perbaikan">Perlu Perbaikan</option>
                                            </select>
                                            <button class="btn-check" onclick="updateKondisi(this)">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8">
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
/* ── Card ── */
.custom-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    background: #fff;
    margin-bottom: 24px;
}

.card-title-perbaikan,
.card-title-rusak {
    font-size: 17px;
    font-weight: 500;
    color: #1a1a1a;
}

.card-subtitle {
    font-size: 13px;
    color: #9ca3af;
    margin: 3px 0 0;
}

/* ── Count Badge ── */
.count-badge {
    display: inline-block;
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}
.count-perbaikan { background: #FFF8E1; color: #B45309; border: 1px solid #FCD34D; }
.count-rusak     { background: #FEF2F2; color: #991B1B; border: 1px solid #FCA5A5; }

/* ── Table ── */
.custom-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    table-layout: fixed; /* kunci kesejarajan kolom antar dua tabel */
}

/* Lebar kolom — identik di kedua tabel */
.col-no       { width: 56px;  text-align: center; }
.col-nama     { width: 22%; }
.col-kategori { width: 13%; }
.col-bidang   { width: 12%; }
.col-lokasi   { width: 14%; }
.col-jumlah   { width: 80px; }
.col-kondisi  { width: 150px; }
.col-aksi     { width: 210px; }

/* Header */
.custom-table thead tr {
    background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
}
.custom-table thead tr th {
    padding: 12px 16px;
    color: #fff;
    font-size: 11px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    border: none;
    vertical-align: middle;
    background: transparent;
}
.custom-table thead tr th:first-child { border-radius: 10px 0 0 0; }
.custom-table thead tr th:last-child  { border-radius: 0 10px 0 0; }

/* Body */
.custom-table tbody td {
    padding: 12px 16px;
    font-size: 13px;
    font-weight: 400;
    color: #4b5563;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
}
.custom-table tbody tr:last-child td { border-bottom: none; }
.custom-table tbody tr:hover { background: #f8fafc; }

.col-number { text-align: center; color: #9ca3af; }
.col-nama   { font-weight: 500; color: #1f2937; }

/* ── Lokasi ── */
.col-lokasi-cell {
    font-size: 13px;
    color: #6b7280;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.icon-lokasi {
    color: #ef4444;
    font-size: 12px;
    margin-right: 5px;
}

/* ── Badge Kategori & Bidang ── */
.badge-kategori {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 400;
    background: #f3f4f6;
    color: #4b5563;
    border: 1px solid #e5e7eb;
}
.badge-bidang {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 400;
    background: #eef2ff;
    color: #3730a3;
    border: 1px solid #c7d2fe;
}

/* ── Badge Jumlah ── */
.badge-warning-count,
.badge-danger-count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 30px;
    padding: 3px 10px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
}
.badge-warning-count { background: #FFF8E1; color: #B45309; border: 1px solid #FCD34D; }
.badge-danger-count  { background: #FEF2F2; color: #991B1B; border: 1px solid #FCA5A5; }

/* ── Badge Kondisi ── */
.badge-kondisi {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 400;
}
.kondisi-perbaikan { background: #FFF8E1; color: #B45309; border: 1px solid #FCD34D; }
.kondisi-rusak     { background: #FEF2F2; color: #991B1B; border: 1px solid #FCA5A5; }

/* ── Aksi ── */
.aksi-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
.select-kondisi {
    flex: 1;
    min-width: 0;
    padding: 6px 10px;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 400;
    color: #374151;
    background: #fafafa;
    cursor: pointer;
}
.select-kondisi:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102,126,234,0.15);
}
.btn-check {
    width: 32px;
    height: 32px;
    flex-shrink: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    border-radius: 50%;
    background: #10b981;
    color: #fff;
    font-size: 13px;
    cursor: pointer;
    transition: background 0.2s, transform 0.15s;
}
.btn-check:hover {
    background: #059669;
    transform: scale(1.08);
}

/* ── Empty State ── */
.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    padding: 36px 0;
    color: #9ca3af;
}
.empty-state i { font-size: 32px; opacity: 0.7; }
.empty-state p { font-size: 13px; margin: 0; font-weight: 400; }
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
    const iconMap  = { baik: 'success', rusak: 'error', perlu_perbaikan: 'warning' };
    const colorMap = { baik: '#10b981', rusak: '#991B1B', perlu_perbaikan: '#B45309' };

    const extra = kondisi === 'baik'
        ? '<br><small style="color:#10b981;font-weight:500;">Barang akan kembali ke stok</small>'
        : '';

    Swal.fire({
        title: 'Update Kondisi Barang',
        html: `Ubah kondisi menjadi <strong>${labelMap[kondisi]}</strong>?${extra}`,
        icon: iconMap[kondisi],
        showCancelButton: true,
        confirmButtonColor: colorMap[kondisi],
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Update!',
        cancelButtonText: 'Batal',
    }).then(result => {
        if (!result.isConfirmed) return;

        const origHTML = btn.innerHTML;
        btn.disabled   = true;
        btn.innerHTML  = '<i class="fas fa-spinner fa-spin"></i>';

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
                    timer: 1400,
                    showConfirmButton: false,
                }).then(() => location.reload());
            } else {
                throw new Error(data.message ?? 'Terjadi kesalahan');
            }
        })
        .catch(err => {
            btn.disabled  = false;
            btn.innerHTML = origHTML;
            Swal.fire('Gagal!', err.message, 'error');
        });
    });
}
</script>

@endsection
