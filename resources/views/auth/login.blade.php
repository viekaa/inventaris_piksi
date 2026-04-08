<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/favicon.png')}}">
    <title>Login Inpiksi</title>
    <!-- Custom CSS -->
    <link href="{{asset('assets/dist/css/style.min.css')}}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<style>
    .logo-img {
    height: 80px;
    width: auto;
    object-fit: contain;
    flex-shrink: 0;
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
.logo-text-group {
    display: flex;
    flex-direction: column;
    line-height: 1;
    gap: 2px;
}
.auth-card {
    width: 350px;
    height: 450px; /* bebas mau 400, 500, dll */
    border-radius: 10px;
}

</style>
@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Akses Ditolak',
        text: '{{ session('error') }}'
    });
</script>
@endif
<body>
    <div class="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative"
            style="background:url({{ asset('assets/images/big/auth-bg.jpg') }}) no-repeat center center;">
            <div class="auth-box row">
                <center>
                <div class="auth-card  bg-white">
                    <div class="p-3">
                        <div class="text-center">
                            <img src="{{ asset('storage/images/logo_crop.png') }}" alt="Inpiksi Logo" class="logo-img">
                        </div>
                        <br><h3>Selamat Datang!</h3>
                        <form method="POST" action="{{ route('login') }}" class="mt-4">
                         @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group text-left">
                                        <label class="text-dark" for="email">Email</label>
                                        <input class="form-control" name="email" type="text"
                                            placeholder="enter your email">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group text-left">
                                        <label class="text-dark" for="password">Kata sandi</label>
                                        <input class="form-control" name="password" type="password"
                                            placeholder="enter your password">
                                    </div>
                                </div>
                                <div class="col-lg-12 mt-4 text-center">
                                    <button type="submit" class="btn btn-block btn-dark">Masuk</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            </center>
        </div>
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <script src="{{asset('assets/libs/jquery/dist/jquery.min.js')}} "></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{asset('assets/libs/popper.js/dist/umd/popper.min.js')}} "></script>
    <script src="{{asset('assets/libs/bootstrap/dist/js/bootstrap.min.js')}} "></script>
    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    <script>
        $(".preloader ").fadeOut();
    </script>
    @include('sweetalert::alert')
</body>

</html>
