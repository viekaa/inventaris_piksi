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
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-5 align-self-center">
            <div class="float-right">
                <span class="text-muted font-14">
                    {{ now()->locale('id')->translatedFormat('l, d F Y') }}
                    &middot; {{ now()->setTimezone('Asia/Jakarta')->format('H:i') }} WIB
                </span>
            </div>
        </div>
    </div>
</div>

{{-- ── CONTAINER FLUID (sama persis dengan Adminmart) ─────────────── --}}
<div class="container-fluid">

    {{-- ── STATISTIK UTAMA ─────────────────────────────────────────── --}}
    <div class="card-group">
        <div class="card border-right">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center">
                    <div>
                        <div class="d-inline-flex align-items-center">
                            <h2 class="text-dark mb-1 font-weight-medium">{{ $totalBarang }}</h2>
                        </div>
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
                        <div class="d-inline-flex align-items-center">
                            <h2 class="text-dark mb-1 font-weight-medium">{{ $stokMenipis }}</h2>
                            @if($stokMenipis > 0)
                            <span class="badge bg-danger font-12 text-white font-weight-medium badge-pill ml-2 d-lg-block d-md-none">Perhatian</span>
                            @endif
                        </div>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Stok Menipis</h6>
                    </div>
                    <div class="ml-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-muted"><i data-feather="alert-triangle"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── BARIS 2: KONDISI BARANG | STATISTIK | AKTIVITAS ─────────── --}}
    <div class="row">

        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Kondisi Barang</h4>
                    <div class="mt-2" style="height:283px; width:100%;">
                        <canvas id="kondisiChart" style="height:100%;width:100%;"></canvas>
                    </div>
                    <ul class="list-style-none mb-0 mt-2">
                        <li>
                            <i class="fas fa-circle font-10 mr-2" style="color:#16A34A;"></i>
                            <span class="text-muted">Baik</span>
                        </li>
                        <li class="mt-3">
                            <i class="fas fa-circle font-10 mr-2" style="color:#CA8A04;"></i>
                            <span class="text-muted">Perlu Perbaikan</span>
                        </li>
                        <li class="mt-3">
                            <i class="fas fa-circle text-danger font-10 mr-2"></i>
                            <span class="text-muted">Rusak</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Statistik Per Bidang</h4>
                    <div class="table-responsive mt-3">
                        <table class="table no-wrap v-middle mb-0">
                            <thead>
                                <tr class="border-0">
                                    <th class="border-0 font-14 font-weight-medium text-muted">Bidang</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted text-center">Jumlah</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted text-center">Menipis</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statBidang as $stat)
                                <tr>
                                    <td class="border-top-0 px-2 py-3 font-weight-medium text-dark font-14">{{ $stat->nama }}</td>
                                    <td class="border-top-0 text-center px-2 py-3">
                                        <span class="badge bg-primary font-12 text-white badge-pill">{{ $stat->jumlah }}</span>
                                    </td>
                                    <td class="border-top-0 text-center px-2 py-3">
                                        <span class="badge {{ $stat->stokMenipis > 0 ? 'bg-danger' : 'bg-success' }} font-12 text-white badge-pill">
                                            {{ $stat->stokMenipis }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 pt-2 border-top">
                        <a href="{{ route('admin.perbaikan.index') }}" class="btn btn-sm btn-outline-primary">
                            <i data-feather="settings" style="width:14px;height:14px;margin-right:4px;vertical-align:middle;"></i>
                            Kelola Kondisi
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12">
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
                                    {{ $pinjam->nama_peminjam }}<br>
                                    {{ $pinjam->barang->bidang?->nama_bidang ?? '-' }}
                                </p>
                                <span class="font-weight-light font-14 text-muted">{{ $pinjam->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted">Belum ada aktivitas.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ── BARIS 3: PEMINJAMAN CHART + RINGKASAN KONDISI ───────────── --}}
    <div class="row">

        <div class="col-md-6 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <h4 class="card-title mb-0">Peminjaman Per Bidang</h4>
                        <div class="ml-auto">
                            <div class="dropdown sub-dropdown">
                                <button class="btn btn-link text-muted dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i data-feather="more-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ route('admin.peminjaman.index') }}">Lihat Semua</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pl-4 mb-5">
                        <div style="height: 315px; position:relative;" class="mt-2">
                            <canvas id="peminjamanChart"></canvas>
                        </div>
                    </div>
                    <ul class="list-inline text-center mt-4 mb-0">
                        <li class="list-inline-item text-muted font-italic">Peminjaman &amp; pengembalian per bidang</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Ringkasan Kondisi</h4>
                    @php
                        $totalBaik      = collect($statBidang)->sum('jmlBaik');
                        $totalPerbaikan = collect($statBidang)->sum('jmlPerluPerbaikan');
                        $totalRusak     = collect($statBidang)->sum('jmlRusak');
                        $grandTotal     = max($totalBaik + $totalPerbaikan + $totalRusak, 1);
                    @endphp
                    <div class="mt-4 activity">

                        <div class="d-flex align-items-start border-left-line pb-3">
                            <div>
                                <a href="javascript:void(0)" class="btn btn-success btn-circle mb-2 btn-item">
                                    <i data-feather="check-circle"></i>
                                </a>
                            </div>
                            <div class="ml-3 mt-2 w-100">
                                <h5 class="text-dark font-weight-medium mb-2">Kondisi Baik</h5>
                                <p class="font-14 mb-2 text-muted">{{ $totalBaik }} barang dalam kondisi baik</p>
                                <div class="progress mb-1" style="height:5px;">
                                    <div class="progress-bar bg-success" style="width:{{ round($totalBaik/$grandTotal*100) }}%"></div>
                                </div>
                                <span class="font-weight-light font-14 d-block text-muted">{{ round($totalBaik/$grandTotal*100) }}% dari total</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-start border-left-line pb-3">
                            <div>
                                <a href="javascript:void(0)" class="btn btn-warning btn-circle mb-2 btn-item">
                                    <i data-feather="tool"></i>
                                </a>
                            </div>
                            <div class="ml-3 mt-2 w-100">
                                <h5 class="text-dark font-weight-medium mb-2">Perlu Perbaikan</h5>
                                <p class="font-14 mb-2 text-muted">{{ $totalPerbaikan }} barang perlu diperbaiki</p>
                                <div class="progress mb-1" style="height:5px;">
                                    <div class="progress-bar bg-warning" style="width:{{ round($totalPerbaikan/$grandTotal*100) }}%"></div>
                                </div>
                                <span class="font-weight-light font-14 d-block text-muted">{{ round($totalPerbaikan/$grandTotal*100) }}% dari total</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-start border-left-line">
                            <div>
                                <a href="javascript:void(0)" class="btn btn-danger btn-circle mb-2 btn-item">
                                    <i data-feather="alert-octagon"></i>
                                </a>
                            </div>
                            <div class="ml-3 mt-2 w-100">
                                <h5 class="text-dark font-weight-medium mb-2">Rusak</h5>
                                <p class="font-14 mb-2 text-muted">{{ $totalRusak }} barang dalam kondisi rusak</p>
                                <div class="progress mb-1" style="height:5px;">
                                    <div class="progress-bar bg-danger" style="width:{{ round($totalRusak/$grandTotal*100) }}%"></div>
                                </div>
                                <span class="font-weight-light font-14 d-block text-muted">{{ round($totalRusak/$grandTotal*100) }}% dari total</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ── BARIS 4: BARANG STOK MENIPIS ────────────────────────────── --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <h4 class="card-title">Barang Stok Menipis</h4>
                        <div class="ml-auto">
                            <div class="dropdown sub-dropdown">
                                <button class="btn btn-link text-muted dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i data-feather="more-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ route('barang.index') }}">Lihat Semua Barang</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table no-wrap v-middle mb-0">
                            <thead>
                                <tr class="border-0">
                                    <th class="border-0 font-14 font-weight-medium text-muted">Nama Barang</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted px-2">Bidang</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted">Lokasi</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted text-center">Stok</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($barangHabis as $item)
                                <tr>
                                    <td class="border-top-0 px-2 py-4">
                                        <h5 class="text-dark mb-0 font-16 font-weight-medium">{{ $item->nama_barang }}</h5>
                                    </td>
                                    <td class="border-top-0 text-muted px-2 py-4 font-14">{{ $item->nama_bidang ?? '-' }}</td>
                                    <td class="border-top-0 text-muted px-2 py-4 font-14">{{ $item->nama_lokasi ?? '-' }}</td>
                                    <td class="border-top-0 text-center px-2 py-4">
                                        <span class="badge bg-warning font-12 text-white font-weight-medium badge-pill">{{ $item->stok }}</span>
                                    </td>
                                    <td class="border-top-0 text-center px-2 py-4">
                                        <i class="fa fa-circle text-danger font-12"
                                            data-toggle="tooltip" data-placement="top" title="Stok Menipis"></i>
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
    </div>

    {{-- ── BARIS 5: DETAIL PEMINJAMAN PER BIDANG ───────────────────── --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <h4 class="card-title">Detail Peminjaman Per Bidang</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table no-wrap v-middle mb-0">
                            <thead>
                                <tr class="border-0">
                                    <th class="border-0 font-14 font-weight-medium text-muted">Bidang</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted text-center">Jumlah Barang</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted text-center">Dipinjam</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted text-center">Dikembalikan</th>
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
                                        <span class="badge bg-primary font-12 text-white badge-pill">{{ $stat->jumlah }}</span>
                                    </td>
                                    <td class="border-top-0 text-center px-2 py-4">
                                        <span class="badge bg-warning font-12 text-white badge-pill">{{ $stat->dipinjam }}</span>
                                    </td>
                                    <td class="border-top-0 text-center px-2 py-4">
                                        <span class="badge bg-success font-12 text-white badge-pill">{{ $stat->dikembalikan }}</span>
                                    </td>
                                    <td class="border-top-0 text-center px-2 py-4">
                                        <span class="badge {{ $stat->stokMenipis > 0 ? 'bg-danger' : 'bg-success' }} font-12 text-white badge-pill">
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
    </div>

</div>
{{-- END CONTAINER FLUID --}}

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function () {

    // ── CHART 1: KONDISI BARANG PER BIDANG ──────────────────────────
    const kondisiCtx = document.getElementById('kondisiChart');
    if (kondisiCtx) {
        const bidang    = @json(collect($statBidang)->pluck('nama')->values());
        const baik      = @json(collect($statBidang)->map(fn($s) => (int)($s->jmlBaik ?? 0))->values());
        const perbaikan = @json(collect($statBidang)->map(fn($s) => (int)($s->jmlPerluPerbaikan ?? 0))->values());
        const rusak     = @json(collect($statBidang)->map(fn($s) => (int)($s->jmlRusak ?? 0))->values());

        new Chart(kondisiCtx, {
            type: 'bar',
            data: {
                labels: bidang,
                datasets: [
                    { label:'Baik',           data:baik,      backgroundColor:'rgba(22,163,74,0.85)',  borderColor:'#16A34A', borderWidth:1, borderRadius:4, borderSkipped:false },
                    { label:'Perlu Perbaikan',data:perbaikan, backgroundColor:'rgba(202,138,4,0.85)',  borderColor:'#CA8A04', borderWidth:1, borderRadius:4, borderSkipped:false },
                    { label:'Rusak',          data:rusak,     backgroundColor:'rgba(220,38,38,0.85)',  borderColor:'#DC2626', borderWidth:1, borderRadius:4, borderSkipped:false },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: { label: ctx => ` ${ctx.dataset.label}: ${ctx.raw} barang` } },
                },
                scales: {
                    x: { grid:{ display:false }, ticks:{ font:{ size:11 }, color:'#6B7280' }, border:{ display:false } },
                    y: { beginAtZero:true, grid:{ color:'rgba(0,0,0,0.04)' }, ticks:{ stepSize:1, precision:0, font:{ size:10 }, color:'#9CA3AF' }, border:{ display:false } },
                },
                barPercentage: 0.55,
                categoryPercentage: 0.65,
            },
        });
    }

    // ── CHART 2: PEMINJAMAN PER BIDANG ──────────────────────────────
    const peminjamanCtx = document.getElementById('peminjamanChart');
    if (peminjamanCtx) {
        const bidang2      = @json(collect($statBidang)->pluck('nama')->values());
        const dipinjam     = @json(collect($statBidang)->map(fn($s) => (int)($s->dipinjam ?? 0))->values());
        const dikembalikan = @json(collect($statBidang)->map(fn($s) => (int)($s->dikembalikan ?? 0))->values());

        new Chart(peminjamanCtx, {
            type: 'bar',
            data: {
                labels: bidang2,
                datasets: [
                    { label:'Dipinjam',    data:dipinjam,     backgroundColor:'rgba(79,70,229,0.80)', borderColor:'#4F46E5', borderWidth:1, borderRadius:6, borderSkipped:false },
                    { label:'Dikembalikan',data:dikembalikan, backgroundColor:'rgba(5,150,105,0.80)', borderColor:'#059669', borderWidth:1, borderRadius:6, borderSkipped:false },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        align: 'end',
                        labels: { font:{ size:12 }, color:'#6B7280', boxWidth:12, usePointStyle:true },
                    },
                    tooltip: { callbacks: { label: ctx => ` ${ctx.dataset.label}: ${ctx.raw}` } },
                },
                scales: {
                    x: { grid:{ display:false }, ticks:{ font:{ size:12 }, color:'#6B7280' }, border:{ display:false } },
                    y: { beginAtZero:true, grid:{ color:'rgba(0,0,0,0.04)' }, ticks:{ stepSize:1, precision:0, font:{ size:11 }, color:'#9CA3AF' }, border:{ display:false } },
                },
                barPercentage: 0.60,
                categoryPercentage: 0.70,
            },
        });
    }

})();
</script>
@endpush

@endsection
