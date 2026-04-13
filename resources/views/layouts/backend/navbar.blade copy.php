<header class="topbar" data-navbarbg="skin6">
    <nav class="navbar top-navbar navbar-expand-md">
        <div class="navbar-header" data-logobg="skin6">

            <a class="nav-toggler d-block d-md-none" href="javascript:void(0)" id="sidebarToggleMobile"
               style="display:flex;align-items:center;padding:0 12px;color:#6d28d9;">
                <i data-feather="menu" style="width:24px;height:24px;"></i>
            </a>

            <div class="navbar-brand">
                {{-- Fix: logo link sesuai role --}}
                @php
                    if(auth()->user()->role == 'admin') {
                        $logoHref = route('admin.dashboard');
                    } else {
                        $map = [
                            'Akademik'      => 'petugas.akademik',
                            'Keuangan'      => 'petugas.keuangan',
                            'Kemahasiswaan' => 'petugas.kemahasiswaan',
                            'Umum'          => 'petugas.umum',
                        ];
                        $logoHref = route($map[auth()->user()->bidang->nama_bidang] ?? 'petugas.umum');
                    }
                @endphp
                <a href="{{ $logoHref }}" class="logo-link">
                    <div class="logo-stack">
                        <img src="{{ asset('storage/images/logo_crop.png') }}" alt="Logo" class="logo-img">
                        <div class="logo-text-group">
                            <span class="logo-inventaris">inventaris</span>
                            <span class="logo-piksi">piksi</span>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <ul class="navbar-nav float-left mr-auto ml-2">
                <li class="nav-item d-none d-md-flex align-items-center">
                    <a class="nav-link px-2" href="javascript:void(0)" id="sidebarToggleDesktop">
                        <i data-feather="menu" style="width:22px;height:22px;color:#6d28d9;"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<style>
@import url('https://fonts.googleapis.com/css2?family=Righteous&family=Nunito:wght@600;700&display=swap');

.topbar,
.topbar[data-navbarbg="skin6"] {
    background: #fff !important;
    box-shadow: 0 1px 0 #f0ebff !important;
    border-bottom: none !important;
}

.navbar-header,
.navbar-header[data-logobg="skin6"] {
    background: #fff !important;
    display: flex !important;
    align-items: center !important;
    overflow: hidden !important;
    transition: width 0.3s ease !important;
}

.top-navbar {
    min-height: 70px !important;
    padding: 0 !important;
}

.navbar-brand {
    padding: 0 !important;
    margin: 0 !important;
    height: 70px !important;
    display: flex !important;
    align-items: center !important;
    padding-left: 16px !important;
}

.logo-link {
    text-decoration: none !important;
    display: flex;
    align-items: center;
}

.logo-stack {
    display: flex;
    align-items: center;
    gap: 10px;
    white-space: nowrap;
}

.logo-img {
    height: 42px;
    width: auto;
    object-fit: contain;
    flex-shrink: 0;
}

.logo-text-group {
    display: flex;
    flex-direction: column;
    line-height: 1;
    gap: 1px;
    overflow: hidden;
    opacity: 1;
    max-width: 140px;
    transition: opacity 0.2s ease, max-width 0.3s ease;
}

.logo-inventaris {
    font-family: 'Nunito', sans-serif;
    font-size: 9px;
    font-weight: 700;
    color: #7c3aed;
    letter-spacing: 4px;
    text-transform: uppercase;
    padding-left: 2px;
}

.logo-piksi {
    font-family: 'Righteous', cursive;
    font-size: 26px;
    background: linear-gradient(135deg, #6d28d9 0%, #a855f7 45%, #f5b731 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    letter-spacing: 1px;
    line-height: 1;
}

#navbarSupportedContent {
    height: 70px !important;
    display: flex !important;
    align-items: center !important;
}

body.mini-sidebar .logo-text-group {
    opacity: 0 !important;
    max-width: 0 !important;
    pointer-events: none !important;
}

@media (max-width: 767px) {
    body.mini-sidebar .logo-text-group {
        opacity: 1 !important;
        max-width: 140px !important;
    }
}
</style>

{{-- Script toggle di sini — jalan di SEMUA layout yang include navbar --}}
<script>
(function() {
    function initSidebar() {
        var toggleDesktop = document.getElementById('sidebarToggleDesktop');
        var toggleMobile  = document.getElementById('sidebarToggleMobile');
        var overlay       = document.getElementById('sidebarOverlay');

        if (toggleDesktop && !toggleDesktop._bound) {
            toggleDesktop._bound = true;
            toggleDesktop.addEventListener('click', function () {
                document.body.classList.toggle('mini-sidebar');
            });
        }

        if (toggleMobile && !toggleMobile._bound) {
            toggleMobile._bound = true;
            toggleMobile.addEventListener('click', function () {
                document.body.classList.toggle('sidebar-open');
            });
        }

        if (overlay && !overlay._bound) {
            overlay._bound = true;
            overlay.addEventListener('click', function () {
                document.body.classList.remove('sidebar-open');
            });
        }

        // Render feather icons
        if (typeof feather !== 'undefined') feather.replace();
    }

    // Jalan saat DOM ready, apapun layout-nya
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSidebar);
    } else {
        // DOM sudah ready (script di-load belakangan)
        initSidebar();
    }

    // Fallback: jalankan lagi setelah semua script selesai
    window.addEventListener('load', initSidebar);
})();
</script>
