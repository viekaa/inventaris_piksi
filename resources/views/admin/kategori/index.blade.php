@extends('layouts.backend')

@section('content')

   <div class="container-fluid">
  <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Data Kategori</h4>
                                  <a href="{{ route('admin.kategori.create') }}"  class="btn waves-effect waves-light btn-rounded btn-outline-primary">
                                    <i class="fas fa-plus"></i> Tambah
                                  </a>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Kategori</th>
                                                <th>Aksi</th>
                                            </tr>
                                             @php $no =1; @endphp

                                            @foreach ($kategoris as $kategori )
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $kategori->nama_kategori}}</td>
                                                <td>
                                                <form action="{{ route('admin.kategori.destroy', $kategori->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('admin.kategori.edit',$kategori->id) }}"  class="btn btn-secondary btn-circle btn-sm"><i class=" fas fa-pencil-alt"></i></a>
                                                <a href="{{ route('admin.kategori.show',$kategori->id) }}"  class="btn btn-success btn-circle btn-sm"><i class=" fas fa-eye"></i></a>
                                                <button type="submit"  class="btn btn-danger btn-circle btn-sm" onclick="return confirm('apakah anda yakin ?')"><i class=" fas fa-trash></i></button>
                                                </form>
                                                </td>
                                                </tr>
                                                @endforeach
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
@endsection
