@extends('layouts.backend')
@section('title','Detail Barang')

@section('content')
<h3>Detail Barang</h3>
<table class="table table-striped">
    <tr><th>Nama Barang</th><td>{{ $barang->nama_barang }}</td></tr>
    <tr><th>Kategori</th><td>{{ $barang->kategori->nama_kategori }}</td></tr>
    <tr><th>Lokasi</th><td>{{ $barang->lokasi->nama_lokasi }}</td></tr>
    <tr><th>Bidang</th><td>{{ $barang->bidang->nama_bidang }}</td></tr>
    <tr><th>Jumlah Total</th><td>{{ $barang->jumlah_total }}</td></tr>
    <tr><th>Stok</th><td>{{ $barang->stok }}</td></tr>
    <tr><th>Kondisi</th><td>{{ ucfirst($barang->kondisi) }}</td></tr>
</table>
<a href="{{ route('barang.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Kembali</a>
@endsection
