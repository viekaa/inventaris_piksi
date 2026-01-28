<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Dashboard Admin</h1>

    <p>Selamat datang, {{ auth()->user()->name }}</p>
    <p>Role: {{ auth()->user()->role }}</p>

    <hr>

    <ul>
        <li>Kelola User</li>
        <li>Kelola Bidang</li>
        <li>Laporan Sistem</li>
    </ul>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
