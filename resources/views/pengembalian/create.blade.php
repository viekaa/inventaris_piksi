@extends('layouts.backend')
@section('content')

<h3>Pengembalian</h3>

<form method="POST" action="{{ route('pengembalian.store') }}">
@csrf

<input type="hidden" name="peminjaman_id" value="{{ $peminjaman->id }}">

<p>Barang: <b>{{ $peminjaman->barang->nama_barang }}</b></p>
<p>Jumlah: {{ $peminjaman->jumlah }}</p>

<input type="date" name="tgl_kembali" class="form-control mb-2">

<select name="kondisi_saat_kembali" class="form-control mb-2">
<option value="baik">Baik</option>
<option value="rusak">Rusak</option>
<option value="perlu_perbaikan">Perlu Perbaikan</option>
</select>

<button class="btn btn-success">Simpan Pengembalian</button>
</form>
@endsection
