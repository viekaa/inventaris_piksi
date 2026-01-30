@extends('layouts.backend')
@section('content')

<h3>Detail Peminjaman</h3>

<table class="table table-bordered">
<tr><th>Barang</th><td>{{ $peminjaman->barang->nama_barang }}</td></tr>
<tr><th>Peminjam</th><td>{{ $peminjaman->nama_peminjam }}</td></tr>
<tr><th>Jumlah</th><td>{{ $peminjaman->jumlah }}</td></tr>
<tr><th>Tanggal Pinjam</th><td>{{ $peminjaman->tgl_pinjam }}</td></tr>
<tr><th>Rencana Kembali</th><td>{{ $peminjaman->tgl_kembali_rencana }}</td></tr>
<tr><th>Kondisi</th><td>{{ $peminjaman->kondisi_saat_pinjam }}</td></tr>
</table>

<a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Kembali</a>
@endsection
