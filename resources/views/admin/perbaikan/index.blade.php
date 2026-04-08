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
                            <h4 class="card-title-perbaikan mb-1">
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
                                    <th class="text-center">Jumlah</th>
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
                                        {{-- jumlah_perlu_perbaikan diisi dari kolom/accessor di model, fallback ke stok --}}
                                        <span class="badge-warning-count">
                                            {{ $item->jumlah_perlu_perbaikan ?? $item->stok_rusak ?? 1 }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-kondisi kondisi-perbaikan">
                                            <i class="fas fa-tools mr-1"></i>Perlu Perbaikan
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="aksi-wrapper">
                                            <select class="select-kondisi" data-id="{{ $item->id }}" data-current="perlu_perbaikan">
                                                <option value="perlu_perbaikan" selected>Perlu Perbaikan</option>
                                                <option value="baik">Sudah Baik</option>
                                                <option value="rusak">Rusak</option>
                                            </select>
                                             <button class="btn btn-circle btn-success btn-sm btn-update-perbaikan" onclick="updateKondisi(this)">
                                                <i class=" fas fa-check"></i>
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
                            <h4 class="card-title-rusak mb-1">
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
                                    <th class="text-center">Jumlah</th>
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
                                        <span class="badge-danger-count">
                                            {{ $item->jumlah_rusak ?? $item->stok_rusak ?? 1 }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-kondisi kondisi-rusak">
                                            <i class="fas fa-exclamation-circle mr-1"></i>Rusak
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="aksi-wrapper">
                                            <select class="select-kondisi" data-id="{{ $item->id }}" data-current="rusak">
                                                <option value="rusak" selected>Rusak</option>
                                                <option value="baik">Sudah Baik</option>
                                                <option value="perlu_perbaikan">Perlu Perbaikan</option>
                                            </select>
                                            <button class="btn btn-circle btn-success btn-sm btn-update-rusak" onclick="updateKondisi(this)">
                                                <i class=" fas fa-check"></i>
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
.custom-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04), 0 1px 2px rgba(0,0,0,0.06);
    transition: box-shadow 0.3s;
}
.custom-card:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.08), 0 2px 4px rgba(0,0,0,0.06);
}
.card-title-rusak {
    font-size: 20px;
    font-weight: 400;
    color: #1a1a1a;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.card-title-perbaikan {
    font-size: 20px;
    font-weight: 400;
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
}
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
.icon-perbaikan { background:#FFF8E1; color:#F9A825; }
.icon-rusak     { background:#FDECEA; color:#C62828; }

.count-badge {
    display: inline-block;
    padding: 7px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
}
.count-perbaikan { background:#FFF8E1; color:#F57F17; border:1.5px solid #FFE082; }
.count-rusak     { background:#FDECEA; color:#C62828; border:1.5px solid #FFCDD2; }

.custom-table {
    margin: 0;
    border-collapse: separate;
    border-spacing: 0;
}
.custom-table thead {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.custom-table thead tr th {
    padding: 14px 16px;
    color: #fff;
    font-size: 11px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.7px;
    border: none;
    vertical-align: middle;
    white-space: nowrap;
}
.custom-table thead tr th:first-child { border-radius: 12px 0 0 0; }
.custom-table thead tr th:last-child  { border-radius: 0 12px 0 0; }
.col-no   { width: 56px; text-align: center; }
.col-aksi { width: 260px; }

.custom-table tbody tr {
    border-bottom: 1px solid #f1f5f9;
    transition: background 0.15s;
}
.custom-table tbody tr:last-child { border-bottom: none; }
.custom-table tbody tr:hover { background: #f8fafc; }
.custom-table tbody td {
    padding: 14px 16px;
    vertical-align: middle;
    color: #374151;
    font-size: 14px;
}
.col-number { font-weight: 600; color: #9ca3af; font-size: 13px; text-align: center; }
.col-nama   { font-weight: 600; color: #1f2937; }
.col-lokasi { color: #6b7280; font-size: 13px; }
.icon-lokasi { color: #ef4444; margin-right: 4px; font-size: 12px; }

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

/* jumlah rusak / perlu perbaikan */
.badge-warning-count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 36px;
    height: 36px;
    padding: 0 12px;
    background: #FFF8E1;
    color: #F57F17;
    border: 1.5px solid #FFE082;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 700;
}
.badge-danger-count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 36px;
    height: 36px;
    padding: 0 12px;
    background: #FDECEA;
    color: #C62828;
    border: 1.5px solid #FFCDD2;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 700;
}

.badge-kondisi {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 5px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
}
.kondisi-perbaikan { background:#FFF8E1; color:#F9A825; }
.kondisi-rusak     { background:#FDECEA; color:#C62828; }

/* ── aksi wrapper ── */
.aksi-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    flex-wrap: nowrap;
}
.select-kondisi {
    padding: 7px 10px;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 500;
    color: #374151;
    background: #fafafa;
    cursor: pointer;
    transition: border-color 0.2s;
    min-width: 145px;
    max-width: 145px;
}
.select-kondisi:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102,126,234,0.15);
}
.btn-update {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 7px 14px;
    border: none;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
    color: #fff;
}
/* .btn-update-perbaikan { background: #F57F17; }
.btn-update-perbaikan:hover { background: #e65100; transform: translateY(-1px); box-shadow: 0 4px 10px rgba(245,127,23,0.35); }
.btn-update-rusak:hover { background: #b71c1c; transform: translateY(-1px); box-shadow: 0 4px 10px rgba(198,40,40,0.35); } */

.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
    color: #9ca3af;
    padding: 40px 0;
}
.empty-state i { font-size: 36px; opacity: 0.7; }
.empty-state p { font-size: 14px; margin: 0; }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '{{ csrf_token() }}';

function updateKondisi(btn) {
    const row     = btn.closest('tr');
    const select  = row.querySelector('.select-kondisi');
    const id      = select.dataset.id;
    const kondisi = select.value;
    const labelMap = {
        baik: 'Sudah Baik',
        rusak: 'Rusak',
        perlu_perbaikan: 'Perlu Perbaikan'
    };
    const iconMap = {
        baik: 'success',
        rusak: 'error',
        perlu_perbaikan: 'warning'
    };

    const extra = kondisi === 'baik'
        ? '<br><small style="color:#10b981;font-weight:600;">Barang akan kembali ke stok</small>'
        : '';

    Swal.fire({
        title: 'Update Kondisi Barang',
        html: `Ubah kondisi menjadi <strong>${labelMap[kondisi]}</strong>?${extra}`,
        icon: iconMap[kondisi],
        showCancelButton: true,
        confirmButtonColor: kondisi === 'baik' ? '#10b981' : (kondisi === 'rusak' ? '#C62828' : '#F57F17'),
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Update!',
        cancelButtonText: 'Batal',
        borderRadius: '16px',
    }).then(result => {
        if (!result.isConfirmed) return;

        const origText = btn.innerHTML;
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
                    timer: 1400,
                    showConfirmButton: false,
                }).then(() => location.reload());
            } else {
                throw new Error(data.message ?? 'Terjadi kesalahan');
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerHTML = origText;
            Swal.fire('Gagal!', err.message, 'error');
        });
    });
}
</script>

@endsection
