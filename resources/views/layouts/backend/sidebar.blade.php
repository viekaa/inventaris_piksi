<aside class="left-sidebar" data-sidebarbg="skin6">
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">

                {{-- DASHBOARD --}}
                <li class="sidebar-item">
                    @if(auth()->user()->role == 'admin')
                        <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
                    @elseif(auth()->user()->role == 'petugas')
                        @php
                            $map = [
                                'Akademik'      => 'petugas.akademik',
                                'Keuangan'      => 'petugas.keuangan',
                                'Kemahasiswaan' => 'petugas.kemahasiswaan',
                                'Umum'          => 'petugas.umum',
                            ];
                            $route = $map[auth()->user()->bidang->nama_bidang] ?? 'petugas.umum';
                        @endphp
                        <a class="sidebar-link" href="{{ route($route) }}">
                    @endif
                        <i data-feather="home" class="feather-icon"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                <li class="list-divider"></li>

                {{-- ADMIN ONLY --}}
                @if(auth()->user()->role == 'admin')
                    <li class="nav-small-cap"><span class="hide-menu">Manajemen</span></li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.kategori.index') }}">
                            <i data-feather="tag" class="feather-icon"></i>
                            <span class="hide-menu">Kategori</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.lokasi.index') }}">
                            <i data-feather="map-pin" class="feather-icon"></i>
                            <span class="hide-menu">Lokasi</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.petugas.index') }}">
                            <i data-feather="users" class="feather-icon"></i>
                            <span class="hide-menu">Pengguna</span>
                        </a>
                    </li>
                @endif

                {{-- ADMIN + PETUGAS --}}
                @if(in_array(auth()->user()->role, ['admin', 'petugas']))
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">Operasional</span></li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('barang.index') }}">
                            <i data-feather="box" class="feather-icon"></i>
                            <span class="hide-menu">Barang</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link"
                           href="{{ auth()->user()->role == 'admin'
                                ? route('admin.peminjaman.index')
                                : route('petugas.peminjaman.index') }}">
                            <i data-feather="arrow-up-right" class="feather-icon"></i>
                            <span class="hide-menu">Peminjaman</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link"
                           href="{{ auth()->user()->role == 'admin'
                                ? route('admin.pengembalian.index')
                                : route('petugas.pengembalian.index') }}">
                            <i data-feather="arrow-down-left" class="feather-icon"></i>
                            <span class="hide-menu">Pengembalian</span>
                        </a>
                    </li>

                    {{-- KONDISI BARANG: admin only --}}
                    @if(auth()->user()->role == 'admin')
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.perbaikan.index') }}">
                                <i data-feather="tool" class="feather-icon"></i>
                                <span class="hide-menu">Kondisi Barang</span>
                                @if(isset($jumlahPerhatian) && $jumlahPerhatian > 0)
                                    <span class="badge badge-danger badge-pill ml-auto">{{ $jumlahPerhatian }}</span>
                                @endif
                            </a>
                        </li>
                    @endif

                @endif

                {{-- LOGOUT --}}
                <li class="list-divider"></li>
                <li class="sidebar-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="sidebar-link btn btn-link text-left w-100">
                            <i data-feather="log-out" class="feather-icon"></i>
                            <span class="hide-menu">Logout</span>
                        </button>
                    </form>
                </li>

            </ul>
        </nav>
    </div>
</aside>
