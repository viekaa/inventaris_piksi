@extends('layouts.backend')
@section('title','Tambah Pengembalian')

@section('content')

<style>
.custom-card {
    border-radius: 16px;
    border: none;
    box-shadow: 0 10px 25px rgba(0,0,0,.06);
}

.form-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.form-title {
    font-size: 22px;
    font-weight: 700;
    color: #1f2937;
}

.form-subtitle {
    font-size: 14px;
    color: #6b7280;
    margin-top: 4px;
}

.form-group-custom {
    margin-bottom: 22px;
}

.form-label {
    font-weight: 600;
    font-size: 14px;
    color: #374151;
    margin-bottom: 6px;
    display: block;
}

.required {
    color: #ef4444;
}

.input-wrapper {
    position: relative;
}

.input-icon {
    position: absolute;
    top: 50%;
    left: 14px;
    transform: translateY(-50%);
    color: #9ca3af;
}

.form-control-custom {
    width: 100%;
    padding: 12px 14px 12px 42px;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    font-size: 14px;
    outline: none;
    transition: 0.3s;
}

.form-control-custom:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59,130,246,.15);
}

.form-control-custom.is-invalid {
    border-color: #ef4444;
}

.error-message {
    color: #ef4444;
    font-size: 13px;
    margin-top: 4px;
}

.form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 30px;
}

.btn-back {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #374151;
    text-decoration: none;
    font-weight: 600;
}

.btn-back:hover {
    color: #3b82f6;
}

.form-actions-right {
    display: flex;
    gap: 12px;
}

.btn-reset {
    background: #f3f4f6;
    border: none;
    padding: 10px 18px;
    border-radius: 10px;
    font-weight: 600;
    color: #374151;
}

.btn-submit {
    background: #3b82f6;
    border: none;
    padding: 10px 22px;
    border-radius: 10px;
    font-weight: 600;
    color: #fff;
}

.btn-submit:hover {
    background: #2563eb;
}
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">

            <div class="card custom-card">
                <div class="card-body p-4">

                    <div class="form-header">
                        <div>
                            <h4 class="form-title">Tambah Pengembalian</h4>
                            <p class="form-subtitle">Lengkapi data pengembalian barang</p>
                        </div>
                    </div>

                    <form action="{{ route('petugas.pengembalian.store') }}" method="POST">
                        @csrf

                        <div class="row">

                            {{-- PEMINJAMAN --}}
                            <div class="col-md-12">
                                <div class="form-group-custom">
                                    <label class="form-label">Peminjaman <span class="required">*</span></label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-box input-icon"></i>
                                        <select name="peminjaman_id" class="form-control-custom" required>
                                            <option value="" disabled selected>Pilih peminjaman...</option>
                                            @foreach($peminjaman as $p)
                                                <option value="{{ $p->id }}">
                                                    {{ $p->nama_peminjam }} - {{ $p->barang->nama_barang }} ({{ $p->jumlah }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- TANGGAL KEMBALI --}}
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label class="form-label">Tanggal Kembali <span class="required">*</span></label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-calendar-alt input-icon"></i>
                                        <input type="date" name="tgl_kembali" class="form-control-custom" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                </div>
                            </div>

                            {{-- KONDISI --}}
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label class="form-label">Kondisi Saat Kembali <span class="required">*</span></label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-check-circle input-icon"></i>
                                        <select name="kondisi_saat_kembali" class="form-control-custom" required>
                                            <option value="" disabled selected>Pilih kondisi</option>
                                            <option value="baik">Baik</option>
                                            <option value="perlu_perbaikan">Perlu Perbaikan</option>
                                            <option value="rusak">Rusak</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="form-actions">
                            <a href="{{ route('petugas.pengembalian.index') }}" class="btn-back">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>

                            <div class="form-actions-right">
                                <button type="reset" class="btn-reset">Reset</button>
                                <button type="submit" class="btn-submit">Simpan</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
