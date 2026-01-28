@extends('layouts.backend')
@section('content')

<h3>Peminjaman</h3>

<form method="POST" action="{{ route('peminjaman.store') }}">
@csrf

<select name="barang_id" class="form-control mb-2">
@foreach($barang as $b)
<option value="{{ $b->id }}">{{ $b->nama_barang }} (stok:{{ $b->stok }})</option>
@endforeach
</select>

<input name="nama_peminjam" class="form-control mb-2" placeholder="Nama Peminjam">
<input name="jumlah" type="number" class="form-control mb-2">
<input type="date" name="tgl_pinjam" class="form-control mb-2">
<input type="date" name="tgl_kembali_rencana" class="form-control mb-2">

<select name="kondisi_saat_pinjam" class="form-control mb-2">
<option value="baik">Baik</option>
<option value="rusak">Rusak</option>
<option value="perlu_perbaikan">Perlu Perbaikan</option>
</select>

<button class="btn btn-primary">Simpan</button>
</form>
@endsection
