@extends('layouts.backend')

@section('content')

{{-- ── BREADCRUMB ─────────────────────────────────────────────────── --}}
<div class="page-breadcrumb pb-2" style="padding-top: 10px; padding-left: 10px;">
    <div class="row align-items-end">
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
        <div class="col-5 align-self-center text-right">
            <span class="text-muted font-14">{{ now()->translatedFormat('l, d F Y') }}</span>
        </div>
    </div>
</div>

{{-- ── STATISTIK UTAMA (tidak diubah) ────────────────────────────── --}}
<div class="card-group mb-3" style="margin-top: 16px;">
    <div class="card border-right">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div>
                    <h2 class="text-dark mb-1 font-weight-medium">{{ $totalBarang }}</h2>
                    <h6 class="text-muted font-weight-normal mb-0">Total Barang</h6>
                </div>
                <div class="ml-auto">
                    <span class="stat-icon stat-icon-primary"><i data-feather="package"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-right">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div>
                    <h2 class="text-dark mb-1 font-weight-medium">{{ $totalPeminjaman }}</h2>
                    <h6 class="text-muted font-weight-normal mb-0">Total Peminjaman</h6>
                </div>
                <div class="ml-auto">
                    <span class="stat-icon stat-icon-info"><i data-feather="shopping-cart"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-right">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div>
                    <h2 class="text-dark mb-1 font-weight-medium">{{ $totalPengembalian }}</h2>
                    <h6 class="text-muted font-weight-normal mb-0">Total Pengembalian</h6>
                </div>
                <div class="ml-auto">
                    <span class="stat-icon stat-icon-success"><i data-feather="rotate-ccw"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div>
                    <h2 class="text-dark mb-1 font-weight-medium">{{ $stokMenipis }}</h2>
                    <h6 class="text-muted font-weight-normal mb-0">Stok Menipis</h6>
                </div>
                <div class="ml-auto">
                    <span class="stat-icon stat-icon-danger"><i data-feather="alert-triangle"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── STATUS KONDISI BARANG: KARTU + DIAGRAM BATANG PER BIDANG ───── --}}
<div class="row mb-3">
    {{-- 3 KARTU KONDISI (tidak bisa diklik) --}}
    <div class="col-lg-4 col-md-12 mb-2">
        <div class="d-flex flex-column" style="gap:10px; height:100%;">

            {{-- BAIK --}}
            <div class="kondisi-card kondisi-baik">
                <div class="kondisi-card-icon"><i data-feather="check-circle"></i></div>
                <div class="kondisi-card-info">
                    <div class="kondisi-card-value">{{ $jmlBaik }}</div>
                    <div class="kondisi-card-label">Kondisi Baik</div>
                    <div class="kondisi-card-sub">Tersedia di stok</div>
                </div>
                <div class="kondisi-card-pct">{{ $totalBarang > 0 ? round(($jmlBaik/$totalBarang)*100) : 0 }}%</div>
            </div>

            {{-- PERLU PERBAIKAN --}}
            <div class="kondisi-card kondisi-perbaikan {{ $jmlPerluPerbaikan > 0 ? 'kondisi-attention' : '' }}">
                <div class="kondisi-card-icon"><i data-feather="tool"></i></div>
                <div class="kondisi-card-info">
                    <div class="kondisi-card-value">{{ $jmlPerluPerbaikan }}</div>
                    <div class="kondisi-card-label">Perlu Perbaikan</div>
                    <div class="kondisi-card-sub">{{ $jmlPerluPerbaikan > 0 ? 'Perlu ditangani' : 'Tidak ada masalah' }}</div>
                </div>
                <div class="kondisi-card-pct">{{ $totalBarang > 0 ? round(($jmlPerluPerbaikan/$totalBarang)*100) : 0 }}%</div>
            </div>

            {{-- RUSAK --}}
            <div class="kondisi-card kondisi-rusak {{ $jmlRusak > 0 ? 'kondisi-attention' : '' }}">
                <div class="kondisi-card-icon"><i data-feather="alert-octagon"></i></div>
                <div class="kondisi-card-info">
                    <div class="kondisi-card-value">{{ $jmlRusak }}</div>
                    <div class="kondisi-card-label">Rusak</div>
                    <div class="kondisi-card-sub">{{ $jmlRusak > 0 ? 'Perlu ditangani' : 'Tidak ada masalah' }}</div>
                </div>
                <div class="kondisi-card-pct">{{ $totalBarang > 0 ? round(($jmlRusak/$totalBarang)*100) : 0 }}%</div>
            </div>

        </div>
    </div>

    {{-- DIAGRAM BATANG PER BIDANG --}}
    <div class="col-lg-8 col-md-12 mb-2">
        <div class="card h-100" style="border-radius:24px;">
            <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h6 style="font-size:13px; font-weight:500; color:#374151; margin-bottom:2px;">Kondisi Barang per Bidang</h6>
                        <small class="text-muted" style="font-size:11px;">Baik · Perlu Perbaikan · Rusak</small>
                    </div>
                    <div class="d-flex align-items-center" style="gap:10px; flex-wrap:wrap;">
                        <div class="d-flex align-items-center" style="gap:4px;">
                            <span style="width:9px;height:9px;border-radius:2px;background:#16A34A;display:inline-block;"></span>
                            <span style="font-size:11px;color:#6B7280;">Baik</span>
                        </div>
                        <div class="d-flex align-items-center" style="gap:4px;">
                            <span style="width:9px;height:9px;border-radius:2px;background:#CA8A04;display:inline-block;"></span>
                            <span style="font-size:11px;color:#6B7280;">Perlu Perbaikan</span>
                        </div>
                        <div class="d-flex align-items-center" style="gap:4px;">
                            <span style="width:9px;height:9px;border-radius:2px;background:#DC2626;display:inline-block;"></span>
                            <span style="font-size:11px;color:#6B7280;">Rusak</span>
                        </div>
                    </div>
                </div>

                <div style="position:relative; height:180px;">
                    <canvas id="kondisiChart"></canvas>
                </div>

                <div style="margin-top:10px; padding-top:10px; border-top:1px solid #f3f4f6;">
                    <a href="{{ route('admin.perbaikan.index') }}" class="btn-kelola-kondisi">
                        <span class="btn-kelola-circle">
                            <i class="fas fa-cog" style="font-size:10px; color:#4F46E5;"></i>
                        </span>
                        Kelola Kondisi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── ALERT ───────────────────────────────────────────────────────── --}}
@if($jmlRusak > 0 || $jmlPerluPerbaikan > 0)
<div class="alert d-flex align-items-center mb-3"
     style="border-radius:12px;border-left:4px solid #F9A825;background:#FFFDE7;border:1px solid #FDE68A;">
    <i data-feather="info" style="width:15px;height:15px;color:#F57F17;flex-shrink:0;margin-right:10px;"></i>
    <div style="font-size:12px;color:#5D4037;font-weight:400;">
        Terdapat <strong style="font-weight:600;">{{ $jmlPerluPerbaikan }} barang perlu perbaikan</strong>
        dan <strong style="font-weight:600;">{{ $jmlRusak }} barang rusak</strong>.
        Barang tidak masuk stok sampai kondisinya diubah jadi Baik.
        <a href="{{ route('admin.perbaikan.index') }}" style="color:#E65100;font-weight:500;margin-left:4px;">Kelola →</a>
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
                                <th class="border-0 font-14 font-weight-medium text-muted text-center">Jumlah</th>
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

<style>
.stat-icon {
    display:inline-flex; align-items:center; justify-content:center;
    width:44px; height:44px; border-radius:12px; opacity:0.85;
}
.stat-icon svg { width:22px; height:22px; }
.stat-icon-primary { background:#EEF2FF; color:#4F46E5; }
.stat-icon-info    { background:#EFF6FF; color:#2563EB; }
.stat-icon-success { background:#ECFDF5; color:#059669; }
.stat-icon-danger  { background:#FEF2F2; color:#DC2626; }

/* kondisi card — tidak ada pointer/link */
.kondisi-card {
    display:flex; align-items:center; gap:12px;
    padding:14px 18px;
    border-radius:24px; border:1.5px solid transparent;
    position:relative; overflow:hidden;
    cursor:default;
}
.kondisi-baik      { background:#F0FDF4; border-color:#BBF7D0; }
.kondisi-perbaikan { background:#FFFBEB; border-color:#FDE68A; }
.kondisi-rusak     { background:#FFF1F2; border-color:#FECDD3; }

.kondisi-attention { animation:pulse-border 2.5s ease-in-out infinite; }
@keyframes pulse-border {
    0%,100% { box-shadow:0 0 0 0 transparent; }
    50%      { box-shadow:0 0 0 4px rgba(239,68,68,0.12); }
}

.kondisi-card-icon {
    display:flex; align-items:center; justify-content:center;
    width:38px; height:38px; border-radius:14px; flex-shrink:0;
}
.kondisi-baik .kondisi-card-icon      { background:#DCFCE7; color:#16A34A; }
.kondisi-perbaikan .kondisi-card-icon { background:#FEF9C3; color:#CA8A04; }
.kondisi-rusak .kondisi-card-icon     { background:#FFE4E6; color:#DC2626; }
.kondisi-card-icon svg { width:18px; height:18px; }

.kondisi-card-info { flex:1; }
.kondisi-card-value { font-size:22px; font-weight:600; line-height:1; margin-bottom:2px; }
.kondisi-baik .kondisi-card-value      { color:#15803D; }
.kondisi-perbaikan .kondisi-card-value { color:#B45309; }
.kondisi-rusak .kondisi-card-value     { color:#B91C1C; }

.kondisi-card-label { font-size:12px; font-weight:500; margin-bottom:2px; }
.kondisi-baik .kondisi-card-label      { color:#166534; }
.kondisi-perbaikan .kondisi-card-label { color:#92400E; }
.kondisi-rusak .kondisi-card-label     { color:#9F1239; }

.kondisi-card-sub { font-size:10px; font-weight:400; }
.kondisi-baik .kondisi-card-sub      { color:#4ADE80; }
.kondisi-perbaikan .kondisi-card-sub { color:#D97706; }
.kondisi-rusak .kondisi-card-sub     { color:#F87171; }

.kondisi-card-pct {
    font-size:18px; font-weight:500; opacity:0.1;
    position:absolute; right:12px; top:50%; transform:translateY(-50%);
    letter-spacing:-1px;
}

.btn-kelola-kondisi {
    display:inline-flex; align-items:center; gap:7px;
    padding:5px 14px 5px 6px; border-radius:20px;
    border:1px solid #e5e7eb; background:#fff;
    font-size:12px; font-weight:400; color:#4b5563;
    text-decoration:none !important;
    transition:background 0.15s, border-color 0.15s;
}
.btn-kelola-kondisi:hover { background:#f5f3ff; border-color:#c4b5fd; color:#4F46E5; }
.btn-kelola-circle {
    width:22px; height:22px; border-radius:50%;
    background:#EEF2FF; display:inline-flex;
    align-items:center; justify-content:center; flex-shrink:0;
}
.btn-kelola-kondisi:hover .btn-kelola-circle { background:#ddd6fe; }
</style>

@push('scripts')
<script src="{{ asset('assets/extra-libs/c3/d3.min.js') }}"></script>
<script src="{{ asset('assets/extra-libs/c3/c3.min.js') }}"></script>
<script src="{{ asset('assets/libs/chartist/dist/chartist.min.js') }}"></script>
<script src="{{ asset('assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}"></script>
<script src="{{ asset('assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ asset('assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('assets/dist/js/pages/dashboards/dashboard1.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function () {
    const ctx = document.getElementById('kondisiChart');
    if (!ctx) return;

    const bidang    = @json(collect($statBidang)->pluck('nama')->values());
    const baik      = @json(collect($statBidang)->map(fn($s) => (int)($s->jmlBaik ?? 0))->values());
    const perbaikan = @json(collect($statBidang)->map(fn($s) => (int)($s->jmlPerluPerbaikan ?? 0))->values());
    const rusak     = @json(collect($statBidang)->map(fn($s) => (int)($s->jmlRusak ?? 0))->values());

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: bidang,
            datasets: [
                { label:'Baik', data:baik, backgroundColor:'rgba(22,163,74,0.80)', borderColor:'#16A34A', borderWidth:1, borderRadius:5, borderSkipped:false },
                { label:'Perlu Perbaikan', data:perbaikan, backgroundColor:'rgba(202,138,4,0.80)', borderColor:'#CA8A04', borderWidth:1, borderRadius:5, borderSkipped:false },
                { label:'Rusak', data:rusak, backgroundColor:'rgba(220,38,38,0.80)', borderColor:'#DC2626', borderWidth:1, borderRadius:5, borderSkipped:false },
            ],
        },
        options: {
            responsive:true, maintainAspectRatio:false,
            plugins: {
                legend:{ display:false },
                tooltip:{
                    callbacks:{ label: ctx => ` ${ctx.dataset.label}: ${ctx.raw} barang` }
                },
            },
            scales: {
                x:{ grid:{ display:false }, ticks:{ font:{ size:11 }, color:'#6B7280' }, border:{ display:false } },
                y:{ beginAtZero:true, grid:{ color:'rgba(0,0,0,0.04)' }, ticks:{ stepSize:1, precision:0, font:{ size:10 }, color:'#9CA3AF' }, border:{ display:false } },
            },
            barPercentage:0.55, categoryPercentage:0.65,
        },
    });
})();
</script>
@endpush
@endsection
