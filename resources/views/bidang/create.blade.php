@extends('layouts.backend')

@section('content')
<div class="container">
    <h3>Tambah Bidang</h3>

    <form action="{{ route('bidang.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Bidang</label>
            <input type="text" name="nama_bidang" class="form-control">
        </div>
        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('bidang.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
