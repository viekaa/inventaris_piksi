@extends('layouts.backend')

@section('content')
<h3>Data Kategori</h3>

<a href="{{ route('kategori.create') }}" class="btn btn-primary mb-3">Tambah Kategori</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Kategori</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($kategoris as $index => $kategori)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $kategori->nama_kategori }}</td>
            <td>
                <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau hapus?')">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="3" class="text-center">Belum ada data kategori</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
