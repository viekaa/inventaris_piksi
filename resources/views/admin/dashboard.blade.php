@extends('layouts.backend')

@section('content')

{{-- ── BREADCRUMB ─────────────────────────────────────────────────── --}}
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">
                Selamat Datang, {{ auth()->user()->name }}!
            </h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="#">Administrator</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

{{-- ── STATISTIK ATAS ──────────────────────────────────────────────── --}}
<div class="card-group">
    <div class="card border-right">
        <div class="card-body">
            <div class="d-flex d-lg-flex d-md-block align-items-center">
                <div>
                    <h2 class="text-dark mb-1 font-weight-medium">{{ $totalBarang }}</h2>
                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Barang</h6>
                </div>
                <div class="ml-auto mt-md-3 mt-lg-0">
                    <span class="opacity-7 text-muted"><i data-feather="package"></i></span>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-right">
        <div class="card-body">
            <div class="d-flex d-lg-flex d-md-block align-items-center">
                <div>
                    <h2 class="text-dark mb-1 font-weight-medium">{{ $totalPeminjaman }}</h2>
                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Peminjaman</h6>
                </div>
                <div class="ml-auto mt-md-3 mt-lg-0">
                    <span class="opacity-7 text-muted"><i data-feather="shopping-cart"></i></span>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-right">
        <div class="card-body">
            <div class="d-flex d-lg-flex d-md-block align-items-center">
                <div>
                    <h2 class="text-dark mb-1 font-weight-medium">{{ $totalPengembalian }}</h2>
                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Pengembalian</h6>
                </div>
                <div class="ml-auto mt-md-3 mt-lg-0">
                    <span class="opacity-7 text-muted"><i data-feather="rotate-ccw"></i></span>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex d-lg-flex d-md-block align-items-center">
                <div>
                    <h2 class="text-dark mb-1 font-weight-medium">{{ $stokMenipis }}</h2>
                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Stok Menipis</h6>
                </div>
                <div class="ml-auto mt-md-3 mt-lg-0">
                    <span class="opacity-7 text-danger"><i data-feather="alert-triangle"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── KONDISI BARANG (hanya muncul kalau ada masalah) ───────────── --}}
@if($jmlRusak > 0 || $jmlPerluPerbaikan > 0)
<div class="row mt-3 mb-1">
    <div class="col-12 d-flex align-items-center">
        <h5 class="font-weight-medium text-dark mb-0 mr-2">Status Kondisi Barang</h5>
        <span class="badge badge-danger">Perlu Perhatian</span>
        <a href="{{ route('admin.perbaikan.index') }}" class="ml-auto btn btn-sm btn-outline-primary">
            Kelola Kondisi →
        </a>
    </div>
</div>
<div class="card-group mb-3">
    <div class="card border-right" style="border-left:4px solid #2E7D32!important;">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div>
                    <h2 class="mb-1 font-weight-medium" style="color:#2E7D32">{{ $jmlBaik }}</h2>
                    <h6 class="font-weight-normal mb-0" style="color:#388E3C">Kondisi Baik</h6>
                </div>
                <div class="ml-auto opacity-7" style="color:#2E7D32"><i data-feather="check-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="card border-right" style="border-left:4px solid #F9A825!important;">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div>
                    <h2 class="mb-1 font-weight-medium" style="color:#F57F17">{{ $jmlPerluPerbaikan }}</h2>
                    <h6 class="font-weight-normal mb-0" style="color:#F9A825">Perlu Perbaikan</h6>
                </div>
                <div class="ml-auto opacity-7" style="color:#F57F17"><i data-feather="tool"></i></div>
            </div>
        </div>
    </div>
    <div class="card" style="border-left:4px solid #C62828!important;">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div>
                    <h2 class="mb-1 font-weight-medium" style="color:#C62828">{{ $jmlRusak }}</h2>
                    <h6 class="font-weight-normal mb-0" style="color:#D32F2F">Rusak</h6>
                </div>
                <div class="ml-auto opacity-7" style="color:#C62828"><i data-feather="alert-octagon"></i></div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ── TABEL PER BIDANG ────────────────────────────────────────────── --}}
<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Statistik Barang Per Bidang</h4>
                <div class="table-responsive">
                    <table class="table no-wrap v-middle mb-0">
                        <thead>
                            <tr class="border-0">
                                <th class="border-0 font-14 font-weight-medium text-muted">Bidang</th>
                                <th class="border-0 font-14 font-weight-medium text-muted text-center">Jumlah Barang</th>
                                <th class="border-0 font-14 font-weight-medium text-muted text-center">Stok Menipis</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($statBidang as $stat)
                            <tr>
                                <td class="border-top-0 px-2 py-4">
                                    <h5 class="text-dark mb-0 font-16 font-weight-medium">{{ $stat->nama }}</h5>
                                </td>
                                <td class="border-top-0 text-center px-2 py-4">
                                    <span class="badge badge-primary font-14">{{ $stat->jumlah }}</span>
                                </td>
                                <td class="border-top-0 text-center px-2 py-4">
                                    <span class="badge {{ $stat->stokMenipis > 0 ? 'badge-danger' : 'badge-success' }} font-14">
                                        {{ $stat->stokMenipis }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Peminjaman Per Bidang</h4>
                <div class="table-responsive">
                    <table class="table no-wrap v-middle mb-0">
                        <thead>
                            <tr class="border-0">
                                <th class="border-0 font-14 font-weight-medium text-muted">Bidang</th>
                                <th class="border-0 font-14 font-weight-medium text-muted text-center">Dipinjam</th>
                                <th class="border-0 font-14 font-weight-medium text-muted text-center">Dikembalikan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($statBidang as $stat)
                            <tr>
                                <td class="border-top-0 px-2 py-4">
                                    <h5 class="text-dark mb-0 font-16 font-weight-medium">{{ $stat->nama }}</h5>
                                </td>
                                <td class="border-top-0 text-center px-2 py-4">
                                    <span class="badge badge-warning font-14">{{ $stat->dipinjam }}</span>
                                </td>
                                <td class="border-top-0 text-center px-2 py-4">
                                    <span class="badge badge-success font-14">{{ $stat->dikembalikan }}</span>
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

{{-- ── TABEL BAWAH ─────────────────────────────────────────────────── --}}
<div class="row">
    <div class="col-md-6 col-lg-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Barang Stok Menipis</h4>
                <div class="table-responsive">
                    <table class="table no-wrap v-middle mb-0">
                        <thead>
                            <tr class="border-0">
                                <th class="border-0 font-14 font-weight-medium text-muted">Nama Barang</th>
                                <th class="border-0 font-14 font-weight-medium text-muted">Bidang</th>
                                <th class="border-0 font-14 font-weight-medium text-muted">Lokasi</th>
                                <th class="border-0 font-14 font-weight-medium text-muted">Stok</th>
                                <th class="border-0 font-14 font-weight-medium text-muted">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($barangHabis as $item)
                            <tr>
                                <td class="border-top-0 px-2 py-4 font-14">{{ $item->nama_barang }}</td>
                                <td class="border-top-0 text-muted px-2 py-4 font-14">{{ $item->nama_bidang ?? '-' }}</td>
                                <td class="border-top-0 text-muted px-2 py-4 font-14">{{ $item->nama_lokasi ?? '-' }}</td>
                                <td class="border-top-0 px-2 py-4">
                                    <span class="badge badge-warning font-14">{{ $item->stok }}</span>
                                </td>
                                <td class="border-top-0 px-2 py-4">
                                    <span class="badge badge-danger">Menipis</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Tidak ada barang dengan stok menipis</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Aktivitas Terbaru</h4>
                <div class="mt-4 activity">
                    @forelse($recentPeminjaman as $pinjam)
                    <div class="d-flex align-items-start border-left-line pb-3">
                        <div>
                            <a href="javascript:void(0)"
                               class="btn btn-{{ $pinjam->status == 'dipinjam' ? 'warning' : 'success' }} btn-circle mb-2 btn-item">
                                <i data-feather="{{ $pinjam->status == 'dipinjam' ? 'shopping-cart' : 'check-circle' }}"></i>
                            </a>
                        </div>
                        <div class="ml-3 mt-2">
                            <h5 class="text-dark font-weight-medium mb-2">{{ ucfirst($pinjam->status) }}</h5>
                            <p class="font-14 mb-2 text-muted">
                                {{ $pinjam->nama_peminjam }} - {{ $pinjam->barang->bidang?->nama_bidang ?? '-' }}
                            </p>
                            <span class="font-weight-light font-14 text-muted">{{ $pinjam->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted">Belum ada aktivitas</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="{{asset('assets/extra-libs/c3/d3.min.js')}}"></script>
<script src="{{asset('assets/extra-libs/c3/c3.min.js')}}"></script>
<script src="{{asset('assets/libs/chartist/dist/chartist.min.js')}}"></script>
<script src="{{asset('assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js')}}"></script>
<script src="{{asset('assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js')}}"></script>
<script src="{{asset('assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js')}}"></script>
<script src="{{asset('assets/dist/js/pages/dashboards/dashboard1.min.js')}}"></script>
@endpush
@endsection
