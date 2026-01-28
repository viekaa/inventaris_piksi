@extends('layouts.backend')
@section('content')

<h3>Data Pengembalian</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Barang</th>
            <th>Peminjam</th>
            <th>Jumlah Kembali</th>
            <th>Tanggal Kembali</th>
            <th>Kondisi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pengembalian as $p)
        <tr>
            <td>{{ $p->peminjaman->barang->nama_barang }}</td>
            <td>{{ $p->peminjaman->nama_peminjam }}</td>
            <td>{{ $p->jumlah_kembali }}</td>
            <td>{{ $p->tgl_kembali }}</td>
            <td>{{ $p->kondisi_saat_kembali }}</td>
            <td>
                <a href="{{ route('pengembalian.show', $p->id) }}" class="btn btn-info btn-sm">Lihat</a>
                <a href="{{ route('pengembalian.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('pengembalian.destroy', $p->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau hapus?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
