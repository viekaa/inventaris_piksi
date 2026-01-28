@extends('layouts.backend')
@section('title','Barang')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Daftar Barang</h3>
    <a href="{{ route('barang.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Barang</a>
</div>

<table class="table table-bordered">
    <thead class="table-primary">
        <tr>
            <th>#</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Lokasi</th>
            <th>Bidang</th>
            <th>Jumlah</th>
            <th>Stok</th>
            <th>Kondisi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($barang as $b)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $b->nama_barang }}</td>
            <td>{{ $b->kategori->nama_kategori }}</td>
            <td>{{ $b->lokasi->nama_lokasi }}</td>
            <td>{{ $b->bidang->nama_bidang }}</td>
            <td>{{ $b->jumlah_total }}</td>
            <td>{{ $b->stok }}</td>
            <td>{{ $b->kondisi_label }}</td>
            <td>
                <a href="{{ route('barang.edit',$b->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                <form action="{{ route('barang.destroy',$b->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus barang ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
