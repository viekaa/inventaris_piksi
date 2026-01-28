@extends('layouts.backend')
@section('title','Dashboard')

<div class="row">
<div class="col-md-3">
<div class="card shadow text-center p-3">
<i class="fa fa-box fa-2x text-primary"></i>
<h3>{{ $barang }}</h3>
<p>Barang</p>
</div>
</div>

<div class="col-md-3">
<div class="card shadow text-center p-3">
<i class="fa fa-handshake fa-2x text-success"></i>
<h3>{{ $peminjaman }}</h3>
<p>Peminjaman</p>
</div>
</div>

<div class="col-md-3">
<div class="card shadow text-center p-3">
<i class="fa fa-undo fa-2x text-warning"></i>
<h3>{{ $pengembalian }}</h3>
<p>Pengembalian</p>
</div>
</div>

<div class="col-md-3">
<div class="card shadow text-center p-3">
<i class="fa fa-exclamation-triangle fa-2x text-danger"></i>
<h3>{{ $stokHabis }}</h3>
<p>Stok Hampir Habis</p>
</div>
</div>
</div>
@endsection
