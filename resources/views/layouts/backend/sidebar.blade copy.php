<aside class="left-sidebar" data-sidebarbg="skin6">
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">

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

                <li class="list-divider"></li>
                <li class="sidebar-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="sidebar-link btn btn-link text-left w-100">
                            <i data-feather="log-out" class="feather-icon"></i>
                            <span class="hide-menu">Logout</span>
                        </button>
                    </form>
                </li>

            </ul>
        </nav>
    </div>
</aside>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<style>
/* Override sidebar template — hanya yang perlu */

/* Transisi width */
.left-sidebar {
    transition: width 0.3s ease !important;
    overflow: hidden !important;
}

.scroll-sidebar {
    overflow-x: hidden !important;
}

/* Feather icon size */
.feather-icon {
    flex-shrink: 0 !important;
    width: 18px !important;
    height: 18px !important;
    min-width: 18px !important;
}

/* Sidebar link flex */
.sidebar-nav .sidebar-link {
    display: flex !important;
    align-items: center !important;
    white-space: nowrap !important;
}

/* Hide-menu transition */
.sidebar-nav .hide-menu {
    transition: opacity 0.2s ease, max-width 0.25s ease !important;
    opacity: 1 !important;
    max-width: 180px !important;
    overflow: hidden !important;
    display: inline-block !important;
    white-space: nowrap !important;
}

/* ===== MINI SIDEBAR ===== */
body.mini-sidebar .left-sidebar {
    width: 65px !important;
}

body.mini-sidebar .sidebar-nav .hide-menu {
    opacity: 0 !important;
    max-width: 0 !important;
    pointer-events: none !important;
}

body.mini-sidebar .sidebar-nav .sidebar-link {
    justify-content: center !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
}

body.mini-sidebar .sidebar-nav .nav-small-cap {
    opacity: 0 !important;
    height: 0 !important;
    overflow: hidden !important;
    padding: 0 !important;
    margin: 0 !important;
}

body.mini-sidebar .sidebar-nav .list-divider {
    opacity: 0 !important;
    margin-top: 0 !important;
    margin-bottom: 0 !important;
    height: 0 !important;
}

body.mini-sidebar .sidebar-nav .badge {
    display: none !important;
}

/* Page wrapper ikut menyempit */
body.mini-sidebar .page-wrapper {
    margin-left: 65px !important;
}

/* ===== OVERLAY MOBILE ===== */
.sidebar-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.4);
    z-index: 1040;
}

body.sidebar-open .sidebar-overlay {
    display: block;
}

/* ===== MOBILE ===== */
@media (max-width: 767px) {
    body.mini-sidebar .left-sidebar {
        width: 240px !important;
    }

    body.mini-sidebar .sidebar-nav .hide-menu {
        opacity: 1 !important;
        max-width: 180px !important;
        pointer-events: auto !important;
    }

    body.mini-sidebar .sidebar-nav .sidebar-link {
        justify-content: flex-start !important;
        padding-left: revert !important;
        padding-right: revert !important;
    }

    body.mini-sidebar .sidebar-nav .nav-small-cap {
        opacity: 1 !important;
        height: auto !important;
        overflow: visible !important;
        padding: revert !important;
        margin: revert !important;
    }

    body.mini-sidebar .sidebar-nav .list-divider {
        opacity: 1 !important;
        margin: revert !important;
        height: auto !important;
    }

    body.mini-sidebar .page-wrapper {
        margin-left: 0 !important;
    }
}
</style>
