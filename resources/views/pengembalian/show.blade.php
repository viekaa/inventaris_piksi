@extends('layouts.backend')
@section('content')

<h3>Detail Pengembalian</h3>

<table class="table table-bordered">
<tr><th>Barang</th><td>{{ $pengembalian->peminjaman->barang->nama_barang }}</td></tr>
<tr><th>Peminjam</th><td>{{ $pengembalian->peminjaman->nama_peminjam }}</td></tr>
<tr><th>Jumlah</th><td>{{ $pengembalian->jumlah_kembali }}</td></tr>
<tr><th>Tanggal Kembali</th><td>{{ $pengembalian->tgl_kembali }}</td></tr>
<tr><th>Kondisi</th><td>{{ $pengembalian->kondisi_saat_kembali }}</td></tr>
</table>

<a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Kembali</a>
@endsection
