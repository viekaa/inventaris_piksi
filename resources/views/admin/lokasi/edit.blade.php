@extends('layouts.backend')
@section('content')

<h3>Edit Lokasi</h3>

<form method="POST" action="{{ route('admin.lokasi.update', $lokasi->id) }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Nama Lokasi</label>
        <input type="text" name="nama_lokasi" class="form-control" value="{{ old('nama_lokasi', $lokasi->nama_lokasi) }}">
        @error('nama_lokasi')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <button class="btn btn-primary">Update</button>
    <a href="{{ route('admin.lokasi.index') }}" class="btn btn-secondary">Batal</a>
</form>

@endsection
