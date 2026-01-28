<!DOCTYPE html>
<html>
<head>
    <title>Petugas Kemahasiswaan</title>
</head>
<body>
    <h1>Dashboard Petugas Kemahasiswaan</h1>

    <p>Nama: {{ auth()->user()->name }}</p>
    <p>Bidang: {{ auth()->user()->bidang->nama_bidang }}</p>

    <hr>

    <ul>
        <li>Data Organisasi</li>
        <li>Data Beasiswa</li>
        <li>Kegiatan Mahasiswa</li>
    </ul>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
