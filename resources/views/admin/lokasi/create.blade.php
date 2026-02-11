@extends('layouts.backend')
@section('title','Tambah Lokasi')

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
                            <h4 class="form-title">Tambah Lokasi Baru</h4>
                            <p class="form-subtitle">Isi form di bawah untuk menambahkan lokasi</p>
                        </div>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('admin.lokasi.store') }}" method="POST">
                        @csrf

                        <div class="form-content">

                            <!-- Nama Lokasi -->
                            <div class="form-group-custom">
                                <label class="form-label-custom">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Nama Lokasi
                                    <span class="required">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="nama_lokasi"
                                    class="form-control-custom @error('nama_lokasi') is-invalid @enderror"
                                    placeholder="Contoh: Gudang Peminjaman, Ruang Server, dll"
                                    value="{{ old('nama_lokasi') }}"
                                    required
                                >
                                @error('nama_lokasi')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="form-hint">Masukkan nama lokasi dengan jelas dan spesifik</small>
                            </div>

                        </div>

                        <!-- Action Buttons -->
                        <div class="form-actions">
                            <a href="{{ route('admin.lokasi.index') }}" class="btn-cancel">
                                <i class="fas fa-times"></i>
                                <span>Batal</span>
                            </a>
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-save"></i>
                                <span>Simpan Lokasi</span>
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

/* ===== FORM CONTENT ===== */
.form-content {
    padding-top: 8px;
}

.form-group-custom {
    margin-bottom: 28px;
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

.form-hint {
    display: block;
    margin-top: 8px;
    font-size: 13px;
    color: var(--color-gray-500);
    font-weight: 400;
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

/* Cancel Button */
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

/* Submit Button */
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
}
</style>

@endsection
