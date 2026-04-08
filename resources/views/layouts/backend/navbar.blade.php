<header class="topbar" data-navbarbg="skin6">
    <nav class="navbar top-navbar navbar-expand-md">
        <div class="navbar-header" data-logobg="skin6">
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                <i class="ti-menu ti-close"></i>
            </a>

            <div class="navbar-brand">
                <a href="{{ route('admin.dashboard') }}" class="logo-link">
                    <div class="logo-stack">
                        <img src="{{ asset('storage/images/logo_crop.png') }}" alt="Inpiksi Logo" class="logo-img">
                        <div class="logo-text-group">
                            <span class="logo-inventaris">inventaris</span>
                            <span class="logo-piksi">piksi</span>
                        </div>
                    </div>
                </a>
            </div>

            <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="ti-more"></i>
            </a>
        </div>

        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <ul class="navbar-nav float-left mr-auto ml-3 pl-1"></ul>
        </div>
    </nav>
</header>

<style>
@import url('https://fonts.googleapis.com/css2?family=Righteous&family=Nunito:wght@600;700&display=swap');

.topbar,
.topbar[data-navbarbg="skin6"] {
    background: transparent !important;
    box-shadow: none !important;
    border-bottom: none !important;
}

.navbar-header,
.navbar-header[data-logobg="skin6"] {
    background: transparent !important;
}

.top-navbar {
    min-height: 56px !important;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
}

.top-navbar .navbar-header {
    height: 110px !important;
    padding: 0 14px !important;
}

.navbar-brand {
    padding: 0 !important;
    margin: 0 !important;
    margin-top: 20px !important;
    height: 110px !important;
    display: flex !important;
    align-items: center !important;
}

.logo-link {
    text-decoration: none !important;
    display: inline-flex;
    padding: 0 !important;
}

.logo-stack {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 10px;
}

.logo-img {
    height: 60px;
    width: auto;
    object-fit: contain;
    flex-shrink: 0;
}

.logo-text-group {
    display: flex;
    flex-direction: column;
    line-height: 1;
    gap: 2px;
}

.logo-inventaris {
    font-family: 'Nunito', sans-serif;
    font-size: 11px;
    font-weight: 700;
    color: #7c3aed;
    letter-spacing: 5px;
    text-transform: uppercase;
    padding-left: 3px; /* supaya sejajar visual sama piksi */
}

.logo-piksi {
    font-family: 'Righteous', cursive;
    font-size: 36px;
    background: linear-gradient(135deg, #6d28d9 0%, #a855f7 45%, #f5b731 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    letter-spacing: 1px;
    line-height: 1;
}
</style>
