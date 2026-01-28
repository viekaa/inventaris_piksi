<!DOCTYPE html>
<html>
<head>
    <title>Petugas Umum</title>
</head>
<body>
    <h1>Dashboard Petugas Umum</h1>

    <p>Nama: {{ auth()->user()->name }}</p>
    <p>Bidang: {{ auth()->user()->bidang->nama_bidang }}</p>

    <hr>

    <ul>
        <li>Surat Menyurat</li>
        <li>Arsip Dokumen</li>
        <li>Pelayanan Umum</li>
    </ul>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
