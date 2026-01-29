@extends('layouts.backend')
@section('title','Edit Barang')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">

            <!-- Form Card -->
            <div class="card custom-card">
                <div class="card-body p-4">

                    <!-- Header -->
                    <div class="form-header">
                        <div>
                            <h4 class="form-title">Edit Barang</h4>
                            <p class="form-subtitle">Perbarui informasi barang yang sudah ada</p>
                        </div>
                        <div class="header-info">
                            <span class="info-badge">
                                <i class="fas fa-edit"></i>
                                Mode Edit
                            </span>
                        </div>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('barang.update', $barang->id) }}" method="POST" class="custom-form">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <!-- Nama Barang -->
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label class="form-label">
                                        Nama Barang
                                        <span class="required">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-box input-icon"></i>
                                        <input type="text"
                                               class="form-control-custom @error('nama_barang') is-invalid @enderror"
                                               name="nama_barang"
                                               value="{{ old('nama_barang', $barang->nama_barang) }}"
                                               placeholder="Contoh: Laptop Dell Inspiron"
                                               required>
                                    </div>
                                    @error('nama_barang')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kategori -->
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label class="form-label">
                                        Kategori
                                        <span class="required">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-tags input-icon"></i>
                                        <select name="kategori_id"
                                                class="form-control-custom @error('kategori_id') is-invalid @enderror"
                                                required>
                                            <option value="" disabled>Pilih kategori...</option>
                                            @foreach($kategori as $k)
                                            <option value="{{ $k->id }}"
                                                {{ (old('kategori_id', $barang->kategori_id) == $k->id) ? 'selected' : '' }}>
                                                {{ $k->nama_kategori }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('kategori_id')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Lokasi -->
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label class="form-label">
                                        Lokasi
                                        <span class="required">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-map-marker-alt input-icon"></i>
                                        <select name="lokasi_id"
                                                class="form-control-custom @error('lokasi_id') is-invalid @enderror"
                                                required>
                                            <option value="" disabled>Pilih lokasi...</option>
                                            @foreach($lokasi as $l)
                                            <option value="{{ $l->id }}"
                                                {{ (old('lokasi_id', $barang->lokasi_id) == $l->id) ? 'selected' : '' }}>
                                                {{ $l->nama_lokasi }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('lokasi_id')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Bidang -->
                            @if(auth()->user()->role == 'admin')
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label class="form-label">
                                        Bidang
                                        <span class="required">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-building input-icon"></i>
                                        <select name="bidang_id"
                                                class="form-control-custom @error('bidang_id') is-invalid @enderror"
                                                required>
                                            <option value="" disabled>Pilih bidang...</option>
                                            @foreach($bidang as $b)
                                            <option value="{{ $b->id }}"
                                                {{ (old('bidang_id', $barang->bidang_id) == $b->id) ? 'selected' : '' }}>
                                                {{ $b->nama_bidang }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('bidang_id')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            @else
                            <!-- Petugas: Show bidang but readonly -->
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label class="form-label">
                                        Bidang
                                        <span class="badge-locked">Terkunci</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-building input-icon"></i>
                                        <input type="text"
                                               class="form-control-custom form-control-readonly"
                                               value="{{ $barang->bidang->nama_bidang }}"
                                               readonly>
                                    </div>
                                    <small class="form-text">Bidang tidak dapat diubah</small>
                                </div>
                            </div>
                            @endif

                            <!-- Jumlah Total -->
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label class="form-label">
                                        Jumlah Total
                                        <span class="required">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-hashtag input-icon"></i>
                                        <input type="number"
                                               class="form-control-custom @error('jumlah_total') is-invalid @enderror"
                                               name="jumlah_total"
                                               value="{{ old('jumlah_total', $barang->jumlah_total) }}"
                                               placeholder="0"
                                               min="0"
                                               required>
                                    </div>
                                    @error('jumlah_total')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Stok -->
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label class="form-label">
                                        Stok
                                        <span class="required">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-cubes input-icon"></i>
                                        <input type="number"
                                               class="form-control-custom @error('stok') is-invalid @enderror"
                                               name="stok"
                                               value="{{ old('stok', $barang->stok) }}"
                                               placeholder="0"
                                               min="0"
                                               required>
                                    </div>
                                    @error('stok')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kondisi -->
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label class="form-label">
                                        Kondisi
                                        <span class="required">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-check-circle input-icon"></i>
                                        <select name="kondisi"
                                                class="form-control-custom @error('kondisi') is-invalid @enderror"
                                                required>
                                            <option value="" disabled>Pilih kondisi...</option>
                                            <option value="baik" {{ (old('kondisi', $barang->kondisi) == 'baik') ? 'selected' : '' }}>Baik</option>
                                            <option value="perlu_perbaikan" {{ (old('kondisi', $barang->kondisi) == 'perlu_perbaikan') ? 'selected' : '' }}>Perlu Perbaikan</option>
                                            <option value="rusak" {{ (old('kondisi', $barang->kondisi) == 'rusak') ? 'selected' : '' }}>Rusak</option>
                                        </select>
                                    </div>
                                    @error('kondisi')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Info Alert -->
                            <div class="col-12">
                                <div class="alert-info-custom">
                                    <i class="fas fa-info-circle"></i>
                                    <div>
                                        <strong>Perhatian:</strong> Pastikan semua data yang diubah sudah benar sebelum menyimpan perubahan.
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <a href="{{ route('barang.index') }}" class="btn-back">
                                <i class="fas fa-arrow-left"></i>
                                <span>Kembali</span>
                            </a>
                            <div class="form-actions-right">
                                <button type="reset" class="btn-reset">
                                    <i class="fas fa-redo"></i>
                                    <span>Reset</span>
                                </button>
                                <button type="submit" class="btn-submit">
                                    <i class="fas fa-save"></i>
                                    <span>Update Barang</span>
                                </button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<style>
/* ===== TYPOGRAPHY ===== */
:root {
    --font-primary: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    --color-primary: #667eea;
    --color-primary-dark: #5568d3;
    --color-success: #10b981;
    --color-danger: #ef4444;
    --color-warning: #f59e0b;
    --color-info: #17a2b8;
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
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    color: #fff;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 0.3px;
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
}

.info-badge i {
    font-size: 14px;
}

/* ===== CUSTOM FORM ===== */
.custom-form {
    padding-top: 8px;
}

.form-group-custom {
    margin-bottom: 24px;
}

.form-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: var(--color-gray-700);
    margin-bottom: 8px;
    letter-spacing: 0.2px;
}

.required {
    color: var(--color-danger);
    margin-left: 2px;
    font-weight: 700;
}

/* ===== INPUT WRAPPER ===== */
.input-wrapper {
    position: relative;
}

.input-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--color-gray-400);
    font-size: 14px;
    pointer-events: none;
    transition: color 0.2s ease;
    z-index: 2;
}

/* ===== FORM CONTROLS ===== */
.form-control-custom {
    width: 100%;
    padding: 12px 16px 12px 44px;
    border: 1.5px solid var(--color-gray-200);
    border-radius: 10px;
    background: var(--color-gray-50);
    font-size: 14px;
    font-weight: 400;
    color: var(--color-gray-800);
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    outline: none;
    appearance: none;
}

.form-control-custom::placeholder {
    color: var(--color-gray-400);
    font-weight: 400;
}

.form-control-custom:hover {
    border-color: var(--color-gray-300);
    background: #fff;
}

.form-control-custom:focus {
    border-color: var(--color-primary);
    background: #fff;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
}

.form-control-custom:focus + .input-icon {
    color: var(--color-primary);
}

/* Readonly Fields */
.form-control-readonly {
    background: var(--color-gray-100) !important;
    color: var(--color-gray-600) !important;
    cursor: not-allowed;
    border-color: var(--color-gray-300) !important;
}

.form-control-readonly:hover,
.form-control-readonly:focus {
    background: var(--color-gray-100) !important;
    border-color: var(--color-gray-300) !important;
    box-shadow: none !important;
}

.form-text {
    display: block;
    margin-top: 6px;
    font-size: 12px;
    color: var(--color-gray-500);
    font-style: italic;
}

.badge-locked {
    display: inline-block;
    padding: 2px 8px;
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #991b1b;
    border-radius: 6px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-left: 6px;
}

/* Select Custom Arrow - Force Override */
select.form-control-custom {
    background-color: var(--color-gray-50) !important;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M6 9L1 4h10z'/%3E%3C/svg%3E") !important;
    background-repeat: no-repeat !important;
    background-position: right 16px center !important;
    background-size: 12px !important;
    background-attachment: scroll !important;
    padding-right: 44px;
    cursor: pointer;
    -webkit-appearance: none !important;
    -moz-appearance: none !important;
    appearance: none !important;
}

select.form-control-custom:hover {
    background-color: #fff !important;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M6 9L1 4h10z'/%3E%3C/svg%3E") !important;
}

select.form-control-custom:focus {
    background-color: #fff !important;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23667eea' d='M6 9L1 4h10z'/%3E%3C/svg%3E") !important;
}

select.form-control-custom::-ms-expand {
    display: none;
}

/* Remove any inherited background patterns */
select.form-control-custom,
select.form-control-custom * {
    background-clip: padding-box !important;
    background-origin: padding-box !important;
}

/* Select Options Styling - Clean & Simple */
select.form-control-custom option {
    padding: 10px 16px;
    background: #ffffff !important;
    background-color: #ffffff !important;
    background-image: none !important;
    color: var(--color-gray-800) !important;
    font-size: 14px;
    font-weight: 400;
}

select.form-control-custom option:checked {
    background: #667eea !important;
    background-color: #667eea !important;
    color: #ffffff !important;
}

select.form-control-custom option:disabled {
    color: var(--color-gray-400) !important;
    background: #f3f4f6 !important;
    background-color: #f3f4f6 !important;
    font-weight: 400;
}

/* Number Input - Remove Arrows */
input[type="number"].form-control-custom::-webkit-inner-spin-button,
input[type="number"].form-control-custom::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type="number"].form-control-custom {
    -moz-appearance: textfield;
}

/* ===== ERROR STATES ===== */
.form-control-custom.is-invalid {
    border-color: var(--color-danger);
    background: #fef2f2;
}

.form-control-custom.is-invalid:focus {
    box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
}

.error-message {
    display: block;
    margin-top: 6px;
    font-size: 12px;
    color: var(--color-danger);
    font-weight: 500;
}

/* ===== ALERT INFO ===== */
.alert-info-custom {
    display: flex;
    gap: 12px;
    padding: 16px 20px;
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    border-left: 4px solid #3b82f6;
    border-radius: 10px;
    margin-top: 8px;
}

.alert-info-custom i {
    color: #3b82f6;
    font-size: 20px;
    flex-shrink: 0;
    margin-top: 2px;
}

.alert-info-custom div {
    font-size: 13px;
    color: #1e40af;
    line-height: 1.5;
}

.alert-info-custom strong {
    font-weight: 700;
}

/* ===== FORM ACTIONS ===== */
.form-actions {
    display: flex;
    gap: 12px;
    justify-content: space-between;
    align-items: center;
    margin-top: 40px;
    padding-top: 24px;
    border-top: 2px solid var(--color-gray-100);
}

.form-actions-right {
    display: flex;
    gap: 12px;
    align-items: center;
}

/* Back Button */
.btn-back {
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

.btn-back:hover {
    background: var(--color-gray-50);
    color: var(--color-gray-900);
    border-color: var(--color-gray-400);
    transform: translateX(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.btn-back i {
    font-size: 13px;
}

/* Reset Button */
.btn-reset {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 28px;
    background: #fff;
    color: var(--color-gray-700);
    border: 1.5px solid var(--color-gray-300);
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

.btn-reset:hover {
    background: var(--color-gray-50);
    border-color: var(--color-gray-400);
    color: var(--color-gray-900);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.btn-reset:active {
    transform: translateY(0);
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
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.btn-submit:hover {
    background: linear-gradient(135deg, var(--color-primary-dark) 0%, #6b3fa0 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
}

.btn-submit:active {
    transform: translateY(0);
}

.btn-submit i,
.btn-reset i {
    font-size: 14px;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .form-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }

    .form-title {
        font-size: 20px;
    }

    .form-subtitle {
        font-size: 13px;
    }

    .form-actions {
        flex-direction: column;
        gap: 12px;
    }

    .form-actions-right {
        width: 100%;
        flex-direction: column-reverse;
    }

    .btn-reset,
    .btn-submit,
    .btn-back {
        width: 100%;
        justify-content: center;
    }

    .form-group-custom {
        margin-bottom: 20px;
    }
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

.custom-card {
    animation: slideUp 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

/* ===== FOCUS VISIBLE ===== */
.form-control-custom:focus-visible {
    outline: 2px solid var(--color-primary);
    outline-offset: 2px;
}

.btn-submit:focus-visible,
.btn-reset:focus-visible,
.btn-back:focus-visible {
    outline: 2px solid var(--color-primary);
    outline-offset: 2px;
}
</style>

<script>
// No JS needed - keeping it minimal as requested
</script>

@endsection
