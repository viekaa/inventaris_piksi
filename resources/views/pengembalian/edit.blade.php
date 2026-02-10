@extends('layouts.backend')
@section('content')

<h3>Edit Pengembalian</h3>

<form method="POST" action="{{ route('petugas.pengembalian.update',$pengembalian->id) }}">
@csrf
@method('PUT')

<input type="date" name="tgl_kembali" value="{{ $pengembalian->tgl_kembali }}" class="form-control mb-2">

<select name="kondisi_saat_kembali" class="form-control mb-2">
<option {{ $pengembalian->kondisi_saat_kembali=='baik'?'selected':'' }}>baik</option>
<option {{ $pengembalian->kondisi_saat_kembali=='rusak'?'selected':'' }}>rusak</option>
<option {{ $pengembalian->kondisi_saat_kembali=='perlu_perbaikan'?'selected':'' }}>perlu_perbaikan</option>
</select>

<button class="btn btn-primary">Update</button>
</form>
@endsection
