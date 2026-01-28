@extends('layouts.backend')
@section('content')

<h3>Edit Peminjaman</h3>

<form method="POST" action="{{ route('peminjaman.update',$peminjaman->id) }}">
@csrf
@method('PUT')

<input name="nama_peminjam" value="{{ $peminjaman->nama_peminjam }}" class="form-control mb-2">
<input name="jumlah" type="number" value="{{ $peminjaman->jumlah }}" class="form-control mb-2">
<input type="date" name="tgl_pinjam" value="{{ $peminjaman->tgl_pinjam }}" class="form-control mb-2">
<input type="date" name="tgl_kembali_rencana" value="{{ $peminjaman->tgl_kembali_rencana }}" class="form-control mb-2">

<select name="kondisi_saat_pinjam" class="form-control mb-2">
<option {{ $peminjaman->kondisi_saat_pinjam=='baik'?'selected':'' }}>baik</option>
<option {{ $peminjaman->kondisi_saat_pinjam=='rusak'?'selected':'' }}>rusak</option>
<option {{ $peminjaman->kondisi_saat_pinjam=='perlu_perbaikan'?'selected':'' }}>perlu_perbaikan</option>
</select>

<button class="btn btn-primary">Update</button>
</form>
@endsection
