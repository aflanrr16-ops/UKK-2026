@extends('layouts.app')

@section('title', config('app.name') . ' — Tambah Peminjaman')

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
                            <i class="bi bi-journal-plus fs-4"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1 text-white">Form. Peminjaman Alat</h4>
                            <p class="text-white-50 small mb-0">Silakan lengkapi data transaksi peminjaman inventaris sekolah</p>
                        </div>
                    </div>
                    <a href="{{ route('peminjaman.index') }}" class="btn btn-light btn-sm rounded-pill px-3 fw-semibold shadow-sm d-none d-md-inline-flex align-items-center gap-1 text-dark">
                        <i class="bi bi-arrow-left"><span>Kembali</span></i>
                    </a>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('peminjaman.store') }}" method="POST">
                        @csrf
                        
                        <div class="row g-4">
                            <!-- Kolom Kiri -->
                            <div class="col-md-6">
                                <!-- User / Peminjam -->
                                <div class="mb-3">
                                    <label for="id_user" class="form-label fw-semibold small text-body-emphasis">
                                        <i class="bi bi-person-fill text-purple me-1"></i> Pilih User / Peminjam
                                    </label>
                                    <select name="id_user" id="id_user" class="form-select rounded-3 shadow-none py-2 bg-light-subtle" required>
                                        <option value="">-- Pilih User --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->nama ?? $user->name ?? $user->username }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Pilih Alat -->
                                <div class="mb-3">
                                    <label for="id_alat" class="form-label fw-semibold small text-body-emphasis">
                                        <i class="bi bi-cpu-fill text-purple me-1"></i> Pilih Alat
                                    </label>
                                    <select name="id_alat" id="id_alat" class="form-select rounded-3 shadow-none py-2 bg-light-subtle" required>
                                        <option value="">-- Pilih Alat --</option>
                                        @foreach($alat as $item)
                                            <option value="{{ $item->id_alat }}">{{ $item->nama_alat ?? $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Jumlah Unit -->
                                <div class="mb-3">
                                    <label for="jumlah" class="form-label fw-semibold small text-body-emphasis">
                                        <i class="bi bi-123 text-purple me-1"></i> Jumlah Unit
                                    </label>
                                    <input type="number" name="jumlah" id="jumlah" class="form-control rounded-3 shadow-none py-2 bg-light-subtle" value="1" min="1" required>
                                </div>

                                <!-- Status -->
                                <div class="mb-3">
                                    <label for="status" class="form-label fw-semibold small text-body-emphasis">
                                        <i class="bi bi-shield-exclamation text-purple me-1"></i> Status Peminjaman
                                    </label>
                                    <select name="status" id="status" class="form-select rounded-3 shadow-none py-2 bg-light-subtle" required>
                                        <option value="Pending" selected>Pending</option>
                                        <option value="Disetujui">Disetujui</option>
                                        <option value="Ditolak">Ditolak</option>
                                        <option value="Dikembalikan">Dikembalikan</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-6">
                                <!-- Tanggal Pinjam -->
                                <div class="mb-3">
                                    <label for="tanggal_pinjam" class="form-label fw-semibold small text-body-emphasis">
                                        <i class="bi bi-calendar-event-fill text-purple me-1"></i> Tanggal Pinjam
                                    </label>
                                    <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" class="form-control rounded-3 shadow-none py-2 bg-light-subtle" required>
                                </div>

                                <!-- Tanggal Kembali -->
                                <div class="mb-3">
                                    <label for="tanggal_kembali" class="form-label fw-semibold small text-body-emphasis">
                                        <i class="bi bi-calendar-check-fill text-purple me-1"></i> Tanggal Kembali
                                    </label>
                                    <input type="date" name="tanggal_kembali" id="tanggal_kembali" class="form-control rounded-3 shadow-none py-2 bg-light-subtle" required>
                                </div>

                                <!-- Denda -->
                                <div class="mb-4">
                                    <label for="denda" class="form-label fw-semibold small text-body-emphasis">
                                        <i class="bi bi-cash-stack text-purple me-1"></i> Denda (Rp)
                                    </label>
                                    <input type="number" name="denda" id="denda" class="form-control rounded-3 shadow-none py-2 bg-light-subtle" value="0" min="0">
                                </div>

                                <!-- Info box catatan kecil -->
                                <div class="p-3 rounded-3 bg-purple-subtle border border-purple-subtle text-purple small mt-4">
                                    <i class="bi bi-info-circle-fill me-1"></i> Pastikan data peminjam dan alat yang dipilih sudah sesuai dengan fisik barang diinventaris.
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons di Bawah -->
                        <div class="d-flex justify-content-between align-items-center pt-4 mt-4 border-top gap-2">
                            <a href="{{ route('peminjaman.index') }}" class="btn btn-outline-secondary px-4 rounded-pill fw-medium small d-md-none">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="reset" class="btn btn-outline-danger px-3 rounded-pill fw-medium small">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Form
                            </button>
                            <button type="submit" class="btn btn-purple-fill px-5 py-2 rounded-pill fw-semibold shadow small text-white">
                                <i class="bi bi-check-lg me-1"></i> Simpan Peminjaman
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
