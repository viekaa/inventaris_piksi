@extends('layouts.backend')
@section('content')

<h3>Detail Kategori</h3>

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <td>{{ $kategori->id }}</td>
    </tr>
    <tr>
        <th>Nama Kategori</th>
        <td>{{ $kategori->nama_kategori }}</td>
    </tr>
    <tr>
        <th>Dibuat</th>
        <td>{{ $kategori->created_at }}</td>
    </tr>
    <tr>
        <th>Diupdate</th>
        <td>{{ $kategori->updated_at }}</td>
    </tr>
</table>

<a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">Kembali</a>

@endsection
