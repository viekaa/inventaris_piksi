@extends('layouts.backend')
@section('content')

<h3>Pengembalian</h3>

<form method="POST" action="{{ route('pengembalian.store') }}">
@csrf

<div class="form-group">
    <label>Pilih Peminjaman</label>
    <select name="peminjaman_id" class="form-control" required>
        <option value="">-- Pilih --</option>
        @foreach($peminjaman as $p)
            <option value="{{ $p->id }}">
                {{ $p->barang->nama }} |
                {{ $p->nama_peminjam }} |
                {{ $p->tgl_pinjam }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label>Tanggal Kembali</label>
    <input type="date" name="tgl_kembali" class="form-control" required>
</div>

<div class="form-group">
    <label>Kondisi Saat Kembali</label>
    <textarea name="kondisi_saat_kembali" class="form-control" required></textarea>
</div>

<button type="submit" class="btn btn-primary">
    Simpan Pengembalian
</button>

</form>

@endsection
