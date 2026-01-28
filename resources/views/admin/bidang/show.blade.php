@extends('layouts.backend')

@section('content')
<div class="container">
    <h3>Bidang: {{ $bidang->nama_bidang }}</h3>

    <hr>
    <h5>Tambah Petugas</h5>
    <form action="{{ route('admin.bidang.petugas.store',$bidang->id) }}" method="POST">
        @csrf
        <div class="row">
            <div class="col">
                <input name="name" class="form-control" placeholder="Nama">
            </div>
            <div class="col">
                <input name="email" class="form-control" placeholder="Email">
            </div>
            <div class="col">
                <input name="password" class="form-control" placeholder="Password">
            </div>
            <div class="col">
                <button class="btn btn-primary">Tambah</button>
            </div>
        </div>
    </form>

    <hr>
    <h5>Daftar Petugas</h5>
    <table class="table table-bordered">
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>
        @foreach($bidang->users as $u)
        <tr>
            <td>{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td>
                <form action="{{ route('admin.bidang.petugas.destroy',$u->id) }}" method="POST">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm"
                        onclick="return confirm('Hapus petugas?')">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    <a href="{{ route('admin.bidang.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
