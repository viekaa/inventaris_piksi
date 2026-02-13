@extends('layouts.backend')
@section('title','Edit Pengembalian')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card pged-card">
                <div class="card-body p-5">

                    @php
                        $baik = $pengembalian->details()->where('kondisi', 'baik')->value('jumlah') ?? 0;
                        $rusak = $pengembalian->details()->where('kondisi', 'rusak')->value('jumlah') ?? 0;
                        $perlu = $pengembalian->details()->where('kondisi', 'perlu_perbaikan')->value('jumlah') ?? 0;
                        $jurusanName = is_object($pengembalian->peminjaman->jurusan)
                                        ? $pengembalian->peminjaman->jurusan->nama_jurusan
                                        : $pengembalian->peminjaman->jurusan;
                    @endphp

                    {{-- HEADER --}}
                    <div class="pged-header">
                        <div>
                            <h4 class="pged-title">Edit Pengembalian</h4>
                            <p class="pged-subtitle">Perbarui data pengembalian barang</p>
                        </div>
                        <div class="pged-badge">
                            <i class="far fa-edit"></i>
                            Mode Edit
                        </div>
                    </div>

                    <form action="{{ route('petugas.pengembalian.update', $pengembalian->id) }}" method="POST" id="formEdit">
                        @csrf
                        @method('PUT')

                        {{-- INFO READ-ONLY --}}
                        <div class="pged-section">
                            <div class="pged-stitle">
                                <i class="fas fa-info-circle"></i>
                                Informasi Peminjaman (Read-Only)
                            </div>

                            <div class="pged-row">
                                <div class="pged-item">
                                    <div class="pged-lbl"><i class="fas fa-user-circle"></i> Nama Peminjam</div>
                                    <div class="pged-val">{{ $pengembalian->peminjaman->nama_peminjam }}</div>
                                </div>
                                <div class="pged-item">
                                    <div class="pged-lbl"><i class="fas fa-id-card"></i> NPM</div>
                                    <div class="pged-val">{{ $pengembalian->peminjaman->npm }}</div>
                                </div>
                            </div>

                            <div class="pged-row">
                                <div class="pged-item">
                                    <div class="pged-lbl"><i class="fas fa-box-open"></i> Nama Barang</div>
                                    <div class="pged-val">
                                        <span class="pged-badge-purple">{{ $pengembalian->peminjaman->barang->nama_barang }}</span>
                                    </div>
                                </div>
                                <div class="pged-item">
                                    <div class="pged-lbl"><i class="fas fa-hashtag"></i> Jumlah Total</div>
                                    <div class="pged-val">
                                        <span class="pged-badge-num">{{ $pengembalian->peminjaman->jumlah }}</span>
                                        <span class="pged-unit">unit</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- FORM EDITABLE --}}
                        <div class="pged-section">
                            <div class="pged-stitle">
                                <i class="fas fa-pen-square"></i>
                                Data yang Dapat Diedit
                            </div>

                            <div class="pged-row">
                                <div class="pged-form-group">
                                    <label class="pged-label">
                                        <i class="fas fa-calendar-day"></i>
                                        Tanggal Kembali Aktual <span class="pged-req">*</span>
                                    </label>
                                    <div class="pged-input-wrap">
                                        <i class="fas fa-calendar-day pged-icon"></i>
                                        <input type="date" name="tgl_kembali_real"
                                            class="pged-input @error('tgl_kembali_real') is-invalid @enderror"
                                            value="{{ old('tgl_kembali_real', \Carbon\Carbon::parse($pengembalian->tgl_kembali_real)->format('Y-m-d')) }}"
                                            required>
                                    </div>
                                    @error('tgl_kembali_real')
                                        <div class="pged-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="pged-form-group">
                                    <label class="pged-label">
                                        &nbsp;
                                        Catatan <span class="pged-opt">(opsional)</span>
                                    </label>
                                    <textarea name="catatan" class="pged-textarea @error('catatan') is-invalid @enderror" rows="3"
                                        placeholder="Tambahkan catatan kondisi barang...">{{ old('catatan', $pengembalian->catatan) }}</textarea>
                                    @error('catatan')
                                        <div class="pged-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- KONDISI BARANG --}}
                        <div class="pged-section" style="margin-bottom:0;">
                            <div class="pged-stitle">
                                <i class="fas fa-clipboard-check"></i>
                                Kondisi Barang yang Dikembalikan
                            </div>

                            <div class="pged-row">
                                {{-- Baik --}}
                                <div class="pged-form-group">
                                    <label class="pged-label">
                                        <i class="fas fa-check-circle" style="color:#10b981;"></i>
                                        Kondisi Baik <span class="pged-req">*</span>
                                    </label>
                                    <div class="pged-input-wrap">
                                        <i class="fas fa-hashtag pged-icon"></i>
                                        <input type="number" name="kondisi[baik]" id="jml_baik"
                                            class="pged-input" min="0" value="{{ old('kondisi.baik', $baik) }}" required>
                                    </div>
                                    <div class="pged-help">Barang dalam kondisi sempurna</div>
                                </div>

                                {{-- Perlu Perbaikan --}}
                                <div class="pged-form-group">
                                    <label class="pged-label">
                                        <i class="fas fa-tools" style="color:#f59e0b;"></i>
                                        Perlu Perbaikan <span class="pged-req">*</span>
                                    </label>
                                    <div class="pged-input-wrap">
                                        <i class="fas fa-hashtag pged-icon"></i>
                                        <input type="number" name="kondisi[perlu_perbaikan]" id="jml_perlu"
                                            class="pged-input" min="0" value="{{ old('kondisi.perlu_perbaikan', $perlu) }}" required>
                                    </div>
                                    <div class="pged-help">Barang butuh perbaikan ringan</div>
                                </div>

                                {{-- Rusak --}}
                                <div class="pged-form-group">
                                    <label class="pged-label">
                                        <i class="fas fa-times-circle" style="color:#ef4444;"></i>
                                        Rusak <span class="pged-req">*</span>
                                    </label>
                                    <div class="pged-input-wrap">
                                        <i class="fas fa-hashtag pged-icon"></i>
                                        <input type="number" name="kondisi[rusak]" id="jml_rusak"
                                            class="pged-input" min="0" value="{{ old('kondisi.rusak', $rusak) }}" required>
                                    </div>
                                    <div class="pged-help">Barang rusak/tidak berfungsi</div>
                                </div>
                            </div>

                            {{-- Counter --}}
                            <div class="pged-counter">
                                <div class="pged-counter-left">
                                    <div class="pged-counter-label">Total Kondisi</div>
                                    <div class="pged-counter-val">
                                        <span id="total-edit">{{ $baik + $rusak + $perlu }}</span>
                                        <span class="pged-slash">/</span>
                                        <span>{{ $pengembalian->peminjaman->jumlah }}</span>
                                    </div>
                                </div>
                                <div class="pged-status" id="status-edit">
                                    <i class="fas fa-exclamation-circle"></i> Checking...
                                </div>
                            </div>
                            @error('kondisi')
                                <div class="pged-error mt-2"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ACTIONS --}}
                        <div class="pged-actions">
                            <a href="{{ route('petugas.pengembalian.index') }}" class="pged-btn-back">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <div class="d-flex gap-3">
                                <button type="reset" class="pged-btn-reset" onclick="location.reload()">
                                    <i class="fas fa-redo ma"></i> Reset
                                </button>
                                &nbsp; &nbsp;
                                <button type="submit" class="pged-btn-save" id="btnSave">
                                    <i class="fas fa-save"></i> Simpan Perubahan
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
    --pged-p:#667eea; --pged-p-dark:#5568d3; --pged-p-end:#764ba2;
    --pged-g50:#fafafa; --pged-g100:#f3f4f6; --pged-g200:#e5e7eb;
    --pged-g300:#d1d5db; --pged-g400:#9ca3af; --pged-g500:#6b7280;
    --pged-g700:#374151; --pged-g800:#1f2937; --pged-g900:#111827;
}

.pged-card {
    border:none; border-radius:16px;
    box-shadow:0 2px 8px rgba(0,0,0,0.05), 0 1px 3px rgba(0,0,0,0.06);
    animation:pgedUp 0.4s ease;
}

/* Header */
.pged-header {
    display:flex; justify-content:space-between; align-items:flex-start;
    padding-bottom:28px; border-bottom:2px solid var(--pged-g100); margin-bottom:40px;
}
.pged-title { font-size:26px; font-weight:700; letter-spacing:-0.5px; color:var(--pged-g900); margin:0 0 6px; }
.pged-subtitle { font-size:14px; color:var(--pged-g500); margin:0; }
.pged-badge {
    display:inline-flex; align-items:center; gap:8px;
    padding:11px 22px; border-radius:12px;
    background:linear-gradient(135deg,var(--pged-p),var(--pged-p-end));
    color:#fff; font-size:14px; font-weight:700;
    box-shadow:0 4px 12px rgba(102,126,234,0.25);
}

/* Section */
.pged-section { margin-bottom:44px; }
.pged-stitle {
    display:flex; align-items:center; gap:10px;
    font-size:16px; font-weight:700; color:var(--pged-g800);
    margin-bottom:20px; padding-bottom:13px;
    border-bottom:2px solid var(--pged-g100);
}
.pged-stitle i { color:var(--pged-p); font-size:17px; }

/* Row */
.pged-row {
    display:flex; gap:24px; margin-bottom:20px; align-items:stretch;
}
.pged-row:last-child { margin-bottom:0; }

/* Item (readonly) */
.pged-item {
    flex:1 1 0; min-width:0;
    background:var(--pged-g50);
    border:1.5px solid var(--pged-g200);
    border-radius:12px; padding:20px 24px;
    min-height:86px;
    display:flex; flex-direction:column; justify-content:center;
}
.pged-lbl {
    display:flex; align-items:center; gap:7px;
    font-size:11px; font-weight:700; color:var(--pged-g400);
    text-transform:uppercase; letter-spacing:0.6px; margin-bottom:10px;
}
.pged-lbl i { font-size:11px; }
.pged-val {
    font-size:15px; font-weight:600; color:var(--pged-g900);
    display:flex; align-items:center; gap:8px;
}
.pged-badge-purple {
    display:inline-block; padding:6px 14px;
    background:linear-gradient(135deg,var(--pged-p),var(--pged-p-end));
    color:#fff; border-radius:8px; font-size:13px; font-weight:600;
}
.pged-badge-num {
    display:inline-flex; min-width:50px; padding:7px 14px;
    background:linear-gradient(135deg,var(--pged-p),var(--pged-p-end));
    color:#fff; border-radius:10px; font-size:18px; font-weight:700;
    font-family:"SF Mono",Monaco,Consolas,monospace;
    box-shadow:0 4px 12px rgba(102,126,234,0.25);
}
.pged-unit { font-size:13px; color:var(--pged-g500); }

/* Form Group */
.pged-form-group {
    flex:1 1 0; min-width:0;
    display:flex; flex-direction:column; gap:8px;
}
.pged-label {
    display:flex; align-items:center; gap:8px;
    font-size:14px; font-weight:600; color:var(--pged-g700);
}
.pged-label i { font-size:14px; }
.pged-req { color:#ef4444; }
.pged-opt { color:var(--pged-g400); font-size:12px; font-weight:400; }

.pged-input-wrap { position:relative; }
.pged-icon {
    position:absolute; top:50%; left:16px; transform:translateY(-50%);
    color:var(--pged-g400); font-size:14px; pointer-events:none;
}

.pged-input, .pged-textarea {
    width:100%; padding:13px 16px 13px 44px;
    border:1.5px solid var(--pged-g200); border-radius:12px; background:#fff;
    font-size:14px; color:var(--pged-g700);
    transition:all 0.25s ease;
}
.pged-input:hover, .pged-textarea:hover { border-color:var(--pged-g300); }
.pged-input:focus, .pged-textarea:focus {
    outline:none; border-color:var(--pged-p);
    box-shadow:0 0 0 4px rgba(102,126,234,0.1);
}
.pged-textarea {
    padding:14px 16px; resize:vertical; min-height:90px; line-height:1.6;
}

.pged-help {
    font-size:12px; color:var(--pged-g400); font-weight:500; margin-top:-2px;
}

.pged-error {
    display:flex; align-items:center; gap:6px;
    margin-top:10px; padding:10px 16px;
    background:#fef2f2; border-left:3px solid #ef4444; border-radius:8px;
    color:#dc2626; font-size:13px; font-weight:600;
}

/* Counter */
.pged-counter {
    background:linear-gradient(135deg,var(--pged-g50),#f1f5f9);
    border:2px solid #cbd5e1; border-radius:16px; padding:24px;
    display:flex; justify-content:space-between; align-items:center;
    margin-top:20px;
}
.pged-counter-left { display:flex; align-items:center; gap:20px; }
.pged-counter-label {
    font-size:14px; font-weight:600; color:var(--pged-g500);
    text-transform:uppercase; letter-spacing:0.5px;
}
.pged-counter-val {
    font-size:32px; font-weight:800; color:var(--pged-g900);
    font-family:"SF Mono",Monaco,Consolas,monospace;
}
.pged-counter-val #total-edit { color:var(--pged-p); }
.pged-slash { color:var(--pged-g300); margin:0 8px; }

.pged-status {
    display:flex; align-items:center; gap:8px;
    padding:12px 20px; border-radius:10px;
    font-size:14px; font-weight:700;
    background:#fef3c7; color:#d97706;
}
.pged-status.valid { background:#d1fae5; color:#059669; }
.pged-status.invalid { background:#fee2e2; color:#dc2626; }

/* Actions */
.pged-actions {
    display:flex; gap:12px; justify-content:space-between; align-items:center;
    margin-top:44px; padding-top:28px; border-top:2px solid var(--pged-g100);
}
.pged-btn-back {
    display:inline-flex; align-items:center; gap:8px;
    padding:12px 24px; background:#fff; color:var(--pged-g700);
    border:1.5px solid var(--pged-g300); border-radius:10px;
    font-size:14px; font-weight:600; text-decoration:none;
    transition:all 0.25s ease;
}
.pged-btn-back:hover {
    color:var(--pged-g900); border-color:var(--pged-g400); background:var(--pged-g50);
    transform:translateX(-2px); box-shadow:0 4px 12px rgba(0,0,0,0.1);
}
.pged-btn-reset {
    display:inline-flex; align-items:center; gap:8px;
    padding:12px 22px; background:#fff; color:var(--pged-g700);
    border:1.5px solid var(--pged-g300); border-radius:10px;
    font-size:14px; font-weight:600; cursor:pointer;
    transition:all 0.25s ease;
}
.pged-btn-reset:hover {
    background:var(--pged-g50); color:var(--pged-g900); border-color:var(--pged-g400);
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
}
.pged-btn-save {
    display:inline-flex; align-items:center; gap:8px;
    padding:12px 28px;
    background:linear-gradient(135deg,var(--pged-p),var(--pged-p-end));
    color:#fff; border:none; border-radius:10px;
    font-size:14px; font-weight:600; cursor:pointer;
    transition:all 0.25s ease;
    box-shadow:0 4px 12px rgba(102,126,234,0.3);
}
.pged-btn-save:hover {
    background:linear-gradient(135deg,var(--pged-p-dark),#6b3fa0);
    transform:translateY(-2px); box-shadow:0 8px 20px rgba(102,126,234,0.4);
}

@keyframes pgedUp {
    from { opacity:0; transform:translateY(16px); }
    to   { opacity:1; transform:translateY(0); }
}

@media (max-width:768px) {
    .pged-header { flex-direction:column; gap:16px; }
    .pged-title { font-size:20px; }
    .pged-row { flex-direction:column; gap:14px; }
    .pged-counter { flex-direction:column; gap:16px; }
    .pged-actions { flex-direction:column; }
    .pged-btn-back, .pged-btn-reset, .pged-btn-save { width:100%; justify-content:center; }
    .d-flex.gap-3 { width:100%; flex-direction:column; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const maxJumlah = {{ $pengembalian->peminjaman->jumlah }};
    const inputBaik = document.getElementById('jml_baik');
    const inputPerlu = document.getElementById('jml_perlu');
    const inputRusak = document.getElementById('jml_rusak');
    const totalEl = document.getElementById('total-edit');
    const statusEl = document.getElementById('status-edit');
    const btnSave = document.getElementById('btnSave');

    function updateTotal() {
        let total = parseInt(inputBaik.value||0) + parseInt(inputPerlu.value||0) + parseInt(inputRusak.value||0);
        totalEl.textContent = total;

        if (total === maxJumlah) {
            statusEl.className = 'pged-status valid';
            statusEl.innerHTML = '<i class="fas fa-check-circle"></i> Valid! Jumlah sesuai';
            btnSave.disabled = false;
        } else if (total > maxJumlah) {
            statusEl.className = 'pged-status invalid';
            statusEl.innerHTML = '<i class="fas fa-times-circle"></i> Jumlah melebihi!';
            btnSave.disabled = true;
        } else {
            statusEl.className = 'pged-status invalid';
            statusEl.innerHTML = '<i class="fas fa-exclamation-circle"></i> Jumlah kurang!';
            btnSave.disabled = true;
        }
    }

    inputBaik.addEventListener('input', updateTotal);
    inputPerlu.addEventListener('input', updateTotal);
    inputRusak.addEventListener('input', updateTotal);

    document.getElementById('formEdit').addEventListener('submit', function(e) {
        let total = parseInt(inputBaik.value||0) + parseInt(inputPerlu.value||0) + parseInt(inputRusak.value||0);
        if (total !== maxJumlah) {
            e.preventDefault();
            alert('Total kondisi harus sama dengan jumlah yang dipinjam (' + maxJumlah + ')!');
            return false;
        }
    });

    updateTotal();
});
</script>

@endsection
