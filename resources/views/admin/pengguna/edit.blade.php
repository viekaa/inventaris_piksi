@extends('layouts.backend')
@section('title','Edit Pengguna')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 mx-auto">

            <div class="card custom-card-petugas">
                <div class="card-body p-4">

                    <!-- Header -->
                    <div class="form-header-petugas">
                        <div>
                            <h4 class="form-title-petugas">Edit Pengguna</h4>
                            <p class="form-subtitle-petugas">Perbarui informasi pengguna di bawah ini</p>
                        </div>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('admin.petugas.update', $petugas->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-content-petugas">

                            <!-- Nama -->
                            <div class="form-group-petugas">
                                <label class="form-label-petugas">
                                    <i class="fas fa-user"></i>
                                    Nama Lengkap
                                    <span class="required-petugas">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="name"
                                    class="form-control-petugas @error('name') is-invalid-petugas @enderror"
                                    placeholder="Masukkan nama lengkap"
                                    value="{{ old('name', $petugas->name) }}"
                                    required
                                >
                                @error('name')
                                    <div class="error-message-petugas">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="form-group-petugas">
                                <label class="form-label-petugas">
                                    <i class="fas fa-envelope"></i>
                                    Email
                                    <span class="required-petugas">*</span>
                                </label>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control-petugas @error('email') is-invalid-petugas @enderror"
                                    placeholder="contoh@email.com"
                                    value="{{ old('email', $petugas->email) }}"
                                    required
                                >
                                @error('email')
                                    <div class="error-message-petugas">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Bidang -->
                            <div class="form-group-petugas">
                                <label class="form-label-petugas">
                                    <i class="fas fa-building"></i>
                                    Bidang
                                    <span class="required-petugas">*</span>
                                </label>
                                <select
                                    name="bidang_id"
                                    class="form-control-petugas @error('bidang_id') is-invalid-petugas @enderror"
                                    required
                                >
                                    <option value="" disabled>-- Pilih Bidang --</option>
                                    @foreach ($bidang as $b)
                                        <option value="{{ $b->id }}"
                                            {{ old('bidang_id', $petugas->bidang_id) == $b->id ? 'selected' : '' }}>
                                            {{ $b->nama_bidang }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('bidang_id')
                                    <div class="error-message-petugas">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Info role (readonly) -->
                            <div class="form-group-petugas">
                                <label class="form-label-petugas">
                                    <i class="fas fa-id-badge"></i>
                                    Role
                                </label>
                                <input
                                    type="text"
                                    class="form-control-petugas"
                                    value="{{ ucfirst($petugas->role) }}"
                                    readonly
                                    style="background: #f3f4f6; cursor: not-allowed; color: #6b7280;"
                                >
                                <small class="form-hint-petugas">Role tidak dapat diubah melalui form ini</small>
                            </div>

                        </div>

                        <!-- Action Buttons -->
                        <div class="form-actions-petugas">
                            <a href="{{ route('admin.petugas.index') }}" class="btn-cancel-petugas">
                                <i class="fas fa-times"></i>
                                <span>Batal</span>
                            </a>
                            <button type="submit" class="btn-submit-petugas">
                                <i class="fas fa-save"></i>
                                <span>Update Pengguna</span>
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<style>
/* ===== VARIABLES PETUGAS ===== */
:root {
    --color-primary-petugas: #667eea;
    --color-primary-dark-petugas: #5568d3;
    --color-danger-petugas: #ef4444;
    --color-gray-50-petugas: #fafafa;
    --color-gray-100-petugas: #f3f4f6;
    --color-gray-200-petugas: #e5e7eb;
    --color-gray-300-petugas: #d1d5db;
    --color-gray-400-petugas: #9ca3af;
    --color-gray-500-petugas: #6b7280;
    --color-gray-700-petugas: #374151;
    --color-gray-900-petugas: #111827;
}

/* ===== CARD PETUGAS ===== */
.custom-card-petugas {
    border: none;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04), 0 1px 2px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    animation: slideUpPetugas 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

/* ===== FORM HEADER PETUGAS ===== */
.form-header-petugas {
    padding-bottom: 24px;
    border-bottom: 2px solid var(--color-gray-100-petugas);
    margin-bottom: 32px;
}

.form-title-petugas {
    font-size: 24px;
    font-weight: 700;
    letter-spacing: -0.5px;
    color: var(--color-gray-900-petugas);
    margin: 0 0 6px 0;
}

.form-subtitle-petugas {
    font-size: 14px;
    color: var(--color-gray-500-petugas);
    margin: 0;
    font-weight: 400;
}

/* ===== FORM CONTENT PETUGAS ===== */
.form-content-petugas {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0 32px;
    padding-top: 8px;
}

.form-group-petugas {
    margin-bottom: 28px;
}

.form-label-petugas {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 600;
    color: var(--color-gray-700-petugas);
    margin-bottom: 10px;
}

.form-label-petugas i {
    color: var(--color-primary-petugas);
    font-size: 15px;
}

.required-petugas {
    color: var(--color-danger-petugas);
    font-weight: 700;
}

.form-control-petugas {
    width: 100%;
    padding: 14px 18px;
    font-size: 15px;
    font-weight: 500;
    color: var(--color-gray-900-petugas);
    background: var(--color-gray-50-petugas);
    border: 1.5px solid var(--color-gray-200-petugas);
    border-radius: 10px;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    font-family: inherit;
    appearance: none;
    -webkit-appearance: none;
}

.form-control-petugas::placeholder { color: var(--color-gray-400-petugas); font-weight: 400; }

.form-control-petugas:focus {
    outline: none;
    background: #fff;
    border-color: var(--color-primary-petugas);
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-control-petugas.is-invalid-petugas {
    border-color: var(--color-danger-petugas);
    background: #fef2f2;
}

/* Select arrow */
select.form-control-petugas {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 16px center;
    padding-right: 44px;
}

.form-hint-petugas {
    display: block;
    margin-top: 8px;
    font-size: 13px;
    color: var(--color-gray-500-petugas);
    font-weight: 400;
}

.error-message-petugas {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 8px;
    padding: 10px 14px;
    background: #fef2f2;
    border-left: 3px solid var(--color-danger-petugas);
    border-radius: 8px;
    font-size: 13px;
    color: var(--color-danger-petugas);
    font-weight: 500;
}

/* ===== FORM ACTIONS PETUGAS ===== */
.form-actions-petugas {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    align-items: center;
    margin-top: 40px;
    padding-top: 24px;
    border-top: 2px solid var(--color-gray-100-petugas);
}

.btn-cancel-petugas {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: #fff;
    color: var(--color-gray-700-petugas);
    border: 1.5px solid var(--color-gray-300-petugas);
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

.btn-cancel-petugas:hover {
    background: var(--color-gray-50-petugas);
    color: var(--color-gray-900-petugas);
    border-color: var(--color-gray-400-petugas);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    text-decoration: none;
}

.btn-submit-petugas {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 32px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    cursor: pointer;
}

.btn-submit-petugas:hover {
    background: linear-gradient(135deg, #5568d3 0%, #6b3fa0 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
}

.btn-submit-petugas:active { transform: translateY(0); }

/* ===== ANIMATIONS ===== */
@keyframes slideUpPetugas {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ===== RESPONSIVE PETUGAS ===== */
@media (max-width: 768px) {
    .form-content-petugas { grid-template-columns: 1fr; }
    .form-title-petugas { font-size: 20px; }
    .form-actions-petugas { flex-direction: column-reverse; gap: 12px; }
    .btn-cancel-petugas, .btn-submit-petugas { width: 100%; justify-content: center; }
}
</style>

@endsection
