@extends('layouts.backend')
@section('title','Tambah Barang')

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
                            <h4 class="form-title">Tambah Barang Baru</h4>
                            <p class="form-subtitle">Lengkapi informasi barang yang akan ditambahkan</p>
                        </div>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('barang.store') }}" method="POST" class="custom-form" enctype="multipart/form-data">
                        @csrf

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
                                               value="{{ old('nama_barang') }}"
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
                                            <option value="" disabled selected>Pilih kategori...</option>
                                            @foreach($kategori as $k)
                                            <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
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
                                            <option value="" disabled selected>Pilih lokasi...</option>
                                            @foreach($lokasi as $l)
                                            <option value="{{ $l->id }}" {{ old('lokasi_id') == $l->id ? 'selected' : '' }}>
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
                                            <option value="" disabled selected>Pilih bidang...</option>
                                            @foreach($bidang as $b)
                                            <option value="{{ $b->id }}" {{ old('bidang_id') == $b->id ? 'selected' : '' }}>
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
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label class="form-label">
                                        Bidang
                                        <span class="badge-auto">Otomatis</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-building input-icon"></i>
                                        <input type="text"
                                               class="form-control-custom form-control-readonly"
                                               value="{{ $bidang->first()->nama_bidang }}"
                                               readonly>
                                    </div>
                                    <small class="form-text">Bidang disesuaikan dengan akun Anda</small>
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
                                               value="{{ old('jumlah_total') }}"
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
                                               value="{{ old('stok') }}"
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
                                        <span class="badge-auto">Otomatis</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-check-circle input-icon"></i>
                                        <input type="hidden" name="kondisi" value="baik">
                                        <input type="text"
                                               class="form-control-custom form-control-readonly"
                                               value="Baik"
                                               readonly>
                                    </div>
                                    <small class="form-text">Barang baru otomatis berkondisi baik</small>
                                </div>
                            </div>

                            <!-- Foto Barang -->
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label class="form-label">
                                        Foto Barang
                                        <span class="optional-tag">(Opsional)</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-image input-icon"></i>
                                        <input type="file"
                                               name="foto"
                                               class="form-control-custom @error('foto') is-invalid @enderror"
                                               accept="image/*"
                                               onchange="previewImage(this)">
                                    </div>
                                    <small class="form-text">Format: JPG, JPEG, PNG (Maks. 2MB)</small>
                                    <div id="image-preview-container" class="mt-3" style="display: none;">
                                        <img id="img-preview" src="#" alt="Preview" style="max-width: 200px; border-radius: 8px; border: 1px solid var(--color-gray-200);">
                                        <p class="form-text mt-1">Preview Gambar</p>
                                    </div>
                                    @error('foto')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
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
                                    <span>Simpan Barang</span>
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

body { font-family: var(--font-primary); -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }

.custom-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04), 0 1px 2px rgba(0,0,0,0.06);
    overflow: hidden;
    animation: slideUp 0.4s cubic-bezier(0.4,0,0.2,1);
}

.form-header {
    padding-bottom: 24px;
    border-bottom: 1px solid var(--color-gray-200);
    margin-bottom: 32px;
}

.form-title {
    font-size: 22px;
    font-weight: 700;
    letter-spacing: -0.4px;
    color: var(--color-gray-900);
    margin: 0 0 4px 0;
}

.form-subtitle {
    font-size: 13px;
    color: var(--color-gray-500);
    margin: 0;
    font-weight: 400;
}

.custom-form { padding-top: 8px; }
.form-group-custom { margin-bottom: 20px; }

.form-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: var(--color-gray-700);
    margin-bottom: 6px;
    letter-spacing: 0.1px;
}

.required { color: var(--color-danger); margin-left: 2px; font-weight: 700; }
.optional-tag { font-size: 12px; color: var(--color-gray-400); font-weight: 400; margin-left: 4px; }

.badge-auto {
    display: inline-block;
    padding: 2px 7px;
    background: #dbeafe;
    color: #1e40af;
    border-radius: 5px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-left: 6px;
}

.input-wrapper { position: relative; }

.input-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--color-gray-400);
    font-size: 13px;
    pointer-events: none;
    z-index: 2;
    transition: color 0.2s ease;
}

.form-control-custom {
    width: 100%;
    padding: 11px 14px 11px 40px;
    border: 1px solid var(--color-gray-200);
    border-radius: 8px;
    background: #fff;
    font-size: 13.5px;
    font-weight: 400;
    color: var(--color-gray-800);
    transition: all 0.2s ease;
    outline: none;
    appearance: none;
    font-family: inherit;
}

.form-control-custom::placeholder { color: var(--color-gray-400); }
.form-control-custom:hover { border-color: var(--color-gray-300); }
.form-control-custom:focus {
    border-color: var(--color-primary);
    box-shadow: 0 0 0 3px rgba(102,126,234,0.12);
}

.input-wrapper:focus-within .input-icon { color: var(--color-primary); }

.form-control-readonly {
    background: var(--color-gray-50) !important;
    color: var(--color-gray-500) !important;
    cursor: not-allowed;
    border-color: var(--color-gray-200) !important;
}

.form-control-readonly:hover,
.form-control-readonly:focus {
    background: var(--color-gray-50) !important;
    border-color: var(--color-gray-200) !important;
    box-shadow: none !important;
}

.form-text {
    display: block;
    margin-top: 5px;
    font-size: 12px;
    color: var(--color-gray-400);
}

select.form-control-custom {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='11' viewBox='0 0 12 12'%3E%3Cpath fill='%239ca3af' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
    background-size: 11px;
    padding-right: 36px;
    cursor: pointer;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}

select.form-control-custom:focus {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='11' viewBox='0 0 12 12'%3E%3Cpath fill='%23667eea' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
}

select.form-control-custom option { background: #fff; color: var(--color-gray-800); }
select.form-control-custom option:disabled { color: var(--color-gray-400); }

input[type="number"].form-control-custom::-webkit-inner-spin-button,
input[type="number"].form-control-custom::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
input[type="number"].form-control-custom { -moz-appearance: textfield; }

.form-control-custom.is-invalid { border-color: var(--color-danger); background: #fef2f2; }
.form-control-custom.is-invalid:focus { box-shadow: 0 0 0 3px rgba(239,68,68,0.1); }
.error-message { display: block; margin-top: 5px; font-size: 12px; color: var(--color-danger); font-weight: 500; }

.form-actions {
    display: flex;
    gap: 12px;
    justify-content: space-between;
    align-items: center;
    margin-top: 32px;
    padding-top: 20px;
    border-top: 1px solid var(--color-gray-200);
}

.form-actions-right { display: flex; gap: 10px; align-items: center; }

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 10px 20px;
    background: #fff;
    color: var(--color-gray-600);
    border: 1px solid var(--color-gray-200);
    border-radius: 8px;
    font-size: 13.5px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
}

.btn-back:hover {
    background: var(--color-gray-50);
    color: var(--color-gray-900);
    border-color: var(--color-gray-300);
    transform: translateX(-2px);
    text-decoration: none;
}

.btn-reset {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 10px 22px;
    background: #fff;
    color: var(--color-gray-600);
    border: 1px solid var(--color-gray-200);
    border-radius: 8px;
    font-size: 13.5px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    font-family: inherit;
}

.btn-reset:hover {
    background: var(--color-gray-50);
    border-color: var(--color-gray-300);
    color: var(--color-gray-900);
    transform: translateY(-1px);
}

.btn-submit {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 10px 28px;
    background: linear-gradient(135deg, var(--color-primary) 0%, #764ba2 100%);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 13.5px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 3px 10px rgba(102,126,234,0.25);
    font-family: inherit;
}

.btn-submit:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(102,126,234,0.35);
}

.btn-submit:active, .btn-reset:active { transform: translateY(0); }

@media (max-width: 768px) {
    .form-actions { flex-direction: column; gap: 10px; }
    .form-actions-right { width: 100%; flex-direction: column-reverse; }
    .btn-reset, .btn-submit, .btn-back { width: 100%; justify-content: center; }
    .form-group-custom { margin-bottom: 16px; }
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const jumlahTotal = document.querySelector('input[name="jumlah_total"]');
    const stok = document.querySelector('input[name="stok"]');

    if (jumlahTotal && stok) {
        jumlahTotal.addEventListener('input', function() {
            if (!stok.value) stok.value = this.value;
        });
    }
});

function previewImage(input) {
    const container = document.getElementById('image-preview-container');
    const img = document.getElementById('img-preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            container.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        container.style.display = 'none';
    }
}
</script>

@endsection
