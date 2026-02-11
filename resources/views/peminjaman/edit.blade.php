@extends('layouts.backend')
@section('title','Edit Peminjaman')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 mx-auto">

            <!-- Form Card -->
            <div class="card custom-card">
                <div class="card-body p-4">

                    <!-- Header -->
                    <div class="form-header">
                        <div>
                            <h4 class="form-title">Edit Data Peminjaman</h4>
                            <p class="form-subtitle">Perbarui informasi peminjaman di bawah ini</p>
                        </div>
                        <div class="header-info">
                            <span class="info-badge">
                                <i class="fas fa-box"></i>
                                {{ $peminjaman->barang->nama_barang }}
                            </span>
                        </div>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('petugas.peminjaman.update', $peminjaman->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-content">

                            <!-- Data Peminjam Section -->
                            <div class="form-section">
                                <h5 class="section-title">
                                    <i class="fas fa-user"></i>
                                    Data Peminjam
                                </h5>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-group-custom">
                                            <label class="form-label-custom">
                                                <i class="fas fa-user-circle"></i>
                                                Nama Peminjam
                                                <span class="required">*</span>
                                            </label>
                                            <input
                                                type="text"
                                                name="nama_peminjam"
                                                class="form-control-custom @error('nama_peminjam') is-invalid @enderror"
                                                placeholder="Nama lengkap peminjam"
                                                value="{{ old('nama_peminjam', $peminjaman->nama_peminjam) }}"
                                                required
                                            >
                                            @error('nama_peminjam')
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group-custom">
                                            <label class="form-label-custom">
                                                <i class="fas fa-id-card"></i>
                                                NPM
                                                <span class="required">*</span>
                                            </label>
                                            <input
                                                type="text"
                                                name="npm"
                                                class="form-control-custom @error('npm') is-invalid @enderror"
                                                placeholder="Nomor Pokok Mahasiswa"
                                                value="{{ old('npm', $peminjaman->npm) }}"
                                                required
                                            >
                                            @error('npm')
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group-custom">
                                            <label class="form-label-custom">
                                                <i class="fas fa-graduation-cap"></i>
                                                Jurusan
                                                <span class="required">*</span>
                                            </label>
                                            <select
                                                name="jurusan_id"
                                                class="form-control-custom @error('jurusan_id') is-invalid @enderror"
                                                required
                                            >
                                                <option value="">Pilih Jurusan</option>
                                                @foreach($jurusans as $fakultasNama => $jurusanList)
                                                    <optgroup label="{{ $fakultasNama }}">
                                                        @foreach($jurusanList as $jurusan)
                                                            <option
                                                                value="{{ $jurusan->id }}"
                                                                {{ old('jurusan_id', $peminjaman->jurusan_id) == $jurusan->id ? 'selected' : '' }}
                                                            >
                                                                {{ $jurusan->nama_jurusan }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                @endforeach
                                            </select>
                                            @error('jurusan_id')
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group-custom">
                                            <label class="form-label-custom">
                                                <i class="fas fa-calendar-alt"></i>
                                                Angkatan
                                                <span class="required">*</span>
                                            </label>
                                            <input
                                                type="text"
                                                name="angkatan"
                                                class="form-control-custom @error('angkatan') is-invalid @enderror"
                                                placeholder="Contoh: 2020"
                                                value="{{ old('angkatan', $peminjaman->angkatan) }}"
                                                maxlength="4"
                                                required
                                            >
                                            @error('angkatan')
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Detail Peminjaman Section -->
                            <div class="form-section">
                                <h5 class="section-title">
                                    <i class="fas fa-clipboard-list"></i>
                                    Detail Peminjaman
                                </h5>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-group-custom">
                                            <label class="form-label-custom">
                                                <i class="fas fa-calendar-check"></i>
                                                Tanggal Pinjam
                                                <span class="required">*</span>
                                            </label>
                                            <input
                                                type="date"
                                                name="tgl_pinjam"
                                                class="form-control-custom @error('tgl_pinjam') is-invalid @enderror"
                                                value="{{ old('tgl_pinjam', $peminjaman->tgl_pinjam) }}"
                                                required
                                            >
                                            @error('tgl_pinjam')
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group-custom">
                                            <label class="form-label-custom">
                                                <i class="fas fa-calendar-times"></i>
                                                Tanggal Rencana Kembali
                                                <span class="required">*</span>
                                            </label>
                                            <input
                                                type="date"
                                                name="tgl_kembali_rencana"
                                                class="form-control-custom @error('tgl_kembali_rencana') is-invalid @enderror"
                                                value="{{ old('tgl_kembali_rencana', $peminjaman->tgl_kembali_rencana) }}"
                                                required
                                            >
                                            @error('tgl_kembali_rencana')
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group-custom">
                                            <label class="form-label-custom">
                                                <i class="fas fa-clipboard-check"></i>
                                                Kondisi Saat Pinjam
                                                <span class="required">*</span>
                                            </label>
                                            <select
                                                name="kondisi_saat_pinjam"
                                                class="form-control-custom @error('kondisi_saat_pinjam') is-invalid @enderror"
                                                required
                                            >
                                                <option value="">Pilih Kondisi</option>
                                                <option value="baik" {{ old('kondisi_saat_pinjam', $peminjaman->kondisi_saat_pinjam) == 'baik' ? 'selected' : '' }}>Baik</option>
                                                <option value="rusak" {{ old('kondisi_saat_pinjam', $peminjaman->kondisi_saat_pinjam) == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                                <option value="perlu_perbaikan" {{ old('kondisi_saat_pinjam', $peminjaman->kondisi_saat_pinjam) == 'perlu_perbaikan' ? 'selected' : '' }}>Perlu Perbaikan</option>
                                            </select>
                                            @error('kondisi_saat_pinjam')
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Info Alert -->
                            <div class="alert-info-box">
                                <i class="fas fa-info-circle"></i>
                                <div>
                                    <strong>Perhatian:</strong> Jumlah barang yang dipinjam tidak dapat diubah. Jika perlu mengubah jumlah, silakan hapus peminjaman ini dan buat yang baru.
                                </div>
                            </div>

                        </div>

                        <!-- Action Buttons -->
                        <div class="form-actions">
                            <a href="{{ route('petugas.peminjaman.index') }}" class="btn-cancel">
                                <i class="fas fa-times"></i>
                                <span>Batal</span>
                            </a>
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-save"></i>
                                <span>Update Peminjaman</span>
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<style>
/* ===== VARIABLES ===== */
:root {
    --font-primary: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    --color-primary: #667eea;
    --color-primary-dark: #5568d3;
    --color-success: #10b981;
    --color-danger: #ef4444;
    --color-info: #3b82f6;
    --color-gray-50: #fafafa;
    --color-gray-100: #f3f4f6;
    --color-gray-200: #e5e7eb;
    --color-gray-300: #d1d5db;
    --color-gray-400: #9ca3af;
    --color-gray-500: #6b7280;
    --color-gray-600: #4b5563;
    --color-gray-700: #374151;
    --color-gray-800: #1f2937;
    --color-gray-900: #111827;
}

body {
    font-family: var(--font-primary);
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* ===== CARD ===== */
.custom-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04), 0 1px 2px rgba(0, 0, 0, 0.06);
    transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    animation: slideUp 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

/* ===== FORM HEADER ===== */
.form-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 24px;
    border-bottom: 2px solid var(--color-gray-100);
    margin-bottom: 32px;
}

.form-title {
    font-size: 24px;
    font-weight: 700;
    letter-spacing: -0.5px;
    color: var(--color-gray-900);
    margin: 0 0 6px 0;
}

.form-subtitle {
    font-size: 14px;
    color: var(--color-gray-500);
    margin: 0;
    font-weight: 400;
}

.header-info {
    display: flex;
    align-items: center;
}

.info-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    background: linear-gradient(135deg, var(--color-primary) 0%, #764ba2 100%);
    color: #fff;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
}

/* ===== FORM CONTENT ===== */
.form-content {
    padding-top: 8px;
}

.form-section {
    margin-bottom: 36px;
}

.form-section:last-of-type {
    margin-bottom: 24px;
}

.section-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 16px;
    font-weight: 700;
    color: var(--color-gray-800);
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 2px solid var(--color-gray-100);
}

.section-title i {
    color: var(--color-primary);
    font-size: 18px;
}

.form-group-custom {
    margin-bottom: 0;
}

.form-label-custom {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 600;
    color: var(--color-gray-700);
    margin-bottom: 10px;
}

.form-label-custom i {
    color: var(--color-primary);
    font-size: 15px;
}

.required {
    color: var(--color-danger);
    font-weight: 700;
}

.form-control-custom {
    width: 100%;
    padding: 14px 18px;
    font-size: 15px;
    font-weight: 500;
    color: var(--color-gray-900);
    background: var(--color-gray-50);
    border: 1.5px solid var(--color-gray-200);
    border-radius: 10px;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    font-family: var(--font-primary);
}

.form-control-custom::placeholder {
    color: var(--color-gray-400);
    font-weight: 400;
}

.form-control-custom:focus {
    outline: none;
    background: #fff;
    border-color: var(--color-primary);
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-control-custom.is-invalid {
    border-color: var(--color-danger);
    background: #fef2f2;
}

.form-control-custom.is-invalid:focus {
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

select.form-control-custom {
    cursor: pointer;
}

.error-message {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 8px;
    padding: 10px 14px;
    background: #fef2f2;
    border-left: 3px solid var(--color-danger);
    border-radius: 8px;
    font-size: 13px;
    color: var(--color-danger);
    font-weight: 500;
}

.error-message i {
    font-size: 14px;
}

/* ===== ALERT BOX ===== */
.alert-info-box {
    display: flex;
    gap: 12px;
    padding: 16px 18px;
    background: #eff6ff;
    border-left: 4px solid var(--color-info);
    border-radius: 10px;
    margin-top: 24px;
}

.alert-info-box i {
    color: var(--color-info);
    font-size: 20px;
    flex-shrink: 0;
    margin-top: 2px;
}

.alert-info-box strong {
    color: var(--color-gray-900);
    font-weight: 600;
}

.alert-info-box div {
    font-size: 14px;
    color: var(--color-gray-700);
    line-height: 1.5;
}

/* ===== FORM ACTIONS ===== */
.form-actions {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    align-items: center;
    margin-top: 40px;
    padding-top: 24px;
    border-top: 2px solid var(--color-gray-100);
}

.btn-cancel {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: #fff;
    color: var(--color-gray-700);
    border: 1.5px solid var(--color-gray-300);
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

.btn-cancel:hover {
    background: var(--color-gray-50);
    color: var(--color-gray-900);
    border-color: var(--color-gray-400);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    text-decoration: none;
}

.btn-cancel i {
    font-size: 13px;
}

.btn-submit {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 32px;
    background: linear-gradient(135deg, var(--color-primary) 0%, #764ba2 100%);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    cursor: pointer;
}

.btn-submit:hover {
    background: linear-gradient(135deg, var(--color-primary-dark) 0%, #6b3fa0 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
}

.btn-submit:active {
    transform: translateY(0);
}

.btn-submit i {
    font-size: 14px;
}

/* ===== ANIMATIONS ===== */
@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .form-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }

    .form-title {
        font-size: 20px;
    }

    .form-subtitle {
        font-size: 13px;
    }

    .form-actions {
        flex-direction: column-reverse;
        gap: 12px;
    }

    .btn-cancel,
    .btn-submit {
        width: 100%;
        justify-content: center;
    }

    .alert-info-box {
        flex-direction: column;
    }
}
</style>

@endsection
