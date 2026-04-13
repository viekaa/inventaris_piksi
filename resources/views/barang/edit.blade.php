@extends('layouts.backend')
@section('title','Edit Barang')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">

            <div class="card edit-card">
                <div class="card-body p-4">

                    {{-- ===== HEADER ===== --}}
                    <div class="detail-header">
                        <div>
                            <h4 class="detail-title">Edit Barang</h4>
                            <p class="detail-subtitle">Perbarui informasi barang yang sudah ada</p>
                        </div>
                        <span class="mode-badge">
                            <i class="fas fa-edit"></i>
                            Mode Edit
                        </span>
                    </div>

                    <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- ===== INFORMASI BARANG ===== --}}
                        <div class="section-label">
                            <span class="section-icon" style="background:#ebf0fd;">
                                <i class="fas fa-box" style="color:#3b5de7;"></i>
                            </span>
                            Informasi Barang
                        </div>

                        <div class="form-grid mb-3">

                            {{-- Nama Barang --}}
                            <div class="form-group-custom">
                                <label class="form-label-custom">
                                    <i class="fas fa-box"></i> Nama Barang <span class="required">*</span>
                                </label>
                                <div class="input-wrap">
                                    <i class="fas fa-box input-icon"></i>
                                    <input type="text"
                                           name="nama_barang"
                                           class="inp-custom @error('nama_barang') is-invalid @enderror"
                                           value="{{ old('nama_barang', $barang->nama_barang) }}"
                                           placeholder="Masukkan nama barang"
                                           required>
                                </div>
                                @error('nama_barang')
                                    <div class="error-msg">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kategori --}}
                            <div class="form-group-custom">
                                <label class="form-label-custom">
                                    <i class="fas fa-tags"></i> Kategori <span class="required">*</span>
                                </label>
                                <div class="input-wrap">
                                    <i class="fas fa-tags input-icon"></i>
                                    <select name="kategori_id"
                                            class="inp-custom @error('kategori_id') is-invalid @enderror"
                                            required>
                                        @foreach($kategori as $k)
                                            <option value="{{ $k->id }}" {{ old('kategori_id', $barang->kategori_id) == $k->id ? 'selected' : '' }}>
                                                {{ $k->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('kategori_id')
                                    <div class="error-msg">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Lokasi --}}
                            <div class="form-group-custom">
                                <label class="form-label-custom">
                                    <i class="fas fa-map-marker-alt"></i> Lokasi <span class="required">*</span>
                                </label>
                                <div class="input-wrap">
                                    <i class="fas fa-map-marker-alt input-icon"></i>
                                    <select name="lokasi_id"
                                            class="inp-custom @error('lokasi_id') is-invalid @enderror"
                                            required>
                                        @foreach($lokasi as $l)
                                            <option value="{{ $l->id }}" {{ old('lokasi_id', $barang->lokasi_id) == $l->id ? 'selected' : '' }}>
                                                {{ $l->nama_lokasi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('lokasi_id')
                                    <div class="error-msg">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Bidang (admin = select, lainnya = readonly) --}}
                            @if(auth()->user()->role == 'admin')
                                <div class="form-group-custom">
                                    <label class="form-label-custom">
                                        <i class="fas fa-building"></i> Bidang <span class="required">*</span>
                                    </label>
                                    <div class="input-wrap">
                                        <i class="fas fa-building input-icon"></i>
                                        <select name="bidang_id"
                                                class="inp-custom @error('bidang_id') is-invalid @enderror"
                                                required>
                                            @foreach($bidang as $b)
                                                <option value="{{ $b->id }}" {{ old('bidang_id', $barang->bidang_id) == $b->id ? 'selected' : '' }}>
                                                    {{ $b->nama_bidang }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('bidang_id')
                                        <div class="error-msg">{{ $message }}</div>
                                    @enderror
                                </div>
                            @else
                                <div class="form-group-custom">
                                    <label class="form-label-custom">
                                        <i class="fas fa-building"></i> Bidang
                                        <span class="badge-locked">Terkunci</span>
                                    </label>
                                    <div class="input-wrap">
                                        <i class="fas fa-building input-icon"></i>
                                        <input type="text"
                                               class="inp-custom inp-readonly"
                                               value="{{ $barang->bidang->nama_bidang }}"
                                               readonly>
                                    </div>
                                </div>
                            @endif

                        </div>

                        <div class="section-divider"></div>

                        {{-- ===== STOK & KONDISI ===== --}}
                        <div class="section-label">
                            <span class="section-icon" style="background:#f0ebfd;">
                                <i class="fas fa-cubes" style="color:#764ba2;"></i>
                            </span>
                            Stok & Kondisi
                        </div>

                        <div class="form-grid mb-3">

                            {{-- Jumlah Total --}}
                            <div class="form-group-custom">
                                <label class="form-label-custom">
                                    <i class="fas fa-hashtag"></i> Jumlah Total <span class="required">*</span>
                                </label>
                                <div class="input-wrap">
                                    <i class="fas fa-hashtag input-icon"></i>
                                    <input type="number"
                                           name="jumlah_total"
                                           class="inp-custom @error('jumlah_total') is-invalid @enderror"
                                           value="{{ old('jumlah_total', $barang->jumlah_total) }}"
                                           min="0"
                                           required>
                                </div>
                                @error('jumlah_total')
                                    <div class="error-msg">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Stok --}}
                            <div class="form-group-custom">
                                <label class="form-label-custom">
                                    <i class="fas fa-layer-group"></i> Stok <span class="required">*</span>
                                </label>
                                <div class="input-wrap">
                                    <i class="fas fa-layer-group input-icon"></i>
                                    <input type="number"
                                           name="stok"
                                           class="inp-custom @error('stok') is-invalid @enderror"
                                           value="{{ old('stok', $barang->stok) }}"
                                           min="0"
                                           required>
                                </div>
                                @error('stok')
                                    <div class="error-msg">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kondisi --}}
                            <div class="form-group-custom" style="grid-column: 1 / -1;">
                                <label class="form-label-custom">
                                    <i class="fas fa-check-circle"></i> Kondisi <span class="required">*</span>
                                </label>
                                <div class="kondisi-options">
                                    <label class="kondisi-radio {{ old('kondisi', $barang->kondisi) == 'baik' ? 'active-baik' : '' }}">
                                        <input type="radio" name="kondisi" value="baik" {{ old('kondisi', $barang->kondisi) == 'baik' ? 'checked' : '' }}>
                                        <i class="fas fa-check-circle"></i>
                                        <span>Baik</span>
                                    </label>
                                    <label class="kondisi-radio {{ old('kondisi', $barang->kondisi) == 'perlu_perbaikan' ? 'active-perbaikan' : '' }}">
                                        <input type="radio" name="kondisi" value="perlu_perbaikan" {{ old('kondisi', $barang->kondisi) == 'perlu_perbaikan' ? 'checked' : '' }}>
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span>Perlu Perbaikan</span>
                                    </label>
                                    <label class="kondisi-radio {{ old('kondisi', $barang->kondisi) == 'rusak' ? 'active-rusak' : '' }}">
                                        <input type="radio" name="kondisi" value="rusak" {{ old('kondisi', $barang->kondisi) == 'rusak' ? 'checked' : '' }}>
                                        <i class="fas fa-times-circle"></i>
                                        <span>Rusak</span>
                                    </label>
                                </div>
                                @error('kondisi')
                                    <div class="error-msg">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="section-divider"></div>

                        {{-- ===== FOTO BARANG ===== --}}
                        <div class="section-label">
                            <span class="section-icon" style="background:#fff8e1;">
                                <i class="fas fa-image" style="color:#f59e0b;"></i>
                            </span>
                            Foto Barang
                        </div>

                        <div class="foto-wrap mb-4">
                            <div class="preview-box" id="previewBox">
                                @if($barang->foto)
                                    <img id="preview-image" src="{{ asset('storage/' . $barang->foto) }}" alt="Preview">
                                @else
                                    <i class="fas fa-camera" id="preview-icon"></i>
                                    <img id="preview-image" src="#" alt="Preview" style="display:none;">
                                @endif
                            </div>
                            <div class="foto-input-area">
                                <div class="input-wrap">
                                    <i class="fas fa-upload input-icon"></i>
                                    <input type="file"
                                           name="foto"
                                           id="fotoInput"
                                           class="inp-custom @error('foto') is-invalid @enderror"
                                           accept="image/*">
                                </div>
                                <span class="inp-hint">Biarkan kosong jika tidak ingin mengubah foto. Format: JPG, PNG, maks 2MB.</span>
                            </div>
                        </div>

                        {{-- Alert --}}
                        <div class="alert-info-box">
                            <i class="fas fa-info-circle"></i>
                            <div><strong>Perhatian:</strong> Pastikan semua data yang diubah sudah benar sebelum menyimpan perubahan.</div>
                        </div>

                        {{-- ===== ACTIONS ===== --}}
                        <div class="form-actions">
                            <a href="{{ route('barang.index') }}" class="btn-back">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <div class="right-btns">
                                <button type="reset" class="btn-reset" id="resetBtn">
                                    <i class="fas fa-redo"></i> Reset
                                </button>
                                <button type="submit" class="btn-submit">
                                    <i class="fas fa-save"></i> Update Barang
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
/* =====================
   FONT & BASE
   ===================== */
.edit-card,
.edit-card * {
    font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
}

/* =====================
   CARD
   ===================== */
.edit-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 2px 16px rgba(0,0,0,0.07);
    overflow: hidden;
}

/* =====================
   HEADER
   ===================== */
.detail-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding-bottom: 22px;
    border-bottom: 1.5px solid #f0f2f7;
    margin-bottom: 28px;
}
.detail-title {
    font-size: 18px;
    font-weight: 700;
    color: #1a1d2e;
    margin: 0 0 4px;
}
.detail-subtitle {
    font-size: 13px;
    color: #8a92a6;
    margin: 0;
}
.mode-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #ebf0fd;
    color: #3b5de7;
    border: 1px solid #c5d0f8;
    padding: 7px 16px;
    border-radius: 24px;
    font-size: 13px;
    font-weight: 600;
}

/* =====================
   SECTION LABEL
   ===================== */
.section-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    font-weight: 700;
    color: #4a5568;
    text-transform: uppercase;
    letter-spacing: .6px;
    margin-bottom: 16px;
}
.section-icon {
    width: 28px;
    height: 28px;
    border-radius: 7px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 14px;
}
.section-divider {
    height: 1.5px;
    background: #f0f2f7;
    margin: 22px 0;
}

/* =====================
   FORM GRID
   ===================== */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
.form-group-custom {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.form-label-custom {
    font-size: 11px;
    font-weight: 700;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: .5px;
    display: flex;
    align-items: center;
    gap: 5px;
    margin-bottom: 0;
}
.form-label-custom i {
    color: #9aa0b4;
    font-size: 11px;
}
.required {
    color: #e53e3e;
    font-size: 13px;
}
.badge-locked {
    background: #f3f4f6;
    color: #9aa0b4;
    border: 1px solid #e2e4ea;
    padding: 1px 8px;
    border-radius: 10px;
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .3px;
}

/* =====================
   INPUT
   ===================== */
.input-wrap {
    position: relative;
}
.input-icon {
    position: absolute;
    left: 13px;
    top: 50%;
    transform: translateY(-50%);
    color: #9aa0b4;
    font-size: 13px;
    pointer-events: none;
    z-index: 1;
}
.inp-custom {
    width: 100%;
    padding: 10px 13px 10px 38px;
    font-size: 14px;
    font-family: 'Segoe UI', sans-serif;
    font-weight: 500;
    color: #1a1d2e;
    background: #f7f8fc;
    border: 1.5px solid #ebedf5;
    border-radius: 10px;
    outline: none;
    transition: border .15s, background .15s, box-shadow .15s;
    appearance: none;
}
.inp-custom:focus {
    border-color: #667eea;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(102,126,234,0.12);
}
.inp-custom.is-invalid {
    border-color: #e53e3e;
    background: #fff5f5;
}
.inp-readonly {
    background: #f0f2f7 !important;
    color: #9aa0b4 !important;
    cursor: not-allowed;
}
.error-msg {
    font-size: 12px;
    color: #e53e3e;
    margin-top: 2px;
    display: flex;
    align-items: center;
    gap: 4px;
}

/* =====================
   KONDISI RADIO
   ===================== */
.kondisi-options {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}
.kondisi-radio {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    border-radius: 10px;
    border: 1.5px solid #ebedf5;
    background: #f7f8fc;
    cursor: pointer;
    font-size: 13px;
    font-weight: 600;
    color: #6b7280;
    transition: all .15s;
    user-select: none;
}
.kondisi-radio input[type="radio"] {
    display: none;
}
.kondisi-radio:hover {
    border-color: #c5d0f8;
    background: #ebf0fd;
    color: #3b5de7;
}
.kondisi-radio.active-baik,
.kondisi-radio:has(input:checked[value="baik"]) {
    background: #edf7f0;
    border-color: #b8e6c8;
    color: #1e7e3e;
}
.kondisi-radio:has(input:checked[value="perlu_perbaikan"]) {
    background: #fff8e1;
    border-color: #ffe082;
    color: #e65100;
}
.kondisi-radio:has(input:checked[value="rusak"]) {
    background: #fdecea;
    border-color: #f5a8a8;
    color: #c62828;
}

/* =====================
   FOTO
   ===================== */
.foto-wrap {
    display: flex;
    align-items: center;
    gap: 16px;
}
.preview-box {
    width: 80px;
    height: 80px;
    border-radius: 12px;
    border: 2px dashed #d1d5db;
    background: #f7f8fc;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    flex-shrink: 0;
    color: #b0b8cc;
    font-size: 24px;
}
.preview-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.foto-input-area {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.inp-hint {
    font-size: 11px;
    color: #9aa0b4;
}

/* =====================
   ALERT
   ===================== */
.alert-info-box {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    background: #ebf0fd;
    border: 1.5px solid #c5d0f8;
    border-radius: 12px;
    padding: 14px 18px;
    font-size: 13px;
    color: #3b5de7;
    margin-bottom: 24px;
}
.alert-info-box i {
    flex-shrink: 0;
    margin-top: 1px;
    font-size: 15px;
}
.alert-info-box strong {
    color: #1e40af;
}

/* =====================
   ACTIONS
   ===================== */
.form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 22px;
    border-top: 1.5px solid #f0f2f7;
}
.btn-back {
    font-size: 13px;
    font-weight: 600;
    color: #6b7280;
    border: 1.5px solid #dde0ea;
    border-radius: 10px;
    padding: 9px 20px;
    background: #fff;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    transition: background .15s;
}
.btn-back:hover { background: #f7f8fc; color: #374151; }
.right-btns {
    display: flex;
    gap: 10px;
}
.btn-reset {
    font-size: 13px;
    font-weight: 600;
    color: #6b7280;
    border: 1.5px solid #dde0ea;
    border-radius: 10px;
    padding: 9px 18px;
    background: #fff;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    transition: background .15s;
}
.btn-reset:hover { background: #f7f8fc; }
.btn-submit {
    font-size: 13px;
    font-weight: 600;
    color: #fff;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border: none;
    border-radius: 10px;
    padding: 10px 24px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    box-shadow: 0 4px 14px rgba(102,126,234,0.35);
    transition: opacity .15s;
}
.btn-submit:hover { opacity: .9; }

/* =====================
   RESPONSIVE
   ===================== */
@media (max-width: 768px) {
    .form-grid { grid-template-columns: 1fr; }
    .kondisi-options { flex-direction: column; }
    .detail-header { flex-direction: column; gap: 14px; }
    .form-actions { flex-direction: column; gap: 12px; align-items: stretch; }
    .right-btns { justify-content: flex-end; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const fotoInput    = document.getElementById('fotoInput');
    const previewImage = document.getElementById('preview-image');
    const previewIcon  = document.getElementById('preview-icon');
    const resetBtn     = document.getElementById('resetBtn');

    // Simpan state foto lama untuk reset
    const oldSrc      = previewImage ? previewImage.getAttribute('src') : '#';
    const hadOldPhoto = previewImage && previewImage.style.display !== 'none' && oldSrc !== '#';

    // Preview saat pilih file baru
    if (fotoInput) {
        fotoInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block';
                    if (previewIcon) previewIcon.style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Reset foto ke foto lama
    if (resetBtn) {
        resetBtn.addEventListener('click', function () {
            if (hadOldPhoto) {
                previewImage.src = oldSrc;
                previewImage.style.display = 'block';
                if (previewIcon) previewIcon.style.display = 'none';
            } else {
                if (previewImage) { previewImage.src = '#'; previewImage.style.display = 'none'; }
                if (previewIcon)  previewIcon.style.display = 'flex';
            }
        });
    }
});
</script>

@endsection
