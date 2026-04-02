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
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">

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
   <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>feather.replace();</script>
    <script src="{{asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js')}}"></script>
    <script src="{{asset('assets/dist/js/sidebarmenu.js')}}"></script>
    <script>
// Override preloader sebelum custom.min.js jalan
window.onload = null;
document.addEventListener('DOMContentLoaded', function(){
    var p = document.querySelector('.preloader');
    if(p) p.remove();
});
</script>
<script src="{{asset('assets/dist/js/custom.min.js')}}"></script>

    @stack('scripts')
    @include('sweetalert::alert')
</body>
</html>
