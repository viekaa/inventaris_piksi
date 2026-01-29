@extends('layouts.backend')

@section('content')

   <div class="container-fluid">
  <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                             <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="card-title mb-0">Data Kategori</h4>

                                <div class="position-relative w-25">
                                    <i class="fas fa-search position-absolute text-muted"
                                    style="top:50%; left:18px; transform:translateY(-50%);"></i>

                                    <input type="text"
                                        id="searchKategori"
                                        class="form-control rounded-pill"
                                        style="padding-left:45px;"
                                        placeholder="Cari kategori...">
                                </div>
                            </div>
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
                                                  <!-- Edit -->
                                                <a href="{{ route('admin.kategori.edit', $kategori->id) }}"
                                                class="btn btn-secondary btn-circle">
                                                    <i class="far fa-edit"></i>
                                                </a>

                                                <!-- Hapus -->
                                                <form action="{{ route('admin.kategori.destroy', $kategori->id) }}"
                                                    method="POST"
                                                    style="display:inline-block;"
                                                    onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-circle">
                                                        <i class=" far fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                                   <a href="{{ route('admin.kategori.create') }}"
                                                class="btn btn-info btn-circle">
                                                    <i class="fas fa-plus"></i>
                                                </a>
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
                                <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const input = document.getElementById('searchKategori');

                    input.addEventListener('keyup', function () {
                        let keyword = this.value.toLowerCase();
                        let rows = document.querySelectorAll('table tbody tr');

                        rows.forEach(row => {
                            let text = row.innerText.toLowerCase();
                            row.style.display = text.includes(keyword) ? '' : 'none';
                        });
                    });
                });
                </script>

@endsection
