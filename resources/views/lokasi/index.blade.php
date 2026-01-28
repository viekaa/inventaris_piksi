@extends('layouts.backend')
@section('content')

<h3>Data Lokasi</h3>

<a href="{{ route('lokasi.create') }}" class="btn btn-primary mb-2">Tambah Lokasi</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Lokasi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($lokasis as $index => $lokasi)
        <tr>
            <td>{{ $index+1 }}</td>
            <td>{{ $lokasi->nama_lokasi }}</td>
            <td>
                <a href="{{ route('lokasi.show', $lokasi->id) }}" class="btn btn-info btn-sm">Lihat</a>
                <a href="{{ route('lokasi.edit', $lokasi->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('lokasi.destroy', $lokasi->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau hapus?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
