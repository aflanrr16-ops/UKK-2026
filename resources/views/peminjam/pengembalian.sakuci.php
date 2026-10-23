@extends('layouts.app')

@section('title', config('app.name') . ' — Kembalikan Alat')

@section('content')
<div class="container-fluid py-4 px-3 px-md-4">

    <div class="row justify-content-center">
        <div class="col-xl-9 col-lg-10">
            
            <!-- 1. BANNER HEADER RINGKAS (Hero Gradient Ungu + Lebar Sejajar Form) -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 text-white hero-banner-purple">
                <div class="hero-bg-shapes"></div>
                <div class="card-body p-4 p-md-4.5 position-relative z-2">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div>
                            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-white bg-opacity-10 border border-white border-opacity-20 backdrop-blur mb-2">
                                <span class="status-indicator"></span>
                                <span class="text-white fw-semibold fs-8 tracking-wider text-uppercase">
                                    <i class="bi bi-arrow-counterclockwise me-1 text-warning"></i> Form Pengembalian Alat
                                </span>
                            </div>
                            
                            <h3 class="fw-bold mb-1 text-white">Kembalikan Alat Sekolah</h3>
                            <p class="mb-0 text-white-50 fs-7" style="max-width: 600px;">
                                Silakan isi formulir di bawah ini untuk mengembalikan alat yang telah selesai Anda gunakan.
                            </p>
                        </div>
                        <div class="d-none d-md-block">
                            <div class="rounded-circle p-3 bg-white bg-opacity-10 border border-white border-opacity-20 backdrop-blur text-white d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                                <i class="bi bi-box-arrow-in-left fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. CARD FORMULIR PENGEMBALIAN -->
            <div class="card border-0 shadow-sm rounded-4 bg-body p-3 p-md-4 modern-form-card">
                <div class="card-body p-2 p-md-3">
                    
                    {{-- Jika tidak ada barang yang sedang dipinjam/disetujui --}}
                    @if(empty($peminjamanAktif) || count($peminjamanAktif) === 0)
                        <div class="alert border-0 shadow-sm rounded-3 d-flex align-items-center gap-3 p-3.5 mb-0" style="background: rgba(168, 85, 247, 0.1); border: 1px solid rgba(168, 85, 247, 0.2) !important;">
                            <div class="p-2 rounded-circle text-purple bg-white bg-opacity-50 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 42px; height: 42px;">
                                <i class="bi bi-info-circle-fill fs-5"></i>
                            </div>
                            <div class="fs-7 text-body-emphasis">
                                Kamu tidak memiliki alat yang berstatus <strong class="text-purple">Sedang Dipinjam</strong> saat ini. Pastikan pengajuan peminjamanmu sudah disetujui oleh petugas/admin.
                            </div>
                        </div>
                    @else
                        {{-- Form Pengembalian --}}
                        <form action="{{ route('peminjam.pengembalian.store') }}" method="POST">
                            @csrf
                            
                            <div class="row g-4 mb-4">
                                <!-- Pilih Alat -->
                                <div class="col-12">
                                    <label for="id_peminjaman" class="form-label fw-semibold fs-7 text-body-emphasis">Pilih Alat yang Ingin Dikembalikan <span class="text-danger">*</span></label>
                                    <select name="id_peminjaman" id="id_peminjaman" class="form-select form-select-lg fs-7 rounded-3 @error('id_peminjaman') is-invalid @enderror" required style="min-height: 48px;">
                                        <option value="">-- Pilih Alat dari Daftar Pinjaman --</option>
                                        @foreach($peminjamanAktif as $p)
                                            <option value="{{ $p->id_peminjaman ?? $p->id }}">
                                                📦 {{ $p->alat->nama_alat ?? ($p->alat->nama ?? ($p->nama_alat ?? 'Alat ID: ' . $p->id_alat)) }} (Status: {{ ucfirst($p->status) }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_peminjaman')
                                        <div class="invalid-feedback fs-8">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tanggal Pengembalian -->
                                <div class="col-12 col-md-6">
                                    <label for="tanggal_pengembalian" class="form-label fw-semibold fs-7 text-body-emphasis">Tanggal Pengembalian <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-body-tertiary border-end-0 rounded-start-3 text-secondary">
                                            <i class="bi bi-calendar-check"></i>
                                        </span>
                                        <input type="date" name="tanggal_pengembalian" id="tanggal_pengembalian" class="form-control form-control-lg fs-7 rounded-end-3 border-start-0" value="{{ date('Y-m-d') }}" required style="min-height: 48px;">
                                    </div>
                                </div>

                                <!-- Kondisi Barang -->
                                <div class="col-12 col-md-6">
                                    <label for="kondisi_barang" class="form-label fw-semibold fs-7 text-body-emphasis">Kondisi Barang Saat Dikembalikan <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-body-tertiary border-end-0 rounded-start-3 text-secondary">
                                            <i class="bi bi-shield-check"></i>
                                        </span>
                                        <select name="kondisi_barang" id="kondisi_barang" class="form-select form-select-lg fs-7 rounded-end-3 border-start-0" style="min-height: 48px;">
                                            <option value="Baik">Baik (Normal)</option>
                                            <option value="Ringan Rusak">Ada Kerusakan Ringan</option>
                                            <option value="Rusak">Rusak / Tidak Berfungsi</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Catatan Tambahan -->
                                <div class="col-12">
                                    <label for="catatan" class="form-label fw-semibold fs-7 text-body-emphasis">Catatan Tambahan <span class="text-secondary fw-normal fs-8">(Opsional)</span></label>
                                    <textarea name="catatan" id="catatan" rows="3" class="form-control fs-7 rounded-3" placeholder="Tuliskan keterangan kondisi barang atau keluhan jika ada..."></textarea>
                                </div>
                            </div>

                            <hr class="my-4 border-translucent">

                            <!-- Tombol Aksi -->
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <a href="{{ route('peminjam.dashboard') }}" class="btn btn-outline-secondary px-4 py-2.5 rounded-pill fw-semibold fs-7 d-inline-flex align-items-center gap-2">
                                    <i class="bi bi-arrow-left"></i>
                                    <span>Batal</span>
                                </a>
                                <button type="submit" class="btn btn-purple-gradient px-4 py-2.5 rounded-pill fw-semibold fs-7 shadow-sm d-inline-flex align-items-center gap-2">
                                    <i class="bi bi-send-fill"></i>
                                    <span>Kirim Pengembalian</span>
                                </button>
                            </div>
                        </form>
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>

<!-- 🎨 STYLING KUSTOM TEMA UNGU MODERN & ADAPTIF -->
<style>
    /* Banner Hero Ungu */
    .hero-banner-purple {
        background: linear-gradient(135deg, #4c1d95 0%, #6d28d9 50%, #7c3aed 100%) !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
    }

    .hero-bg-shapes {
        position: absolute;
        top: -50px;
        right: -50px;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(236, 72, 153, 0.25) 0%, rgba(168, 85, 247, 0.2) 50%, transparent 100%);
        filter: blur(40px);
        pointer-events: none;
    }

    .backdrop-blur {
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }

    /* Animasi Indikator Lampu Berkedip */
    .status-indicator {
        width: 8px;
        height: 8px;
        background-color: #10b981;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        animation: statusPulse 1.8s infinite ease-in-out;
    }

    @keyframes statusPulse {
        0% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        }
        70% {
            transform: scale(1);
            box-shadow: 0 0 0 8px rgba(16, 185, 129, 0);
        }
        100% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
        }
    }

    .text-purple {
        color: #a855f7 !important;
    }

    .btn-purple-gradient {
        background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
        color: #ffffff;
        border: none;
        transition: all 0.2s ease;
    }

    .btn-purple-gradient:hover {
        color: #ffffff;
        opacity: 0.95;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(139, 92, 246, 0.35) !important;
    }

    /* Form Card Border */
    .modern-form-card {
        border: 1px solid var(--bs-border-color-translucent) !important;
    }

    .fs-7 { font-size: 0.875rem; }
    .fs-8 { font-size: 0.75rem; }
    .tracking-wider { letter-spacing: 0.05em; }
</style>
@endsection
