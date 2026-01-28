@extends('layouts.backend')

@section('content')
<div class="container">
    <h3>Data Bidang</h3>

    <a href="{{ route('bidang.create') }}" class="btn btn-primary mb-3">
        + Tambah Bidang
    </a>

    <table class="table table-bordered">
        <tr>
            <th>Nama Bidang</th>
            <th>Jumlah Petugas</th>
            <th>Aksi</th>
        </tr>
        @foreach($bidangs as $b)
        <tr>
            <td>{{ $b->nama_bidang }}</td>
            <td>{{ $b->users_count }}</td>
            <td>
                <a href="{{ route('bidang.show',$b->id) }}" class="btn btn-info btn-sm">Detail</a>
                <a href="{{ route('bidang.edit',$b->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('bidang.destroy',$b->id) }}" method="POST" style="display:inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm"
                        onclick="return confirm('Hapus bidang?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
