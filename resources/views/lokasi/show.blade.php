@extends('layouts.backend')
@section('content')

<h3>Detail Lokasi</h3>

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <td>{{ $lokasi->id }}</td>
    </tr>
    <tr>
        <th>Nama Lokasi</th>
        <td>{{ $lokasi->nama_lokasi }}</td>
    </tr>
    <tr>
        <th>Dibuat</th>
        <td>{{ $lokasi->created_at }}</td>
    </tr>
    <tr>
        <th>Diupdate</th>
        <td>{{ $lokasi->updated_at }}</td>
    </tr>
</table>

<a href="{{ route('lokasi.index') }}" class="btn btn-secondary">Kembali</a>

@endsection
