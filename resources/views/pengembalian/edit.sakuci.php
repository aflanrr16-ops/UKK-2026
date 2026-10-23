@extends('layouts.app')

@section('title', config('app.name') . ' — Edit Pengembalian')

@section('content')
<div class="container-fluid py-4 px-3 px-md-4">
    
    <div class="row justify-content-center">
        <div class="col-xl-9 col-lg-10">
            
            <!-- Card Pembungkus Form dengan Gaya Modern Two-Column Layout -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-body">
                
                <!-- Header Card Bergaya Modern Banner Ungu Lembut -->
                <div class="card-header border-0 py-4 px-4 px-md-5 d-flex align-items-center justify-content-between header-gradient-modern">
                    <div class="d-flex align-items-center gap-3">
                        <div class="header-icon-wrapper rounded-3 d-flex align-items-center justify-content-center text-white shadow-sm" style="width: 48px; height: 48px; background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);">
                            <i class="bi bi-pencil-square fs-4"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1 text-white">Edit Data Pengembalian</h4>
                            <p class="text-white-50 small mb-0">Perbarui informasi pengembalian alat dan denda di dalam sistem</p>
                        </div>
                    </div>
                    <a href="{{ route('pengembalian.index') }}" class="btn btn-light btn-sm rounded-pill px-3 fw-semibold shadow-sm d-none d-md-inline-flex align-items-center gap-1 text-dark">
                        <i class="bi bi-arrow-left"><span>Kembali</span></i>
                    </a>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('pengembalian.update', [$datap->id_pengembalian]) }}" method="POST">
                        @csrf
                        @method('GET')
                        
                        <div class="row g-4">
                            <!-- Kolom Kiri -->
                            <div class="col-md-6">
                                <!-- Data Peminjaman (Locked) -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small text-body-emphasis">
                                        <i class="bi bi-receipt text-purple me-1"></i> Data Peminjaman
                                    </label>
                                    <input type="hidden" name="id_peminjaman" value="{{ $datap->id_peminjaman }}">
                                    <input type="text" class="form-control rounded-3 shadow-none py-2 bg-light-subtle opacity-75" 
                                           value="ID #{{ $datap->id_peminjaman }} - {{ $peminjamName }} ({{ $alatName }})" readonly disabled>
                                </div>

                                <!-- Tanggal Pengembalian -->
                                <div class="mb-3">
                                    <label for="tanggal_pengembalian" class="form-label fw-semibold small text-body-emphasis">
                                        <i class="bi bi-calendar-check-fill text-purple me-1"></i> Tanggal Pengembalian <span class="text-danger">*</span>
                                    </label>
                                    <input type="datetime-local" name="tanggal_pengembalian" id="tanggal_pengembalian" 
                                           class="form-control rounded-3 shadow-none py-2 bg-light-subtle" 
                                           value="{{ old('tanggal_pengembalian', date('Y-m-d\TH:i', strtotime($datap->tanggal_pengembalian))) }}" required>
                                </div>

                                <!-- Terlambat (Hari) -->
                                <div class="mb-3">
                                    <label for="terlambat_hari" class="form-label fw-semibold small text-body-emphasis">
                                        <i class="bi bi-clock-history text-purple me-1"></i> Terlambat (Hari)
                                    </label>
                                    <input type="number" min="0" name="terlambat_hari" id="terlambat_hari" 
                                           class="form-control rounded-3 shadow-none py-2 bg-light-subtle" 
                                           value="{{ old('terlambat_hari', $datap->terlambat_hari ?? 0) }}">
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-6">
                                <!-- Denda (Rp) -->
                                <div class="mb-3">
                                    <label for="denda" class="form-label fw-semibold small text-body-emphasis">
                                        <i class="bi bi-cash-stack text-purple me-1"></i> Denda (Rp)
                                    </label>
                                    <input type="number" min="0" name="denda" id="denda" 
                                           class="form-control rounded-3 shadow-none py-2 bg-light-subtle" 
                                           value="{{ old('denda', $datap->denda ?? 0) }}">
                                </div>

                                <!-- Kondisi Barang -->
                                <div class="mb-3">
                                    <label for="kondisi_barang" class="form-label fw-semibold small text-body-emphasis">
                                        <i class="bi bi-check-circle-fill text-purple me-1"></i> Kondisi Barang
                                    </label>
                                    <select name="kondisi_barang" id="kondisi_barang" class="form-select rounded-3 shadow-none py-2 bg-light-subtle">
                                        <option value="Baik" class="text-body" {{ old('kondisi_barang', $datap->kondisi_barang) == 'Baik' ? 'selected' : '' }}>Baik</option>
                                        <option value="Rusak Ringan" class="text-body" {{ old('kondisi_barang', $datap->kondisi_barang) == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                        <option value="Rusak Berat" class="text-body" {{ old('kondisi_barang', $datap->kondisi_barang) == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                                        <option value="Hilang" class="text-body" {{ old('kondisi_barang', $datap->kondisi_barang) == 'Hilang' ? 'selected' : '' }}>Hilang</option>
                                    </select>
                                </div>

                                <!-- Catatan Field -->
                                <div class="mb-3">
                                    <label for="catatan" class="form-label fw-semibold small text-body-emphasis">
                                        <i class="bi bi-card-text text-purple me-1"></i> Catatan
                                    </label>
                                    <textarea name="catatan" id="catatan" rows="3" 
                                              class="form-control rounded-3 shadow-none py-2 bg-light-subtle" 
                                              placeholder="Tambahkan catatan jika ada...">{{ old('catatan', $datap->catatan) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Info Box Catatan Kecil -->
                        <div class="p-3 rounded-3 bg-purple-subtle border border-purple-subtle text-purple small mt-3">
                            <i class="bi bi-info-circle-fill me-1"></i> Perbarui data pengembalian dengan teliti, termasuk status kondisi fisik barang dan rincian denda keterlambatan jika ada.
                        </div>

                        <!-- Action Buttons di Bawah -->
                        <div class="d-flex justify-content-between align-items-center pt-4 mt-4 border-top gap-2">
                            <a href="{{ route('pengembalian.index') }}" class="btn btn-outline-secondary px-4 rounded-pill fw-medium small d-md-none">
                                <i class="bi bi-arrow-left me-1"><span>Kembali</span></i>
                            </a>
                            <a href="{{ route('pengembalian.index') }}" class="btn btn-outline-secondary px-4 rounded-pill fw-medium small d-none d-md-inline-block">
                                <i class="bi bi-x-circle me-1"><span>Batal</span></i>
                            </a>
                            <button type="submit" class="btn btn-purple-fill px-5 py-2 rounded-pill fw-semibold shadow small text-white">
                                <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>

<!-- CSS Kustom Tambahan (Modern & Elegan Nuansa Ungu) -->
<style>
    .header-gradient-modern {
        background: linear-gradient(135deg, #4c1d95 0%, #6d28d9 50%, #7c3aed 100%) !important;
    }
    .text-purple {
        color: #a855f7 !important;
    }
    .btn-purple-fill {
        background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
        border: none;
        transition: all 0.2s ease;
    }
    .btn-purple-fill:hover {
        opacity: 0.95;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.35) !important;
        color: #ffffff;
    }
    .form-control:focus, .form-select:focus {
        border-color: #a855f7;
        background-color: var(--bs-body-bg) !important;
        box-shadow: 0 0 0 0.25rem rgba(168, 85, 247, 0.15);
    }
    .bg-purple-subtle {
        background-color: rgba(168, 85, 247, 0.08);
    }
    .border-purple-subtle {
        border-color: rgba(168, 85, 247, 0.2) !important;
    }
</style>
@endsection
