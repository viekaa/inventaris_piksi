@extends('layouts.backend')
@section('title','Tambah Barang')

@section('content')
<h3>Tambah Barang</h3>
<form action="{{ route('barang.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Nama Barang</label>
        <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang') }}">
    </div>
    <div class="mb-3">
        <label>Kategori</label>
        <select name="kategori_id" class="form-control">
            @foreach($kategori as $k)
            <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Lokasi</label>
        <select name="lokasi_id" class="form-control">
            @foreach($lokasi as $l)
            <option value="{{ $l->id }}">{{ $l->nama_lokasi }}</option>
            @endforeach
        </select>
    </div>
    @if(auth()->user()->role == 'admin')
    <div class="mb-3">
        <label>Bidang</label>
        <select name="bidang_id" class="form-control">
            @foreach($bidang as $b)
            <option value="{{ $b->id }}">{{ $b->nama_bidang }}</option>
            @endforeach
        </select>
    </div>
    @endif
    <div class="mb-3">
        <label>Jumlah Total</label>
        <input type="number" name="jumlah_total" class="form-control">
    </div>
    <div class="mb-3">
        <label>Stok</label>
        <input type="number" name="stok" class="form-control">
    </div>
    <div class="mb-3">
        <label>Kondisi</label>
        <select name="kondisi" class="form-control">
            <option value="baik">Baik</option>
            <option value="rusak">Rusak</option>
            <option value="perlu_perbaikan">Perlu Perbaikan</option>
        </select>
    </div>
    <button class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
</form>
@endsection
