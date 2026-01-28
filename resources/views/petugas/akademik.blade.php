<!DOCTYPE html>
<html>
<head>
    <title>Petugas Akademik</title>
</head>
<body>
    <h1>Dashboard Petugas Akademik</h1>

    <p>Nama: {{ auth()->user()->name }}</p>
    <p>Bidang: {{ auth()->user()->bidang->nama_bidang }}</p>

    <hr>

    <ul>
        <li>Input Data Mahasiswa</li>
        <li>Kelola Nilai</li>
        <li>Cetak Transkrip</li>
    </ul>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
