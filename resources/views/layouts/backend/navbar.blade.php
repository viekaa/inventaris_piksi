<header class="topbar" data-navbarbg="skin6">
    <nav class="navbar top-navbar navbar-expand-md">
        <div class="navbar-header" data-logobg="skin6">
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                <i class="ti-menu ti-close"></i>
            </a>

            <div class="navbar-brand">
                <a href="{{ route('admin.dashboard') }}" class="logo-link">
                    <div class="logo-stack">
                        <div class="logo-wordmark">
                            <span class="logo-icon-text">In</span><span class="logo-main-text">piksi</span>
                        </div>
                        <div class="logo-sub">inventaris piksi</div>
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
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@800;900&display=swap');

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
    height: 72px !important;
    padding: 0 14px !important;
}

.navbar-brand {
    padding: 0 !important;
    margin: 0 !important;
    margin-top: 20px !important;
    height: 72px !important;
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
    flex-direction: column;
    line-height: 1;
    gap: 0;
}

.logo-wordmark {
    display: inline-flex;
    align-items: baseline;
    line-height: 1;
}

.logo-icon-text {
    font-family: 'Syne', sans-serif;
    font-size: 36px;
    font-weight: 900;
    font-style: italic;
    color: #f5b731;
    letter-spacing: -2px;
    text-shadow: none;
}

.logo-main-text {
    font-family: 'Syne', sans-serif;
    font-size: 36px;
    font-weight: 900;
    background: linear-gradient(135deg, #9333ea 0%, #c084fc 50%, #e879f9 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    letter-spacing: -2px;
    filter: none;
}

.logo-sub {
    font-family: 'Syne', sans-serif;
    font-size: 10.5px;
    font-weight: 800;
    color: #a78bfa;
    letter-spacing: 3px;
    text-transform: uppercase;
    padding-left: 3px;
    margin-top: 2px;
    text-shadow: none;
}
</style>
