@extends('layouts.backend')
@section('title','Tambah Pengembalian')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 mx-auto">

            <!-- Modern Header -->
            <div class="modern-page-header">
                <div class="header-content">
                    <div class="header-icon">
                        <i class="fas fa-undo-alt"></i>
                    </div>
                    <div class="header-text">
                        <h2 class="header-title">Catat Pengembalian Barang</h2>
                        <p class="header-subtitle">Proses pengembalian barang yang telah dipinjam</p>
                    </div>
                </div>
                <div class="header-breadcrumb">
                    <a href="{{ route('petugas.pengembalian.index') }}" class="breadcrumb-link">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Form Card -->
            <div class="modern-form-card">
                <form action="{{ route('petugas.pengembalian.store') }}" method="POST" id="formPengembalian">
                    @csrf

                    <!-- Section: Pilih Peminjaman -->
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-number">1</div>
                            <div class="section-info">
                                <h5 class="section-title">Pilih Peminjaman</h5>
                                <p class="section-subtitle">Pilih data peminjaman yang akan dikembalikan</p>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group-modern">
                                <label class="modern-label">
                                    <i class="fas fa-clipboard-list"></i>
                                    Data Peminjaman
                                    <span class="required-star">*</span>
                                </label>
                                <select
                                    name="peminjaman_id"
                                    id="peminjaman_id"
                                    class="modern-select @error('peminjaman_id') is-invalid @enderror"
                                    required
                                >
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
                                            {{ $p->nama_peminjam }} ({{ $p->npm }}) - {{ $p->barang->nama_barang }} ({{ $p->jumlah }} unit)
                                        </option>
                                    @endforeach
                                </select>
                                @error('peminjaman_id')
                                    <div class="error-feedback">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Info Box (Hidden by default) -->
                        <div id="info-peminjaman" class="info-box" style="display: none;">
                            <div class="info-box-header">
                                <i class="fas fa-info-circle"></i>
                                <span>Informasi Peminjaman</span>
                            </div>
                            <div class="info-box-grid">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-user"></i>
                                        Nama Peminjam
                                    </div>
                                    <div class="info-value" id="info-nama">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-id-card"></i>
                                        NPM
                                    </div>
                                    <div class="info-value" id="info-npm">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-box"></i>
                                        Nama Barang
                                    </div>
                                    <div class="info-value" id="info-barang">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-cubes"></i>
                                        Jumlah Dipinjam
                                    </div>
                                    <div class="info-value" id="info-jumlah">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-calendar-alt"></i>
                                        Tanggal Pinjam
                                    </div>
                                    <div class="info-value" id="info-tgl-pinjam">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-calendar-check"></i>
                                        Rencana Kembali
                                    </div>
                                    <div class="info-value" id="info-tgl-rencana">-</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Tanggal Pengembalian -->
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-number">2</div>
                            <div class="section-info">
                                <h5 class="section-title">Tanggal Pengembalian</h5>
                                <p class="section-subtitle">Tentukan tanggal pengembalian barang</p>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label class="modern-label">
                                        <i class="fas fa-calendar"></i>
                                        Tanggal Kembali
                                        <span class="required-star">*</span>
                                    </label>
                                    <input
                                        type="date"
                                        name="tgl_kembali_real"
                                        class="modern-input @error('tgl_kembali_real') is-invalid @enderror"
                                        value="{{ old('tgl_kembali_real', date('Y-m-d')) }}"
                                        required
                                    >
                                    @error('tgl_kembali_real')
                                        <div class="error-feedback">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Kondisi Barang -->
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-number">3</div>
                            <div class="section-info">
                                <h5 class="section-title">Kondisi Barang</h5>
                                <p class="section-subtitle">Tentukan kondisi barang yang dikembalikan</p>
                            </div>
                        </div>

                        <div class="kondisi-grid">
                            <!-- Baik -->
                            <div class="kondisi-card kondisi-baik">
                                <div class="kondisi-header">
                                    <div class="kondisi-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="kondisi-title">Baik</div>
                                </div>
                                <input
                                    type="number"
                                    name="kondisi[baik]"
                                    id="jumlah_baik"
                                    class="kondisi-input"
                                    min="0"
                                    value="{{ old('kondisi.baik', 0) }}"
                                    placeholder="0"
                                    required
                                >
                                <div class="kondisi-desc">Barang dalam kondisi sempurna</div>
                            </div>

                            <!-- Perlu Perbaikan -->
                            <div class="kondisi-card kondisi-perbaikan">
                                <div class="kondisi-header">
                                    <div class="kondisi-icon">
                                        <i class="fas fa-tools"></i>
                                    </div>
                                    <div class="kondisi-title">Perlu Perbaikan</div>
                                </div>
                                <input
                                    type="number"
                                    name="kondisi[perlu_perbaikan]"
                                    id="jumlah_perlu_perbaikan"
                                    class="kondisi-input"
                                    min="0"
                                    value="{{ old('kondisi.perlu_perbaikan', 0) }}"
                                    placeholder="0"
                                    required
                                >
                                <div class="kondisi-desc">Barang butuh perbaikan ringan</div>
                            </div>

                            <!-- Rusak -->
                            <div class="kondisi-card kondisi-rusak">
                                <div class="kondisi-header">
                                    <div class="kondisi-icon">
                                        <i class="fas fa-times-circle"></i>
                                    </div>
                                    <div class="kondisi-title">Rusak</div>
                                </div>
                                <input
                                    type="number"
                                    name="kondisi[rusak]"
                                    id="jumlah_rusak"
                                    class="kondisi-input"
                                    min="0"
                                    value="{{ old('kondisi.rusak', 0) }}"
                                    placeholder="0"
                                    required
                                >
                                <div class="kondisi-desc">Barang rusak/tidak berfungsi</div>
                            </div>
                        </div>

                        <!-- Total Counter -->
                        <div class="total-counter">
                            <div class="counter-content">
                                <div class="counter-label">Total Kondisi</div>
                                <div class="counter-value">
                                    <span id="total-kondisi">0</span>
                                    <span class="counter-max">/ <span id="max-jumlah">0</span></span>
                                </div>
                            </div>
                            <div class="counter-status" id="status-validasi">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>Belum valid</span>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Catatan -->
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-number">4</div>
                            <div class="section-info">
                                <h5 class="section-title">Catatan (Opsional)</h5>
                                <p class="section-subtitle">Tambahkan catatan kondisi barang jika diperlukan</p>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group-modern">
                                <label class="modern-label">
                                    <i class="fas fa-sticky-note"></i>
                                    Catatan Kondisi Barang
                                </label>
                                <textarea
                                    name="catatan"
                                    class="modern-textarea @error('catatan') is-invalid @enderror"
                                    rows="5"
                                    placeholder="Contoh: Laptop berfungsi normal, ada sedikit goresan di bagian casing..."
                                >{{ old('catatan') }}</textarea>
                                @error('catatan')
                                    <div class="error-feedback">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="{{ route('petugas.pengembalian.index') }}" class="btn-modern btn-cancel">
                            <i class="fas fa-times"></i>
                            <span>Batal</span>
                        </a>
                        <button type="submit" class="btn-modern btn-submit" id="btnSubmit">
                            <i class="fas fa-check-circle"></i>
                            <span>Simpan Pengembalian</span>
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

<style>
/* ===== VARIABLES ===== */
:root {
    --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --gradient-success: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    --gradient-warning: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    --gradient-danger: linear-gradient(135deg, #fa709a 0%, #fee140 100%);

    --color-purple: #667eea;
    --color-purple-dark: #5568d3;
    --color-green: #11998e;
    --color-orange: #f5576c;
    --color-red: #fa709a;

    --shadow-sm: 0 2px 10px rgba(102, 126, 234, 0.1);
    --shadow-md: 0 4px 20px rgba(102, 126, 234, 0.15);
    --shadow-lg: 0 10px 40px rgba(102, 126, 234, 0.2);
}

/* ===== PAGE HEADER ===== */
.modern-page-header {
    background: var(--gradient-primary);
    padding: 32px 36px;
    border-radius: 20px;
    margin-bottom: 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: var(--shadow-lg);
    animation: slideDown 0.5s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.header-content {
    display: flex;
    align-items: center;
    gap: 20px;
}

.header-icon {
    width: 70px;
    height: 70px;
    background: rgba(255,255,255,0.2);
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 36px;
    color: white;
    backdrop-filter: blur(10px);
}

.header-text {
    color: white;
}

.header-title {
    font-size: 28px;
    font-weight: 800;
    margin: 0 0 6px 0;
}

.header-subtitle {
    font-size: 15px;
    opacity: 0.95;
    margin: 0;
}

.header-breadcrumb {
}

.breadcrumb-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: rgba(255,255,255,0.2);
    color: white;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    backdrop-filter: blur(10px);
    transition: all 0.3s;
}

.breadcrumb-link:hover {
    background: rgba(255,255,255,0.3);
    transform: translateX(-3px);
    text-decoration: none;
    color: white;
}

/* ===== FORM CARD ===== */
.modern-form-card {
    background: white;
    border-radius: 20px;
    padding: 40px;
    box-shadow: var(--shadow-sm);
    animation: fadeIn 0.6s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ===== FORM SECTION ===== */
.form-section {
    margin-bottom: 40px;
    padding-bottom: 40px;
    border-bottom: 2px dashed #e2e8f0;
}

.form-section:last-of-type {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.section-header {
    display: flex;
    gap: 20px;
    margin-bottom: 28px;
}

.section-number {
    width: 50px;
    height: 50px;
    background: var(--gradient-primary);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    font-weight: 800;
    color: white;
    flex-shrink: 0;
}

.section-info {
    flex: 1;
}

.section-title {
    font-size: 20px;
    font-weight: 700;
    color: #1a202c;
    margin: 0 0 6px 0;
}

.section-subtitle {
    font-size: 14px;
    color: #718096;
    margin: 0;
}

/* ===== FORM CONTROLS ===== */
.form-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 24px;
}

.form-group-modern {
    margin-bottom: 0;
}

.modern-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 12px;
}

.modern-label i {
    color: var(--color-purple);
    font-size: 16px;
}

.required-star {
    color: #ef4444;
    font-weight: 900;
}

.modern-select,
.modern-input,
.modern-textarea {
    width: 100%;
    padding: 16px 20px;
    font-size: 15px;
    font-weight: 500;
    color: #1a202c;
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    transition: all 0.3s;
    font-family: inherit;
}

.modern-select:focus,
.modern-input:focus,
.modern-textarea:focus {
    outline: none;
    background: white;
    border-color: var(--color-purple);
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
}

.modern-select.is-invalid,
.modern-input.is-invalid,
.modern-textarea.is-invalid {
    border-color: #ef4444;
    background: #fef2f2;
}

.modern-textarea {
    resize: vertical;
    min-height: 120px;
    line-height: 1.6;
}

.error-feedback {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 10px;
    padding: 10px 16px;
    background: #fef2f2;
    border-left: 3px solid #ef4444;
    border-radius: 8px;
    color: #dc2626;
    font-size: 13px;
    font-weight: 600;
}

/* ===== INFO BOX ===== */
.info-box {
    background: linear-gradient(135deg, #f0f4ff 0%, #f5f0ff 100%);
    border: 2px solid #e0e7ff;
    border-radius: 16px;
    padding: 24px;
    margin-top: 24px;
}

.info-box-header {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 16px;
    font-weight: 700;
    color: var(--color-purple);
    margin-bottom: 20px;
    padding-bottom: 16px;
    border-bottom: 2px solid #e0e7ff;
}

.info-box-header i {
    font-size: 20px;
}

.info-box-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
}

.info-item {
}

.info-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.info-label i {
    color: var(--color-purple);
    font-size: 14px;
}

.info-value {
    font-size: 16px;
    font-weight: 700;
    color: #1a202c;
}

/* ===== KONDISI GRID ===== */
.kondisi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 24px;
}

.kondisi-card {
    background: white;
    border: 3px solid;
    border-radius: 16px;
    padding: 24px;
    transition: all 0.3s;
}

.kondisi-card.kondisi-baik {
    border-color: #d1fae5;
    background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
}

.kondisi-card.kondisi-perbaikan {
    border-color: #fed7aa;
    background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
}

.kondisi-card.kondisi-rusak {
    border-color: #fecaca;
    background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
}

.kondisi-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
}

.kondisi-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
}

.kondisi-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: white;
}

.kondisi-baik .kondisi-icon {
    background: var(--gradient-success);
}

.kondisi-perbaikan .kondisi-icon {
    background: var(--gradient-warning);
}

.kondisi-rusak .kondisi-icon {
    background: var(--gradient-danger);
}

.kondisi-title {
    font-size: 16px;
    font-weight: 700;
    color: #1a202c;
}

.kondisi-input {
    width: 100%;
    padding: 14px 18px;
    font-size: 20px;
    font-weight: 700;
    text-align: center;
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    margin-bottom: 12px;
    transition: all 0.3s;
}

.kondisi-input:focus {
    outline: none;
    border-color: var(--color-purple);
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
}

.kondisi-desc {
    font-size: 12px;
    color: #64748b;
    text-align: center;
    font-weight: 500;
}

/* ===== TOTAL COUNTER ===== */
.total-counter {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border: 2px solid #cbd5e1;
    border-radius: 16px;
    padding: 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.counter-content {
    display: flex;
    align-items: center;
    gap: 20px;
}

.counter-label {
    font-size: 14px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.counter-value {
    font-size: 32px;
    font-weight: 800;
    color: #1a202c;
}

.counter-value #total-kondisi {
    color: var(--color-purple);
}

.counter-max {
    font-size: 18px;
    color: #94a3b8;
}

.counter-status {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 700;
    background: #fef3c7;
    color: #d97706;
}

.counter-status.valid {
    background: #d1fae5;
    color: #059669;
}

.counter-status.invalid {
    background: #fee2e2;
    color: #dc2626;
}

/* ===== FORM ACTIONS ===== */
.form-actions {
    display: flex;
    gap: 16px;
    justify-content: flex-end;
    margin-top: 40px;
    padding-top: 32px;
    border-top: 2px solid #e2e8f0;
}

.btn-modern {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 16px 32px;
    border: none;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s;
    cursor: pointer;
}

.btn-cancel {
    background: white;
    color: #64748b;
    border: 2px solid #cbd5e1;
}

.btn-cancel:hover {
    background: #f8fafc;
    color: #1a202c;
    border-color: #94a3b8;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    text-decoration: none;
}

.btn-submit {
    background: var(--gradient-primary);
    color: white;
    box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4);
}

.btn-submit:active {
    transform: translateY(0);
}

.btn-modern i {
    font-size: 16px;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .modern-page-header {
        flex-direction: column;
        gap: 20px;
        text-align: center;
    }

    .header-content {
        flex-direction: column;
    }

    .modern-form-card {
        padding: 24px;
    }

    .section-header {
        flex-direction: column;
        gap: 12px;
    }

    .kondisi-grid {
        grid-template-columns: 1fr;
    }

    .total-counter {
        flex-direction: column;
        gap: 16px;
    }

    .form-actions {
        flex-direction: column-reverse;
    }

    .btn-modern {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectPeminjaman = document.getElementById('peminjaman_id');
    const infoBox = document.getElementById('info-peminjaman');

    const inputBaik = document.getElementById('jumlah_baik');
    const inputRusak = document.getElementById('jumlah_rusak');
    const inputPerlu = document.getElementById('jumlah_perlu_perbaikan');

    const totalKondisiEl = document.getElementById('total-kondisi');
    const maxJumlahEl = document.getElementById('max-jumlah');
    const statusValidasi = document.getElementById('status-validasi');
    const btnSubmit = document.getElementById('btnSubmit');

    let maxJumlah = 0;

    // Ketika peminjaman dipilih
    selectPeminjaman.addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];

        if (this.value) {
            // Tampilkan info box
            infoBox.style.display = 'block';

            // Isi data info
            document.getElementById('info-nama').textContent = selected.dataset.nama;
            document.getElementById('info-npm').textContent = selected.dataset.npm;
            document.getElementById('info-barang').textContent = selected.dataset.barang;
            document.getElementById('info-jumlah').textContent = selected.dataset.jumlah + ' unit';
            document.getElementById('info-tgl-pinjam').textContent = selected.dataset.tglPinjam;
            document.getElementById('info-tgl-rencana').textContent = selected.dataset.tglRencana;

            // Set max jumlah
            maxJumlah = parseInt(selected.dataset.jumlah || 0);
            maxJumlahEl.textContent = maxJumlah;

            // Auto-set kondisi baik = semua
            inputBaik.value = maxJumlah;
            inputRusak.value = 0;
            inputPerlu.value = 0;

            // Hitung total
            updateTotal();
        } else {
            infoBox.style.display = 'none';
            maxJumlah = 0;
            maxJumlahEl.textContent = 0;
            updateTotal();
        }
    });

    // Update total kondisi
    function updateTotal() {
        let total =
            parseInt(inputBaik.value || 0) +
            parseInt(inputRusak.value || 0) +
            parseInt(inputPerlu.value || 0);

        totalKondisiEl.textContent = total;

        // Validasi
        if (maxJumlah === 0) {
            statusValidasi.className = 'counter-status';
            statusValidasi.innerHTML = '<i class="fas fa-exclamation-circle"></i><span>Pilih peminjaman dulu</span>';
            btnSubmit.disabled = true;
        } else if (total === maxJumlah) {
            statusValidasi.className = 'counter-status valid';
            statusValidasi.innerHTML = '<i class="fas fa-check-circle"></i><span>Valid! Jumlah sesuai</span>';
            btnSubmit.disabled = false;
        } else if (total > maxJumlah) {
            statusValidasi.className = 'counter-status invalid';
            statusValidasi.innerHTML = '<i class="fas fa-times-circle"></i><span>Jumlah melebihi!</span>';
            btnSubmit.disabled = true;
        } else {
            statusValidasi.className = 'counter-status invalid';
            statusValidasi.innerHTML = '<i class="fas fa-exclamation-circle"></i><span>Jumlah kurang!</span>';
            btnSubmit.disabled = true;
        }
    }

    // Event listener untuk input kondisi
    inputBaik.addEventListener('input', updateTotal);
    inputRusak.addEventListener('input', updateTotal);
    inputPerlu.addEventListener('input', updateTotal);

    // Validasi sebelum submit
    document.getElementById('formPengembalian').addEventListener('submit', function(e) {
        let total =
            parseInt(inputBaik.value || 0) +
            parseInt(inputRusak.value || 0) +
            parseInt(inputPerlu.value || 0);

        if (total !== maxJumlah) {
            e.preventDefault();
            alert('Total kondisi harus sama dengan jumlah barang yang dipinjam (' + maxJumlah + ')!');
            return false;
        }
    });

    // Trigger jika ada old value (validation error)
    if (selectPeminjaman.value) {
        selectPeminjaman.dispatchEvent(new Event('change'));
    }

    // Initial update
    updateTotal();
});
</script>

@endsection
