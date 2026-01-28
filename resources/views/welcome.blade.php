<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Inventaris Piksi</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<div class="container py-5">

    <div class="text-center mb-5">
        <h1 class="fw-bold">Sistem Inventaris Politeknik Piksi Ganesha</h1>
        <p class="text-muted">Aplikasi pengelolaan peminjaman dan pengembalian barang kampus</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h5 class="card-title">Login</h5>
                    <p class="card-text">Masuk ke sistem inventaris</p>
                    <a href="{{ route('login') }}" class="btn btn-primary w-100">Masuk</a>
                </div>
            </div>
        </div>
    </div>

</div>

</body>
</html>
