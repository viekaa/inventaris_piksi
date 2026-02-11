@extends('layouts.backend')
@section('title','Edit Pengembalian')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10 mx-auto">

            <!-- Form Card -->
            <div class="card custom-card">
                <div class="card-body p-4">

                    <!-- Header -->
                    <div class="form-header">
                        <div>
                            <h4 class="form-title">Edit Data Pengembalian</h4>
                            <p class="form-subtitle">Perbarui informasi pengembalian di bawah ini</p>
                        </div>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('petugas.pengembalian.update', $pengembalian->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-content">

                            <!-- Info Peminjaman -->
                            <div class="info-peminjaman-box">
                                <div class="info-header">
                                    <i class="fas fa-info-circle"></i>
                                    <span>Informasi Peminjaman</span>
                                </div>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <label>Peminjam</label>
                                        <div>{{ $pengembalian->peminjaman->nama_peminjam }}</div>
                                    </div>
                                    <div class="info-item">
                                        <label>NPM</label>
                                        <div>{{ $pengembalian->peminjaman->npm }}</div>
                                    </div>
                                    <div class="info-item">
                                        <label>Barang</label>
                                        <div>{{ $pengembalian->peminjaman->barang->nama_barang }}</div>
                                    </div>
                                    <div class="info-item">
                                        <label>Jumlah</label>
                                        <div>{{ $pengembalian->peminjaman->jumlah }} unit</div>
                                    </div>
                                    <div class="info-item">
                                        <label>Tgl Pinjam</label>
                                        <div>{{ \Carbon\Carbon::parse($pengembalian->peminjaman->tgl_pinjam)->format('d/m/Y') }}</div>
                                    </div>
                                    <div class="info-item">
                                        <label>Tgl Rencana Kembali</label>
                                        <div>{{ \Carbon\Carbon::parse($pengembalian->peminjaman->tgl_kembali_rencana)->format('d/m/Y') }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Pengembalian Section -->
                            <div class="form-section">
                                <h5 class="section-title">
                                    <i class="fas fa-undo-alt"></i>
                                    Data Pengembalian
                                </h5>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-group-custom">
                                            <label class="form-label-custom">
                                                <i class="fas fa-calendar-check"></i>
                                                Tanggal Kembali
                                                <span class="required">*</span>
                                            </label>
                                            <input
                                                type="date"
                                                name="tgl_kembali_real"
                                                class="form-control-custom @error('tgl_kembali_real') is-invalid @enderror"
                                                value="{{ old('tgl_kembali_real', $pengembalian->tgl_kembali_real) }}"
                                                required
                                            >
                                            @error('tgl_kembali_real')
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
                                                <i class="fas fa-clipboard-check"></i>
                                                Kondisi Saat Kembali
                                                <span class="required">*</span>
                                            </label>
                                            <select
                                                name="kondisi_saat_kembali"
                                                class="form-control-custom @error('kondisi_saat_kembali') is-invalid @enderror"
                                                required
                                            >
                                                <option value="">Pilih Kondisi</option>
                                                <option value="baik" {{ old('kondisi_saat_kembali', $pengembalian->kondisi_saat_kembali) == 'baik' ? 'selected' : '' }}>Baik</option>
                                                <option value="rusak" {{ old('kondisi_saat_kembali', $pengembalian->kondisi_saat_kembali) == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                                <option value="perlu_perbaikan" {{ old('kondisi_saat_kembali', $pengembalian->kondisi_saat_kembali) == 'perlu_perbaikan' ? 'selected' : '' }}>Perlu Perbaikan</option>
                                            </select>
                                            @error('kondisi_saat_kembali')
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
                                                <i class="fas fa-sticky-note"></i>
                                                Catatan
                                            </label>
                                            <textarea
                                                name="catatan"
                                                class="form-control-custom @error('catatan') is-invalid @enderror"
                                                rows="4"
                                                placeholder="Catatan tambahan mengenai kondisi barang (opsional)"
                                            >{{ old('catatan', $pengembalian->catatan) }}</textarea>
                                            @error('catatan')
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <small class="form-hint">Contoh: Ada sedikit goresan di bagian samping, keyboard berfungsi normal</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Current Hari Telat Info -->
                            @if($pengembalian->hari_telat > 0)
                            <div class="alert-warning-box">
                                <i class="fas fa-exclamation-triangle"></i>
                                <div>
                                    <strong>Keterlambatan:</strong> Saat ini tercatat {{ $pengembalian->hari_telat }} hari telat. Hari telat akan dihitung ulang otomatis berdasarkan tanggal kembali yang baru.
                                </div>
                            </div>
                            @endif

                        </div>

                        <!-- Action Buttons -->
                        <div class="form-actions">
                            <a href="{{ route('petugas.pengembalian.index') }}" class="btn-cancel">
                                <i class="fas fa-times"></i>
                                <span>Batal</span>
                            </a>
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-save"></i>
                                <span>Update Pengembalian</span>
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
    --color-warning: #f59e0b;
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

.form-section {
    margin-bottom: 36px;
}

.form-section:last-of-type {
    margin-bottom: 0;
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

textarea.form-control-custom {
    resize: vertical;
    min-height: 100px;
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

/* ===== INFO PEMINJAMAN BOX ===== */
.info-peminjaman-box {
    background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
    border: 1.5px solid #667eea40;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 36px;
}

.info-header {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 15px;
    font-weight: 700;
    color: var(--color-primary);
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid #667eea30;
}

.info-header i {
    font-size: 18px;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
}

.info-item label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: var(--color-gray-500);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
}

.info-item div {
    font-size: 15px;
    font-weight: 600;
    color: var(--color-gray-900);
}

/* ===== ALERT BOXES ===== */
.alert-warning-box {
    display: flex;
    gap: 12px;
    padding: 16px 18px;
    background: #fffbeb;
    border-left: 4px solid var(--color-warning);
    border-radius: 10px;
    margin-top: 24px;
}

.alert-warning-box i {
    color: var(--color-warning);
    font-size: 20px;
    flex-shrink: 0;
    margin-top: 2px;
}

.alert-warning-box strong {
    color: var(--color-gray-900);
    font-weight: 600;
}

.alert-warning-box div {
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

    .info-grid {
        grid-template-columns: 1fr;
    }
}
</style>

@endsection
