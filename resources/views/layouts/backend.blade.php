<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/favicon.png')}}">
    <title>Inpiksi</title>
    <link href="{{asset('assets/dist/css/style.min.css')}}" rel="stylesheet">
</head>
<body>
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6"
        data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed"
        data-boxed-layout="full">

        @include('layouts.backend.navbar')
        @include('layouts.backend.sidebar')

        <div class="page-wrapper">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>

    </div>

    <script src="{{asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('assets/libs/popper.js/dist/umd/popper.min.js')}}"></script>
    <script src="{{asset('assets/libs/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js')}}"></script>
    <script src="{{asset('assets/dist/js/sidebarmenu.js')}}"></script>
    <script src="{{asset('assets/dist/js/custom.min.js')}}"></script>
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    {{-- Toggle sidebar kustom kita — load SETELAH semua JS template --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof feather !== 'undefined') feather.replace();

        const toggleDesktop = document.getElementById('sidebarToggleDesktop');
        const toggleMobile  = document.getElementById('sidebarToggleMobile');
        const overlay       = document.getElementById('sidebarOverlay');

        if (toggleDesktop) {
            toggleDesktop.addEventListener('click', function () {
                document.body.classList.toggle('mini-sidebar');
            });
        }

        if (toggleMobile) {
            toggleMobile.addEventListener('click', function () {
                document.body.classList.toggle('sidebar-open');
            });
        }

        if (overlay) {
            overlay.addEventListener('click', function () {
                document.body.classList.remove('sidebar-open');
            });
        }
    });
    </script>

    @stack('scripts')
    @include('sweetalert::alert')
</body>
</html>
