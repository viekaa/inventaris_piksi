@extends('layouts.backend')
@section('content')

<h3>Tambah Kategori</h3>

<form method="POST" action="{{ route('admin.kategori.store') }}">
    @csrf
    <div class="mb-3">
        <label>Nama Kategori</label>
        <input type="text" name="nama_kategori" class="form-control" value="{{ old('nama_kategori') }}">
        @error('nama_kategori')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">Batal</a>
</form>

@endsection
