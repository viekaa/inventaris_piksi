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

<div class="container-fluid">

    {{-- ── STATISTIK UTAMA (ATAS) ─────────────────────────────────── --}}
    <div class="card-group mb-4">
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
                            <span class="badge bg-danger font-12 text-white font-weight-medium badge-pill ml-2">Perhatian</span>
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

    {{-- ── BARIS 2: KONDISI | STATISTIK | AKTIVITAS ──────────────── --}}
    <div class="row">
        <div class="col-lg-4 col-md-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body d-flex flex-column">
                    <h4 class="card-title">Kondisi Barang</h4>
                    <div class="mt-2" style="height:283px; width:100%;">
                        <canvas id="kondisiChart"></canvas>
                    </div>
                    <ul class="list-style-none mb-0 mt-auto">
                        <li><i class="fas fa-circle font-10 mr-2" style="color:#16A34A;"></i> <span class="text-muted">Baik</span></li>
                        <li class="mt-2"><i class="fas fa-circle font-10 mr-2" style="color:#CA8A04;"></i> <span class="text-muted">Perlu Perbaikan</span></li>
                        <li class="mt-2"><i class="fas fa-circle text-danger font-10 mr-2"></i> <span class="text-muted">Rusak</span></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body d-flex flex-column">
                    <h4 class="card-title">Statistik Per Bidang</h4>
                    <div class="table-responsive mt-3">
                        <table class="table no-wrap v-middle mb-0">
                            <thead>
                                <tr class="border-0">
                                    <th class="border-0 font-14 font-weight-medium text-muted">Bidang</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted text-center">Jml</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted text-center">Tipis</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statBidang as $stat)
                                <tr>
                                    <td class="border-top-0 px-2 py-3 font-weight-medium text-dark font-14">{{ $stat->nama }}</td>
                                    <td class="border-top-0 text-center px-2 py-3"><span class="badge bg-primary text-white badge-pill">{{ $stat->jumlah }}</span></td>
                                    <td class="border-top-0 text-center px-2 py-3">
                                        <span class="badge {{ $stat->stokMenipis > 0 ? 'bg-danger' : 'bg-success' }} text-white badge-pill">{{ $stat->stokMenipis }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-auto pt-3 border-top">
                        <a href="{{ route('admin.perbaikan.index') }}" class="btn btn-sm btn-outline-primary btn-block">
                            <i data-feather="settings" class="feather-sm"></i> Kelola Kondisi
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <h4 class="card-title">Aktivitas Terbaru</h4>
                    <div class="mt-4 activity">
                        @forelse($recentPeminjaman as $pinjam)
                        <div class="d-flex align-items-start border-left-line pb-3">
                            <a href="javascript:void(0)" class="btn btn-{{ $pinjam->status == 'dipinjam' ? 'warning' : 'success' }} btn-circle mb-2 btn-item">
                                <i data-feather="{{ $pinjam->status == 'dipinjam' ? 'shopping-cart' : 'check-circle' }}"></i>
                            </a>
                            <div class="ml-3">
                                <h5 class="text-dark font-weight-medium mb-1">{{ ucfirst($pinjam->status) }}</h5>
                                <p class="font-14 mb-0 text-muted">{{ $pinjam->nama_peminjam }} ({{ $pinjam->barang->bidang?->nama_bidang ?? '-' }})</p>
                                <span class="font-12 text-muted">{{ $pinjam->created_at->diffForHumans() }}</span>
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

    {{-- ── BARIS 3: PEMINJAMAN | RINGKASAN | STOK MENIPIS (SEJAJAR 3) ── --}}
    <div class="row">
        <div class="col-lg-4 col-md-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <h4 class="card-title mb-0">Peminjaman</h4>
                        <div class="ml-auto">
                            <a class="text-muted" href="{{ route('admin.peminjaman.index') }}"><i data-feather="external-link"></i></a>
                        </div>
                    </div>
                    <div class="mt-4" style="height: 300px;">
                        <canvas id="peminjamanChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <h4 class="card-title">Ringkasan Kondisi</h4>
                    @php
                        $totalBaik      = collect($statBidang)->sum('jmlBaik');
                        $totalPerbaikan = collect($statBidang)->sum('jmlPerluPerbaikan');
                        $totalRusak     = collect($statBidang)->sum('jmlRusak');
                        $grandTotal     = max($totalBaik + $totalPerbaikan + $totalRusak, 1);
                    @endphp
                    <div class="mt-4 activity">
                        <div class="d-flex align-items-start border-left-line pb-4">
                            <div class="btn btn-success btn-circle"><i data-feather="check-circle"></i></div>
                            <div class="ml-3 w-100">
                                <h5 class="text-dark font-weight-medium mb-1">Baik</h5>
                                <div class="progress mb-1" style="height:5px;"><div class="progress-bar bg-success" style="width:{{ round($totalBaik/$grandTotal*100) }}%"></div></div>
                                <small class="text-muted">{{ $totalBaik }} barang ({{ round($totalBaik/$grandTotal*100) }}%)</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-start border-left-line pb-4">
                            <div class="btn btn-warning btn-circle"><i data-feather="tool"></i></div>
                            <div class="ml-3 w-100">
                                <h5 class="text-dark font-weight-medium mb-1">Perbaikan</h5>
                                <div class="progress mb-1" style="height:5px;"><div class="progress-bar bg-warning" style="width:{{ round($totalPerbaikan/$grandTotal*100) }}%"></div></div>
                                <small class="text-muted">{{ $totalPerbaikan }} barang</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-start border-left-line">
                            <div class="btn btn-danger btn-circle"><i data-feather="alert-octagon"></i></div>
                            <div class="ml-3 w-100">
                                <h5 class="text-dark font-weight-medium mb-1">Rusak</h5>
                                <div class="progress mb-1" style="height:5px;"><div class="progress-bar bg-danger" style="width:{{ round($totalRusak/$grandTotal*100) }}%"></div></div>
                                <small class="text-muted">{{ $totalRusak }} barang</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <h4 class="card-title">Barang Stok Menipis</h4>
                    <div class="table-responsive mt-2">
                        <table class="table no-wrap v-middle mb-0">
                            <thead>
                                <tr class="border-0">
                                    <th class="border-0 font-13 font-weight-medium text-muted">Barang</th>
                                    <th class="border-0 font-13 font-weight-medium text-muted text-center">Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($barangHabis as $item)
                                <tr>
                                    <td class="border-top-0 py-2">
                                        <div class="font-weight-medium text-dark font-14">{{ Str::limit($item->nama_barang, 20) }}</div>
                                        <small class="text-muted">{{ $item->nama_bidang ?? '-' }}</small>
                                    </td>
                                    <td class="border-top-0 py-2 text-center">
                                        <span class="badge bg-danger text-white">{{ $item->stok }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="2" class="text-center py-4 text-muted font-14">Aman! Stok tersedia.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function () {
    // Chart Kondisi
    const kondisiCtx = document.getElementById('kondisiChart');
    if (kondisiCtx) {
        new Chart(kondisiCtx, {
            type: 'bar',
            data: {
                labels: @json(collect($statBidang)->pluck('nama')->values()),
                datasets: [
                    { label:'Baik', data:@json(collect($statBidang)->map(fn($s)=>(int)($s->jmlBaik??0))->values()), backgroundColor:'#16A34A', borderRadius:4 },
                    { label:'Perlu Perbaikan', data:@json(collect($statBidang)->map(fn($s)=>(int)($s->jmlPerluPerbaikan??0))->values()), backgroundColor:'#CA8A04', borderRadius:4 },
                    { label:'Rusak', data:@json(collect($statBidang)->map(fn($s)=>(int)($s->jmlRusak??0))->values()), backgroundColor:'#DC2626', borderRadius:4 },
                ],
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
        });
    }

    // Chart Peminjaman
    const peminjamanCtx = document.getElementById('peminjamanChart');
    if (peminjamanCtx) {
        new Chart(peminjamanCtx, {
            type: 'bar',
            data: {
                labels: @json(collect($statBidang)->pluck('nama')->values()),
                datasets: [
                    { label:'Dipinjam', data:@json(collect($statBidang)->map(fn($s)=>(int)($s->dipinjam??0))->values()), backgroundColor:'#4F46E5', borderRadius:6 },
                    { label:'Dikembalikan', data:@json(collect($statBidang)->map(fn($s)=>(int)($s->dikembalikan??0))->values()), backgroundColor:'#059669', borderRadius:6 },
                ],
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'top' } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
        });
    }
})();
</script>
@endpush

@endsection
