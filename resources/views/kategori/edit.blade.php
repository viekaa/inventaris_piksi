@extends('layouts.backend')
@section('content')

<h3>Edit Kategori</h3>

<form method="POST" action="{{ route('kategori.update', $kategori->id) }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Nama Kategori</label>
        <input type="text" name="nama_kategori" class="form-control" value="{{ old('nama_kategori', $kategori->nama_kategori) }}">
        @error('nama_kategori')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <button class="btn btn-primary">Update</button>
    <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Batal</a>
</form>

@endsection
