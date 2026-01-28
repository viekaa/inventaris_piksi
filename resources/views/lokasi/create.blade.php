@extends('layouts.backend')
@section('content')

<h3>Tambah Lokasi</h3>

<form method="POST" action="{{ route('lokasi.store') }}">
    @csrf
    <div class="mb-3">
        <label>Nama Lokasi</label>
        <input type="text" name="nama_lokasi" class="form-control" value="{{ old('nama_lokasi') }}">
        @error('nama_lokasi')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('lokasi.index') }}" class="btn btn-secondary">Batal</a>
</form>

@endsection
