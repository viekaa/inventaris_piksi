@extends('layouts.backend')

@section('content')
<div class="container">
    <h3>Edit Bidang</h3>

    <form action="{{ route('bidang.update',$bidang->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Nama Bidang</label>
            <input type="text" name="nama_bidang"
                   value="{{ $bidang->nama_bidang }}"
                   class="form-control">
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('bidang.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
