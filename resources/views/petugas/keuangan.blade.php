<!DOCTYPE html>
<html>
<head>
    <title>Petugas Keuangan</title>
</head>
<body>
    <h1>Dashboard Petugas Keuangan</h1>

    <p>Nama: {{ auth()->user()->name }}</p>
    <p>Bidang: {{ auth()->user()->bidang->nama_bidang }}</p>

    <hr>

    <ul>
        <li>Input Pembayaran</li>
        <li>Lihat Tagihan</li>
        <li>Laporan Keuangan</li>
    </ul>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
