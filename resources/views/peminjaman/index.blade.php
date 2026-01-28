@extends('layouts.backend')
@section('content')

<h3>Data Peminjaman</h3>
<a href="{{ route('peminjaman.create') }}" class="btn btn-primary mb-2">+ Peminjaman</a>

<table class="table table-bordered">
<tr>
<th>Barang</th><th>Peminjam</th><th>Jumlah</th><th>Pinjam</th><th>Kembali</th><th>Aksi</th>
</tr>

@foreach($peminjaman as $p)
<tr>
<td>{{ $p->barang->nama_barang }}</td>
<td>{{ $p->nama_peminjam }}</td>
<td>{{ $p->jumlah }}</td>
<td>{{ $p->tgl_pinjam }}</td>
<td>{{ $p->tgl_kembali_rencana }}</td>
<td>
@if(!$p->pengembalian)
<a href="{{ route('pengembalian.create',$p->id) }}" class="btn btn-success btn-sm">Kembalikan</a>
@endif
</td>
</tr>
@endforeach
</table>
@endsection
