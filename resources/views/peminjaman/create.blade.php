@extends('layouts.backend')
@section('title','Tambah Peminjaman')

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
                            <h4 class="form-title">Tambah Peminjaman Baru</h4>
                            <p class="form-subtitle">Lengkapi informasi peminjaman barang</p>
                        </div>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('petugas.peminjaman.store') }}" method="POST" class="custom-form">
                        @csrf

                        <div class="row">

                            <!-- Barang -->
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label class="form-label">
                                        Barang
                                        <span class="required">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-box input-icon"></i>
                                        <select name="barang_id"
                                                class="form-control-custom @error('barang_id') is-invalid @enderror"
                                                required>
                                            <option value="" disabled selected>Pilih barang...</option>
                                            @foreach($barang as $b)
                                            <option value="{{ $b->id }}" {{ old('barang_id') == $b->id ? 'selected' : '' }}>
                                                {{ $b->nama_barang }} (Stok: {{ $b->stok }})
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('barang_id')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Nama Peminjam -->
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label class="form-label">
                                        Nama Peminjam
                                        <span class="required">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-user input-icon"></i>
                                        <input type="text"
                                               class="form-control-custom @error('nama_peminjam') is-invalid @enderror"
                                               name="nama_peminjam"
                                               value="{{ old('nama_peminjam') }}"
                                               placeholder="Contoh: Ahmad Fauzi"
                                               required>
                                    </div>
                                    @error('nama_peminjam')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- NPM -->
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label class="form-label">
                                        NPM
                                        <span class="required">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-id-card input-icon"></i>
                                        <input type="text"
                                               class="form-control-custom @error('npm') is-invalid @enderror"
                                               name="npm"
                                               value="{{ old('npm') }}"
                                               placeholder="Contoh: 2001010123"
                                               required>
                                    </div>
                                    @error('npm')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Jurusan -->
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label class="form-label">
                                        Jurusan
                                        <span class="required">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-graduation-cap input-icon"></i>
                                        <select name="jurusan_id" class="form-control-custom" required>
                                            <option value="">Pilih jurusan...</option>
                                            @foreach($jurusans as $namaFakultas => $listJurusan)
                                                <optgroup label="{{ $namaFakultas }}">
                                                    @foreach($listJurusan as $j)
                                                        <option value="{{ $j->id }}" {{ old('jurusan_id') == $j->id ? 'selected' : '' }}>
                                                            {{ $j->nama_jurusan }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('jurusan_id')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Angkatan -->
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label class="form-label">
                                        Angkatan
                                        <span class="required">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-calendar input-icon"></i>
                                        <input type="number"
                                               class="form-control-custom @error('angkatan') is-invalid @enderror"
                                               name="angkatan"
                                               value="{{ old('angkatan') }}"
                                               placeholder="Contoh: 2020"
                                               min="2000"
                                               max="2099"
                                               required>
                                    </div>
                                    @error('angkatan')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Jumlah -->
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label class="form-label">
                                        Jumlah
                                        <span class="required">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-hashtag input-icon"></i>
                                        <input type="number"
                                               class="form-control-custom @error('jumlah') is-invalid @enderror"
                                               name="jumlah"
                                               value="{{ old('jumlah') }}"
                                               placeholder="0"
                                               min="1"
                                               required>
                                    </div>
                                    @error('jumlah')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Tanggal Pinjam -->
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label class="form-label">
                                        Tanggal Pinjam
                                        <span class="required">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-calendar-alt input-icon"></i>
                                        <input type="date"
                                               class="form-control-custom @error('tgl_pinjam') is-invalid @enderror"
                                               name="tgl_pinjam"
                                               value="{{ old('tgl_pinjam', date('Y-m-d')) }}"
                                               required>
                                    </div>
                                    @error('tgl_pinjam')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Rencana Kembali -->
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label class="form-label">
                                        Rencana Kembali
                                        <span class="required">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-calendar-check input-icon"></i>
                                        <input type="date"
                                               class="form-control-custom @error('tgl_kembali_rencana') is-invalid @enderror"
                                               name="tgl_kembali_rencana"
                                               value="{{ old('tgl_kembali_rencana') }}"
                                               required>
                                    </div>
                                    @error('tgl_kembali_rencana')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kondisi Saat Pinjam -->
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label class="form-label">
                                        Kondisi Saat Pinjam
                                        <span class="required">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-check-circle input-icon"></i>
                                        <select name="kondisi_saat_pinjam"
                                                class="form-control-custom @error('kondisi_saat_pinjam') is-invalid @enderror"
                                                required>
                                            <option value="" disabled selected>Pilih kondisi...</option>
                                            <option value="baik" {{ old('kondisi_saat_pinjam') == 'baik' ? 'selected' : '' }}>Baik</option>
                                            <option value="perlu_perbaikan" {{ old('kondisi_saat_pinjam') == 'perlu_perbaikan' ? 'selected' : '' }}>Perlu Perbaikan</option>
                                            <option value="rusak" {{ old('kondisi_saat_pinjam') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                        </select>
                                    </div>
                                    @error('kondisi_saat_pinjam')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <a href="{{ route('petugas.peminjaman.index') }}" class="btn-back">
                                <i class="fas fa-arrow-left"></i>
                                <span>Kembali</span>
                            </a>
                            <div class="form-actions-right">
                                <button type="reset" class="btn-reset" id="btn-reset">
                                    <i class="fas fa-redo"></i>
                                    <span>Reset</span>
                                </button>
                                <button type="submit" class="btn-submit" id="btn-submit">
                                    <i class="fas fa-save"></i>
                                    <span>Simpan Peminjaman</span>
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
    --color-warning: #f59e0b;
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

/* ===== CARD ===== */
.custom-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04), 0 1px 2px rgba(0,0,0,0.06);
    overflow: hidden;
    animation: slideUp 0.4s cubic-bezier(0.4,0,0.2,1);
}

/* ===== FORM HEADER ===== */
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

/* ===== FORM ===== */
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

/* ===== INPUT WRAPPER ===== */
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

/* ===== FORM CONTROLS ===== */
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

.form-control-custom:focus ~ .input-icon,
.input-wrapper:focus-within .input-icon { color: var(--color-primary); }

/* ===== SELECT ===== */
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

/* ===== NUMBER INPUT ===== */
input[type="number"].form-control-custom::-webkit-inner-spin-button,
input[type="number"].form-control-custom::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
input[type="number"].form-control-custom { -moz-appearance: textfield; }

input[type="date"].form-control-custom { cursor: pointer; }

/* ===== ERROR STATES ===== */
.form-control-custom.is-invalid { border-color: var(--color-danger); background: #fef2f2; }
.form-control-custom.is-invalid:focus { box-shadow: 0 0 0 3px rgba(239,68,68,0.1); }
.error-message { display: block; margin-top: 5px; font-size: 12px; color: var(--color-danger); font-weight: 500; }

/* ===== STOK WARNING ===== */
.stok-warning-box {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 8px;
    padding: 10px 14px;
    background: #fffbeb;
    border: 1px solid #f59e0b;
    border-radius: 8px;
    font-size: 13px;
    color: #78350f;
    font-weight: 500;
    animation: fadeInDown 0.2s ease;
}

.stok-warning-box i { color: #f59e0b; font-size: 14px; flex-shrink: 0; }
.stok-warning-box strong { font-weight: 700; color: #92400e; }

/* ===== FORM ACTIONS ===== */
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

/* Back Button */
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

/* Reset Button */
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
}

.btn-reset:hover {
    background: var(--color-gray-50);
    border-color: var(--color-gray-300);
    color: var(--color-gray-900);
    transform: translateY(-1px);
}

/* Submit Button */
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

.btn-submit:hover:not(:disabled) {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(102,126,234,0.35);
}

.btn-submit:disabled {
    background: linear-gradient(135deg, #a5b4fc 0%, #c4b5fd 100%);
    box-shadow: none;
    cursor: not-allowed;
    opacity: 0.7;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .form-actions { flex-direction: column; gap: 10px; }
    .form-actions-right { width: 100%; flex-direction: column-reverse; }
    .btn-reset, .btn-submit, .btn-back { width: 100%; justify-content: center; }
    .form-group-custom { margin-bottom: 16px; }
}

/* ===== ANIMATIONS ===== */
@keyframes slideUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}

@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-4px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ===== TANGGAL KEMBALI MIN =====
    const tglPinjam  = document.querySelector('input[name="tgl_pinjam"]');
    const tglKembali = document.querySelector('input[name="tgl_kembali_rencana"]');

    if (tglPinjam && tglKembali) {
        tglPinjam.addEventListener('change', function () {
            tglKembali.min = this.value;
            if (tglKembali.value && tglKembali.value < this.value) {
                tglKembali.value = this.value;
            }
        });
    }

    // ===== VALIDASI STOK REAL-TIME =====
    const selectBarang = document.querySelector('select[name="barang_id"]');
    const inputJumlah  = document.querySelector('input[name="jumlah"]');
    const btnSubmit    = document.getElementById('btn-submit');
    const btnReset     = document.getElementById('btn-reset');

    function getStok() {
        const selected = selectBarang.options[selectBarang.selectedIndex];
        if (!selected || !selected.value) return null;
        const match = selected.text.match(/Stok:\s*(\d+)/);
        return match ? parseInt(match[1]) : null;
    }

    function hapusWarning() {
        const existing = document.getElementById('stok-warning');
        if (existing) existing.remove();
    }

    function cekStok() {
        hapusWarning();
        const stok   = getStok();
        const jumlah = parseInt(inputJumlah.value);

        if (!stok || !jumlah || jumlah <= 0) {
            inputJumlah.classList.remove('is-invalid');
            btnSubmit.disabled = false;
            return;
        }

        if (jumlah > stok) {
            inputJumlah.classList.add('is-invalid');
            btnSubmit.disabled = true;
            const warning = document.createElement('div');
            warning.id        = 'stok-warning';
            warning.className = 'stok-warning-box';
            warning.innerHTML = `<i class="fas fa-exclamation-triangle"></i><span>Stok tidak mencukupi! Tersedia: <strong>${stok}</strong>, diminta: <strong>${jumlah}</strong>.</span>`;
            inputJumlah.closest('.form-group-custom').appendChild(warning);
        } else {
            inputJumlah.classList.remove('is-invalid');
            btnSubmit.disabled = false;
        }
    }

    if (selectBarang && inputJumlah) {
        selectBarang.addEventListener('change', cekStok);
        inputJumlah.addEventListener('input', cekStok);
    }

    if (btnReset) {
        btnReset.addEventListener('click', function () {
            setTimeout(function () {
                hapusWarning();
                inputJumlah.classList.remove('is-invalid');
                btnSubmit.disabled = false;
            }, 50);
        });
    }
});
</script>

@endsection
