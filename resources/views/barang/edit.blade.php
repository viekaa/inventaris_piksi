@extends('layouts.backend')
@section('title','Edit Barang')

@section('content')
<h3>Edit Barang</h3>
<form action="{{ route('barang.update',$barang->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nama Barang</label>
        <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang',$barang->nama_barang) }}">
    </div>

    <div class="mb-3">
        <label>Kategori</label>
        <select name="kategori_id" class="form-control">
            @foreach($kategori as $k)
            <option value="{{ $k->id }}" {{ $barang->kategori_id==$k->id?'selected':'' }}>
                {{ $k->nama_kategori }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Lokasi</label>
        <select name="lokasi_id" class="form-control">
            @foreach($lokasi as $l)
            <option value="{{ $l->id }}" {{ $barang->lokasi_id==$l->id?'selected':'' }}>
                {{ $l->nama_lokasi }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Jumlah Total</label>
        <input type="number" name="jumlah_total" class="form-control" value="{{ $barang->jumlah_total }}">
    </div>

    <div class="mb-3">
        <label>Stok</label>
        <input type="number" name="stok" class="form-control" value="{{ $barang->stok }}">
    </div>

    <div class="mb-3">
        <label>Kondisi</label>
        <select name="kondisi" class="form-control">
            <option value="baik" {{ $barang->kondisi=='baik'?'selected':'' }}>Baik</option>
            <option value="rusak" {{ $barang->kondisi=='rusak'?'selected':'' }}>Rusak</option>
            <option value="perlu_perbaikan" {{ $barang->kondisi=='perlu_perbaikan'?'selected':'' }}>Perlu Perbaikan</option>
        </select>
    </div>

    <button class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
    <a href="{{ route('barang.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Kembali</a>
</form>
@endsection
