@extends('layouts.backend')

@section('title','Edit Peminjaman')

@section('content')
<div class="container-fluid">

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-edit text-warning me-2"></i>
                Edit Peminjaman
            </h5>

            <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">

            <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4">

                    {{-- ================== NAMA ================== --}}
                    <div class="col-md-6">
                        <label class="form-label">Nama Peminjam</label>
                        <input type="text" name="nama_peminjam" class="form-control"
                               value="{{ old('nama_peminjam', $peminjaman->nama_peminjam) }}" required>
                    </div>

                    {{-- ================== NPM ================== --}}
                    <div class="col-md-6">
                        <label class="form-label">NPM</label>
                        <input type="text" name="npm" class="form-control"
                               value="{{ old('npm', $peminjaman->npm) }}" required>
                    </div>

                    {{-- ================== JURUSAN ================== --}}
                    <div class="col-md-6">
                        <label class="form-label">Jurusan</label>
                        <select name="jurusan_id" class="form-control" required>
                            <option value="">Pilih jurusan...</option>

                            @foreach($jurusans as $namaFakultas => $listJurusan)
                                <optgroup label="{{ $namaFakultas }}">
                                    @foreach($listJurusan as $j)
                                        <option value="{{ $j->id }}"
                                            {{ old('jurusan_id', $peminjaman->jurusan_id) == $j->id ? 'selected' : '' }}>
                                            {{ $j->nama_jurusan }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>

                    {{-- ================== ANGKATAN ================== --}}
                    <div class="col-md-6">
                        <label class="form-label">Angkatan</label>
                        <input type="text" name="angkatan" class="form-control"
                               value="{{ old('angkatan', $peminjaman->angkatan) }}" required>
                    </div>

                    {{-- ================== TANGGAL PINJAM ================== --}}
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Pinjam</label>
                        <input type="date" name="tgl_pinjam" class="form-control"
                               value="{{ old('tgl_pinjam', $peminjaman->tgl_pinjam) }}" required>
                    </div>

                    {{-- ================== RENCANA KEMBALI ================== --}}
                    <div class="col-md-6">
                        <label class="form-label">Rencana Kembali</label>
                        <input type="date" name="tgl_kembali_rencana" class="form-control"
                               value="{{ old('tgl_kembali_rencana', $peminjaman->tgl_kembali_rencana) }}" required>
                    </div>

                    {{-- ================== KONDISI ================== --}}
                    <div class="col-md-12">
                        <label class="form-label">Kondisi Barang Saat Dipinjam</label>
                        <textarea name="kondisi_saat_pinjam" rows="3" class="form-control" required>{{ old('kondisi_saat_pinjam', $peminjaman->kondisi_saat_pinjam) }}</textarea>
                    </div>

                </div>

                <div class="mt-4 text-end">
                    <button class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Peminjaman
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
