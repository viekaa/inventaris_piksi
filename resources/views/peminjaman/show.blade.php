@extends('layouts.backend')

@section('title','Detail Peminjaman')

@section('content')
<div class="container-fluid">

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-clipboard-list text-primary me-2"></i>
                Detail Peminjaman
            </h5>

            <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">

            <div class="row g-4">

                {{-- ================== DATA PEMINJAM ================== --}}
                <div class="col-md-6">
                    <div class="border rounded p-3 h-100">
                        <h6 class="fw-bold text-primary mb-3">
                            <i class="fas fa-user me-1"></i> Data Peminjam
                        </h6>

                        <table class="table table-borderless mb-0">
                            <tr>
                                <td width="40%">Nama</td>
                                <td>: {{ $peminjaman->nama_peminjam }}</td>
                            </tr>
                            <tr>
                                <td>NPM</td>
                                <td>: {{ $peminjaman->npm }}</td>
                            </tr>
                            <tr>
                                <td>Fakultas</td>
                                <td>: {{ $peminjaman->jurusan->fakultas->nama_fakultas }}</td>
                            </tr>
                            <tr>
                                <td>Jurusan</td>
                                <td>: {{ $peminjaman->jurusan->nama_jurusan }}</td>
                            </tr>
                            <tr>
                                <td>Angkatan</td>
                                <td>: {{ $peminjaman->angkatan }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- ================== DATA BARANG ================== --}}
                <div class="col-md-6">
                    <div class="border rounded p-3 h-100">
                        <h6 class="fw-bold text-success mb-3">
                            <i class="fas fa-box me-1"></i> Data Barang
                        </h6>

                        <table class="table table-borderless mb-0">
                            <tr>
                                <td width="40%">Nama Barang</td>
                                <td>: {{ $peminjaman->barang->nama_barang }}</td>
                            </tr>
                            <tr>
                                <td>Kategori</td>
                                <td>: {{ $peminjaman->barang->kategori->nama_kategori ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Bidang</td>
                                <td>: {{ $peminjaman->barang->bidang->nama_bidang ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Jumlah Dipinjam</td>
                                <td>: <span class="badge bg-primary">{{ $peminjaman->jumlah }}</span></td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- ================== DATA PEMINJAMAN ================== --}}
                <div class="col-md-6">
                    <div class="border rounded p-3 h-100">
                        <h6 class="fw-bold text-warning mb-3">
                            <i class="fas fa-calendar-alt me-1"></i> Waktu Peminjaman
                        </h6>

                        <table class="table table-borderless mb-0">
                            <tr>
                                <td width="40%">Tanggal Pinjam</td>
                                <td>: {{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <td>Rencana Kembali</td>
                                <td>: {{ \Carbon\Carbon::parse($peminjaman->tgl_kembali_rencana)->format('d M Y') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- ================== KONDISI ================== --}}
                <div class="col-md-6">
                    <div class="border rounded p-3 h-100">
                        <h6 class="fw-bold text-danger mb-3">
                            <i class="fas fa-clipboard-check me-1"></i> Kondisi Barang
                        </h6>

                        <table class="table table-borderless mb-0">
                            <tr>
                                <td width="40%">Saat Dipinjam</td>
                                <td>: {{ $peminjaman->kondisi_saat_pinjam }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>
@endsection
