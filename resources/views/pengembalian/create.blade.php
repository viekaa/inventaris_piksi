@extends('layouts.backend')
@section('title','Tambah Pengembalian')

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
                            <h4 class="form-title">Catat Pengembalian Barang</h4>
                            <p class="form-subtitle">Proses pengembalian barang yang telah dipinjam</p>
                        </div>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('petugas.pengembalian.store') }}" method="POST" class="custom-form" id="formPengembalian">
                        @csrf

                        <div class="row">

                            <!-- Data Peminjaman (full width) -->
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label class="form-label">
                                        Data Peminjaman
                                        <span class="required">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-clipboard-list input-icon"></i>
                                        <select
                                            name="peminjaman_id"
                                            id="peminjaman_id"
                                            class="form-control-custom @error('peminjaman_id') is-invalid @enderror"
                                            required>
                                            <option value="">-- Pilih Peminjaman --</option>
                                            @foreach($peminjaman as $p)
                                                <option
                                                    value="{{ $p->id }}"
                                                    data-nama="{{ $p->nama_peminjam }}"
                                                    data-npm="{{ $p->npm }}"
                                                    data-barang="{{ $p->barang->nama_barang }}"
                                                    data-jumlah="{{ $p->jumlah }}"
                                                    data-tgl-pinjam="{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d/m/Y') }}"
                                                    data-tgl-rencana="{{ \Carbon\Carbon::parse($p->tgl_kembali_rencana)->format('d/m/Y') }}"
                                                    {{ old('peminjaman_id') == $p->id ? 'selected' : '' }}
                                                >
                                                    {{ $p->nama_peminjam }} ({{ $p->npm }}) — {{ $p->barang->nama_barang }} ({{ $p->jumlah }} unit)
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('peminjaman_id')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Info Bar -->
                                <div id="infoBar" class="info-bar" style="display:none;">
                                    <div class="info-item">
                                        <span class="info-label">Nama Peminjam</span>
                                        <span class="info-value" id="iNama">-</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">NPM</span>
                                        <span class="info-value" id="iNpm">-</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Nama Barang</span>
                                        <span class="info-value" id="iBarang">-</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Jumlah Dipinjam</span>
                                        <span class="info-value" id="iJumlah">-</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Tanggal Pinjam</span>
                                        <span class="info-value" id="iTglPinjam">-</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Rencana Kembali</span>
                                        <span class="info-value" id="iTglRencana">-</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Tanggal Kembali -->
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label class="form-label">
                                        Tanggal Kembali
                                        <span class="required">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-calendar-alt input-icon"></i>
                                        <input
                                            type="date"
                                            name="tgl_kembali_real"
                                            class="form-control-custom @error('tgl_kembali_real') is-invalid @enderror"
                                            value="{{ old('tgl_kembali_real', date('Y-m-d')) }}"
                                            required
                                        >
                                    </div>
                                    @error('tgl_kembali_real')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kondisi Barang -->
                            <div class="col-md-12">
                                <div class="form-group-custom">
                                    <label class="form-label">
                                        Kondisi Barang
                                        <span class="required">*</span>
                                    </label>
                                    <div class="row">
                                        <!-- Baik -->
                                        <div class="col-md-4">
                                            <div class="kondisi-wrapper">
                                                <label class="kondisi-label">Baik</label>
                                                <div class="input-wrapper">
                                                    <i class="fas fa-check-circle input-icon"></i>
                                                    <input
                                                        type="number"
                                                        name="kondisi[baik]"
                                                        id="jumlah_baik"
                                                        class="form-control-custom kondisi-input"
                                                        min="0"
                                                        value="{{ old('kondisi.baik', 0) }}"
                                                        placeholder="0"
                                                        required
                                                    >
                                                </div>
                                                <small class="kondisi-desc">Kondisi sempurna</small>
                                            </div>
                                        </div>
                                        <!-- Perlu Perbaikan -->
                                        <div class="col-md-4">
                                            <div class="kondisi-wrapper">
                                                <label class="kondisi-label">Perlu Perbaikan</label>
                                                <div class="input-wrapper">
                                                    <i class="fas fa-tools input-icon"></i>
                                                    <input
                                                        type="number"
                                                        name="kondisi[perlu_perbaikan]"
                                                        id="jumlah_perlu_perbaikan"
                                                        class="form-control-custom kondisi-input"
                                                        min="0"
                                                        value="{{ old('kondisi.perlu_perbaikan', 0) }}"
                                                        placeholder="0"
                                                        required
                                                    >
                                                </div>
                                                <small class="kondisi-desc">Butuh perbaikan ringan</small>
                                            </div>
                                        </div>
                                        <!-- Rusak -->
                                        <div class="col-md-4">
                                            <div class="kondisi-wrapper">
                                                <label class="kondisi-label">Rusak</label>
                                                <div class="input-wrapper">
                                                    <i class="fas fa-times-circle input-icon"></i>
                                                    <input
                                                        type="number"
                                                        name="kondisi[rusak]"
                                                        id="jumlah_rusak"
                                                        class="form-control-custom kondisi-input"
                                                        min="0"
                                                        value="{{ old('kondisi.rusak', 0) }}"
                                                        placeholder="0"
                                                        required
                                                    >
                                                </div>
                                                <small class="kondisi-desc">Rusak / tidak berfungsi</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Total Counter -->
                                    <div class="total-bar">
                                        <span class="total-label">Total kondisi</span>
                                        <div class="total-right">
                                            <span class="total-val">
                                                <span id="totalKondisi">0</span> / <span id="maxJumlah">0</span>
                                            </span>
                                            <span class="status-badge badge-wait" id="statusBadge">Pilih peminjaman dulu</span>
                                        </div>
                                    </div>

                                    @error('kondisi')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Catatan -->
                            <div class="col-md-12">
                                <div class="form-group-custom">
                                    <label class="form-label">
                                        Catatan Kondisi
                                        <span class="optional-tag">(opsional)</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-sticky-note input-icon" style="top:16px;transform:none;"></i>
                                        <textarea
                                            name="catatan"
                                            class="form-control-custom @error('catatan') is-invalid @enderror"
                                            rows="4"
                                            placeholder="Contoh: Laptop berfungsi normal, ada sedikit goresan di bagian casing..."
                                        >{{ old('catatan') }}</textarea>
                                    </div>
                                    @error('catatan')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <a href="{{ route('petugas.pengembalian.index') }}" class="btn-back">
                                <i class="fas fa-arrow-left"></i>
                                <span>Kembali</span>
                            </a>
                            <button type="submit" class="btn-submit" id="btnSubmit" disabled>
                                <i class="fas fa-save"></i>
                                <span>Simpan Pengembalian</span>
                            </button>
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

body { font-family: var(--font-primary); -webkit-font-smoothing: antialiased; }

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

/* ===== FORM ===== */
.custom-form { padding-top: 8px; }
.form-group-custom { margin-bottom: 24px; }

.form-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: var(--color-gray-700);
    margin-bottom: 8px;
    letter-spacing: 0.2px;
}

.required { color: var(--color-danger); margin-left: 2px; font-weight: 700; }
.optional-tag { font-size: 12px; color: var(--color-gray-400); font-weight: 400; margin-left: 4px; }

/* ===== INPUT WRAPPER ===== */
.input-wrapper { position: relative; }

.input-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--color-gray-400);
    font-size: 14px;
    pointer-events: none;
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
    transition: all 0.25s cubic-bezier(0.4,0,0.2,1);
    outline: none;
    appearance: none;
    font-family: inherit;
}

.form-control-custom::placeholder { color: var(--color-gray-400); }

.form-control-custom:hover { border-color: var(--color-gray-300); background: #fff; }

.form-control-custom:focus {
    border-color: var(--color-primary);
    background: #fff;
    box-shadow: 0 0 0 4px rgba(102,126,234,0.1);
}

.form-control-custom.is-invalid { border-color: var(--color-danger); background: #fef2f2; }

textarea.form-control-custom { resize: vertical; min-height: 100px; line-height: 1.6; }

select.form-control-custom {
    background-color: var(--color-gray-50);
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 16px center;
    background-size: 12px;
    padding-right: 44px;
    cursor: pointer;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}

.kondisi-input { text-align: center; }

input[type="number"].form-control-custom::-webkit-inner-spin-button,
input[type="number"].form-control-custom::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
input[type="number"].form-control-custom { -moz-appearance: textfield; }

.error-message { display: block; margin-top: 6px; font-size: 12px; color: var(--color-danger); font-weight: 500; }

/* ===== INFO BAR ===== */
.info-bar {
    background: var(--color-gray-50);
    border: 1.5px solid var(--color-gray-200);
    border-radius: 10px;
    padding: 14px 18px;
    margin-top: -8px;
    margin-bottom: 8px;
    display: flex;
    flex-wrap: wrap;
    gap: 14px 36px;
}

.info-item { display: flex; flex-direction: column; gap: 2px; min-width: 120px; }

.info-label {
    font-size: 11px;
    font-weight: 600;
    color: var(--color-gray-400);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value { font-size: 13px; font-weight: 600; color: var(--color-gray-800); }

/* ===== KONDISI ===== */
.kondisi-wrapper { margin-bottom: 4px; }

.kondisi-label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: var(--color-gray-600);
    margin-bottom: 6px;
}

.kondisi-desc {
    display: block;
    font-size: 11px;
    color: var(--color-gray-400);
    margin-top: 5px;
    text-align: center;
}

/* ===== TOTAL BAR ===== */
.total-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 16px;
    background: var(--color-gray-50);
    border: 1.5px solid var(--color-gray-200);
    border-radius: 10px;
    margin-top: 14px;
}

.total-label { font-size: 13px; color: var(--color-gray-500); font-weight: 500; }
.total-right { display: flex; align-items: center; gap: 10px; }
.total-val { font-size: 14px; font-weight: 600; color: var(--color-gray-800); }

.status-badge { font-size: 12px; font-weight: 600; padding: 4px 12px; border-radius: 6px; }
.badge-wait { background: #fef3c7; color: #92400e; }
.badge-ok   { background: #d1fae5; color: #065f46; }
.badge-err  { background: #fee2e2; color: #991b1b; }

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
    transition: all 0.25s cubic-bezier(0.4,0,0.2,1);
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
}

.btn-back:hover {
    background: var(--color-gray-50);
    color: var(--color-gray-900);
    border-color: var(--color-gray-400);
    transform: translateX(-2px);
    text-decoration: none;
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
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.4,0,0.2,1);
    box-shadow: 0 4px 12px rgba(102,126,234,0.3);
    font-family: inherit;
}

.btn-submit:hover:not(:disabled) {
    background: linear-gradient(135deg, var(--color-primary-dark) 0%, #6b3fa0 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102,126,234,0.4);
}

.btn-submit:disabled {
    background: var(--color-gray-200);
    color: var(--color-gray-400);
    box-shadow: none;
    cursor: not-allowed;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .form-title { font-size: 20px; }
    .form-actions { flex-direction: column; gap: 12px; }
    .btn-back, .btn-submit { width: 100%; justify-content: center; }
    .info-bar { gap: 12px 20px; }
    .total-bar { flex-direction: column; align-items: flex-start; gap: 8px; }
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const sel   = document.getElementById('peminjaman_id');
    const bar   = document.getElementById('infoBar');
    const iB    = document.getElementById('jumlah_baik');
    const iP    = document.getElementById('jumlah_perlu_perbaikan');
    const iR    = document.getElementById('jumlah_rusak');
    const tot   = document.getElementById('totalKondisi');
    const maxEl = document.getElementById('maxJumlah');
    const badge = document.getElementById('statusBadge');
    const btn   = document.getElementById('btnSubmit');
    let max = 0;

    sel.addEventListener('change', function () {
        const o = this.options[this.selectedIndex];
        if (this.value) {
            bar.style.display = 'flex';
            document.getElementById('iNama').textContent       = o.dataset.nama;
            document.getElementById('iNpm').textContent        = o.dataset.npm;
            document.getElementById('iBarang').textContent     = o.dataset.barang;
            document.getElementById('iJumlah').textContent     = o.dataset.jumlah + ' unit';
            document.getElementById('iTglPinjam').textContent  = o.dataset.tglPinjam;
            document.getElementById('iTglRencana').textContent = o.dataset.tglRencana;
            max = parseInt(o.dataset.jumlah || 0);
            maxEl.textContent = max;
            iB.value = max; iP.value = 0; iR.value = 0;
        } else {
            bar.style.display = 'none';
            max = 0; maxEl.textContent = 0;
            iB.value = 0; iP.value = 0; iR.value = 0;
        }
        updateTotal();
    });

    function updateTotal() {
        const t = (parseInt(iB.value) || 0) + (parseInt(iP.value) || 0) + (parseInt(iR.value) || 0);
        tot.textContent = t;

        if (max === 0) {
            badge.className = 'status-badge badge-wait';
            badge.textContent = 'Pilih peminjaman dulu';
            btn.disabled = true;
        } else if (t === max) {
            badge.className = 'status-badge badge-ok';
            badge.textContent = 'Sesuai';
            btn.disabled = false;
        } else if (t > max) {
            badge.className = 'status-badge badge-err';
            badge.textContent = 'Melebihi jumlah';
            btn.disabled = true;
        } else {
            badge.className = 'status-badge badge-err';
            badge.textContent = 'Kurang dari jumlah';
            btn.disabled = true;
        }
    }

    [iB, iP, iR].forEach(el => el.addEventListener('input', updateTotal));

    document.getElementById('formPengembalian').addEventListener('submit', function (e) {
        const t = (parseInt(iB.value) || 0) + (parseInt(iP.value) || 0) + (parseInt(iR.value) || 0);
        if (t !== max) {
            e.preventDefault();
            alert('Total kondisi harus sama dengan jumlah barang yang dipinjam (' + max + ')!');
        }
    });

    if (sel.value) sel.dispatchEvent(new Event('change'));
    updateTotal();
});
</script>

@endsection
