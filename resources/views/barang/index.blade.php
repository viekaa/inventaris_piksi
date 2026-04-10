@extends('layouts.backend')

@section('content')

<div class="container-fluid">

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
            <div class="card custom-card">
                <div class="card-body p-4">

                   <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title mb-1">Data Barang</h4>
                            <p class="card-subtitle">Kelola inventori barang Anda</p>
                        </div>

                        <div class="header-actions">

                            <div class="search-wrapper">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text"
                                    id="searchBarang"
                                    class="search-input"
                                    placeholder="Cari barang...">
                            </div>

                            <a href="{{ route('barang.export-pdf', request()->query()) }}"
                            class="btn-export-pdf"
                            target="_blank">
                                <i class="fas fa-file-pdf"></i>
                                <span>Export PDF</span>
                            </a>

                            <a href="{{ route('barang.create') }}" class="btn-add">
                                <i class="fas fa-plus-circle"></i>
                                <span>Tambah Barang</span>
                            </a>

                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th class="col-no">No</th>
                                    <th class="text-center" style="width: 80px;">Foto</th> <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Bidang</th>
                                    <th>Lokasi</th>
                                    <th class="text-center col-stok">Stok</th>
                                    <th class="text-center col-total">Jumlah Total</th>
                                    <th class="text-center col-kondisi">Kondisi</th>
                                    <th class="text-center col-aksi">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barang as $item)
                                <tr>
                                    <td class="col-number">{{ $loop->iteration }}</td>

                                    <td class="text-center">
                                        <div class="foto-wrapper">
                                            @if($item->foto)
                                                <img src="{{ asset('storage/' . $item->foto) }}" alt="foto" class="img-barang-circle">
                                            @else
                                                <div class="img-placeholder-circle">
                                                    <i class="fas fa-box text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="col-nama">{{ $item->nama_barang }}</td>
                                    <td>
                                        <span class="badge-kategori">
                                            {{ $item->kategori->nama_kategori }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge-bidang">
                                            {{ $item->bidang->nama_bidang ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="col-lokasi">
                                        <i class="fas fa-map-marker-alt icon-lokasi"></i>
                                        {{ $item->lokasi->nama_lokasi }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-stok">{{ $item->stok }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-total">{{ $item->jumlah_total }}</span>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $badge = match($item->kondisi) {
                                                'baik'            => ['bg' => '#E8F8F0', 'text' => '#2E7D32', 'label' => 'Baik'],
                                                'rusak'           => ['bg' => '#FDECEA', 'text' => '#C62828', 'label' => 'Rusak'],
                                                'perlu_perbaikan' => ['bg' => '#FFF8E1', 'text' => '#F9A825', 'label' => 'Perlu Perbaikan'],
                                                default           => ['bg' => '#ECEFF1', 'text' => '#546E7A', 'label' => ucfirst($item->kondisi)],
                                            };
                                        @endphp

                                        <span class="badge-kondisi" style="background: {{ $badge['bg'] }}; color: {{ $badge['text'] }};">
                                            {{ $badge['label'] }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('barang.show', $item->id) }}"
                                            class="btn-action btn-detail"
                                            title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a href="{{ route('barang.edit', $item->id) }}"
                                               class="btn-action btn-edit"
                                               title="Edit">
                                                <i class="far fa-edit"></i>
                                            </a>

                                            <form action="{{ route('barang.destroy', $item->id) }}"
                                                  method="POST"
                                                  class="d-inline-block"
                                                  onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-delete" title="Hapus">
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
    /* Tambahan Style untuk Foto Bulat */
    .foto-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .img-barang-circle {
        width: 45px;
        height: 45px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #e5e7eb;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .img-placeholder-circle {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background-color: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px dashed #d1d5db;
    }

    /* CSS kamu yang lama tetap di bawah ini */
    .badge-bidang {
        display: inline-block;
        padding: 6px 14px;
        background: #eef2ff;
        color: #3730a3;
        border: 1px solid #c7d2fe;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.2px;
    }
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
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-export-pdf:hover {
        background: #dc2626;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(220, 38, 38, 0.3);
        text-decoration: none;
    }

    .btn-export-pdf i { font-size: 15px; }

    :root {
        --font-primary: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        --font-mono: "SF Mono", Monaco, "Cascadia Code", "Roboto Mono", Consolas, monospace;
    }

    body {
        font-family: var(--font-primary);
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    .custom-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04), 0 1px 2px rgba(0, 0, 0, 0.06);
        transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .custom-card:hover {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08), 0 2px 4px rgba(0, 0, 0, 0.06);
    }

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

    .search-input:focus {
        outline: none;
        border-color: #3b82f6;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }

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

    .custom-table {
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .custom-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .custom-table thead tr th {
        padding: 18px 16px;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        border: none;
        vertical-align: middle;
    }

    .custom-table thead tr th:first-child { border-radius: 12px 0 0 0; }
    .custom-table thead tr th:last-child { border-radius: 0 12px 0 0; }

    .col-no { width: 60px; }
    .custom-table tbody td {
        padding: 16px;
        vertical-align: middle;
        color: #374151;
        font-size: 14px;
    }

    .badge-stok, .badge-total {
        display: inline-block;
        padding: 6px 14px;
        background: #eff6ff;
        color: #1e40af;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        font-family: var(--font-mono);
    }

    .badge-kondisi {
        display: inline-block;
        padding: 7px 18px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border: none;
        border-radius: 10px;
        transition: all 0.25s ease;
    }

    .btn-detail { background: #ffc107; color: #fff; }
    .btn-edit { background: #6c757d; color: #fff; }
    .btn-delete { background: #dc3545; color: #fff; }

    .btn-action:hover {
        transform: translateY(-3px) scale(1.05);
    }
</style>

<script>
document.getElementById('searchBarang').addEventListener('keyup', function(e) {
    const keyword = e.target.value.toLowerCase();
    document.querySelectorAll('.custom-table tbody tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(keyword) ? '' : 'none';
    });
});
</script>

@endsection
