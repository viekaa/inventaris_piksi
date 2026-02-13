<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/favicon.png')}}">
    <title>Inpiksi - Admin Dashboard</title>
    <link href="{{asset('assets/extra-libs/c3/c3.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/libs/chartist/dist/chartist.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/dist/css/style.min.css')}}" rel="stylesheet">
</head>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">

       @include('layouts.backend.navbar')
        @include('layouts.backend.sidebar')

        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-7 align-self-center">
                        <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Selamat Datang, {{ auth()->user()->name }}!</h3>
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

            <div class="container-fluid">
                <!-- Card Statistics -->
                <div class="card-group">
                    <div class="card border-right">
                        <div class="card-body">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                    <div class="d-inline-flex align-items-center">
                                        <h2 class="text-dark mb-1 font-weight-medium">{{ \App\Models\Barang::count() }}</h2>
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
                                    <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium">{{ \App\Models\Peminjaman::count() }}</h2>
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
                                    <div class="d-inline-flex align-items-center">
                                        <h2 class="text-dark mb-1 font-weight-medium">{{ \App\Models\Pengembalian::count() }}</h2>
                                    </div>
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
                                    <h2 class="text-dark mb-1 font-weight-medium">{{ \App\Models\Barang::where('stok','<=',5)->count() }}</h2>
                                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Stok Menipis</h6>
                                </div>
                                <div class="ml-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-danger"><i data-feather="alert-triangle"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
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
                                            @php
                                                $bidangs = \App\Models\Bidang::all();
                                            @endphp
                                            @foreach($bidangs as $bidang)
                                            <tr>
                                                <td class="border-top-0 px-2 py-4">
                                                    <h5 class="text-dark mb-0 font-16 font-weight-medium">{{ $bidang->nama_bidang }}</h5>
                                                </td>
                                                <td class="border-top-0 text-center px-2 py-4">
                                                    @php
                                                        $jumlahBarang = \App\Models\Barang::where('bidang_id', $bidang->id)->count();
                                                    @endphp
                                                    <span class="badge badge-primary font-14">{{ $jumlahBarang }}</span>
                                                </td>
                                                <td class="border-top-0 text-center px-2 py-4">
                                                    @php
                                                        $stokMenipis = \App\Models\Barang::where('bidang_id', $bidang->id)->where('stok','<=',5)->count();
                                                    @endphp
                                                    <span class="badge {{ $stokMenipis > 0 ? 'badge-danger' : 'badge-success' }} font-14">{{ $stokMenipis }}</span>
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
                                            @foreach($bidangs as $bidang)
                                            <tr>
                                                <td class="border-top-0 px-2 py-4">
                                                    <h5 class="text-dark mb-0 font-16 font-weight-medium">{{ $bidang->nama_bidang }}</h5>
                                                </td>
                                                <td class="border-top-0 text-center px-2 py-4">
                                                    @php
                                                        $dipinjam = \App\Models\Peminjaman::whereHas('barang', function($q) use ($bidang) {
                                                    $q->where('bidang_id', $bidang->id);
                                                    })->where('status', 'dipinjam')->count();
                                                    @endphp
                                                    <span class="badge badge-warning font-14">{{ $dipinjam }}</span>
                                                </td>
                                                <td class="border-top-0 text-center px-2 py-4">
                                                    @php
                                                       $dikembalikan = \App\Models\Peminjaman::whereHas('barang', function($q) use ($bidang) {
                                                            $q->where('bidang_id', $bidang->id);
                                                        })->where('status', 'dikembalikan')->count();
                                                    @endphp
                                                    <span class="badge badge-success font-14">{{ $dikembalikan }}</span>
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

                <!-- Recent Activities -->
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
                                            @php
                                                $barangHabis = \App\Models\Barang::where('stok','<=',5)->with('bidang','lokasi')->latest()->take(5)->get();
                                            @endphp
                                            @forelse($barangHabis as $item)
                                            <tr>
                                                <td class="border-top-0 px-2 py-4 font-14">{{ $item->nama_barang }}</td>
                                                <td class="border-top-0 text-muted px-2 py-4 font-14">{{ $item->bidang->nama_bidang }}</td>
                                                <td class="border-top-0 text-muted px-2 py-4 font-14">{{ $item->lokasi->nama_lokasi }}</td>
                                                <td class="border-top-0 px-2 py-4">
                                                    <span class="badge badge-warning font-14">{{ $item->stok }}</span>
                                                </td>
                                                <td class="border-top-0 px-2 py-4">
                                                    <span class="badge badge-danger">Menipis</span>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4">Tidak ada barang dengan stok menipis</td>
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
                                    @php
                                       $recentPeminjaman = \App\Models\Peminjaman::with('barang.bidang')->latest()->take(4)->get();
                                    @endphp
                                    @forelse($recentPeminjaman as $pinjam)
                                    <div class="d-flex align-items-start border-left-line pb-3">
                                        <div>
                                            <a href="javascript:void(0)" class="btn btn-{{ $pinjam->status == 'dipinjam' ? 'warning' : 'success' }} btn-circle mb-2 btn-item">
                                                <i data-feather="{{ $pinjam->status == 'dipinjam' ? 'shopping-cart' : 'check-circle' }}"></i>
                                            </a>
                                        </div>
                                        <div class="ml-3 mt-2">
                                            <h5 class="text-dark font-weight-medium mb-2">{{ ucfirst($pinjam->status) }}</h5>
                                            <p class="font-14 mb-2 text-muted">{{ $pinjam->nama_peminjam }} - {{ $pinjam->barang->bidang?->nama_bidang ?? '-' }}
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
            </div>

            <footer class="footer text-center text-muted">
                All Rights Reserved by Inpiksi. Designed and Developed by <a href="https://wrappixel.com">WrapPixel</a>.
            </footer>
        </div>
    </div>

    <script src="{{asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('assets/libs/popper.js/dist/umd/popper.min.js')}}"></script>
    <script src="{{asset('assets/libs/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/dist/js/app-style-switcher.js')}}"></script>
    <script src="{{asset('assets/dist/js/feather.min.js')}}"></script>
    <script src="{{asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js')}}"></script>
    <script src="{{asset('assets/dist/js/sidebarmenu.js')}}"></script>
    <script src="{{asset('assets/dist/js/custom.min.js')}}"></script>
    <script>
        feather.replace();
    </script>
</body>
</html>
