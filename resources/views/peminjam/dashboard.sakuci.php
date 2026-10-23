@extends('layouts.app')

@section('title', config('app.name') . ' — Dashboard Siswa')

@section('content')
<div class="container-fluid py-4 px-3 px-md-4">

    <!-- 1. BANNER UTAMA (Hero Gradient Ungu Modern + Status Akun Aktif Berkedip) -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 text-white hero-banner-purple">
        <div class="hero-bg-shapes"></div>
        <div class="card-body p-4 p-md-5 position-relative z-2">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <div class="d-flex align-items-center flex-wrap gap-2 mb-3">
                        <!-- Role Badge -->
                        <span class="badge bg-white bg-opacity-10 text-white border border-white border-opacity-20 rounded-pill px-3 py-1.5 fw-semibold small text-uppercase tracking-wider">
                            <i class="bi bi-person-badge-fill me-1 text-warning"></i> Role: {{ $user->role ?? 'Siswa' }}
                        </span>
                        
                        <!-- Badge Status Akun Aktif dengan Animasi Kedap-Kedip -->
                        @if(($user->status ?? 'Aktif') === 'Aktif')
                            <div class="d-inline-flex align-items-center text-white rounded-pill px-3 py-1.5 shadow-sm fs-8 fw-semibold bg-white bg-opacity-10 border border-white border-opacity-20 backdrop-blur">
                                <span class="status-indicator me-2"></span>
                                <span>Status Akun: Aktif</span>
                            </div>
                        @else
                            <div class="d-inline-flex align-items-center text-white rounded-pill px-3 py-1.5 shadow-sm fs-8 fw-semibold bg-white bg-opacity-10 border border-white border-opacity-20 backdrop-blur">
                                <span class="status-dot-off me-2"></span>
                                <span>Status Akun: Non-Aktif</span>
                            </div>
                        @endif
                    </div>
                    
                    <h2 class="fw-bold mb-2 text-white">Selamat Datang, {{ $user->username ?? ($user->name ?? 'Siswa') }}! 👋</h2>
                    <p class="mb-0 text-white-50 fs-6" style="max-width: 650px;">
                        Pusat peminjaman alat inventaris sekolah. Pantau status pengajuan, tenggat waktu, serta riwayat peminjaman Anda secara *real-time*.
                    </p>
                </div>
                <div>
                    <a href="{{ route('peminjam.createPeminjam') }}" class="btn btn-light px-4 py-2.5 rounded-pill fw-semibold text-dark shadow-sm backdrop-blur d-inline-flex align-items-center gap-2">
                        <i class="bi bi-plus-lg text-purple"></i>
                        <span>Ajukan Peminjaman</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. RINGKASAN STATISTIK (Dinamis & Kontras Mode Terang/Gelap) -->
    <div class="row g-3 mb-4">

        <!-- Menunggu Verifikasi -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-body modern-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon-wrapper rounded-4 d-flex align-items-center justify-content-center bg-warning bg-opacity-10 text-warning" style="width: 58px; height: 58px; flex-shrink: 0;">
                        <i class="bi bi-hourglass-split fs-3"></i>
                    </div>
                    <div>
                        <span class="text-uppercase fw-bold text-secondary d-block fs-8 mb-1">Menunggu</span>
                        <h3 class="fw-extrabold mb-0 text-body-emphasis">{{ $pendingCount ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Barang Dipinjam -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-body modern-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon-wrapper rounded-4 d-flex align-items-center justify-content-center text-purple" style="width: 58px; height: 58px; flex-shrink: 0; background-color: rgba(168, 85, 247, 0.12);">
                        <i class="bi bi-tools fs-3"></i>
                    </div>
                    <div>
                        <span class="text-uppercase fw-bold text-secondary d-block fs-8 mb-1">Dipinjam</span>
                        <h3 class="fw-extrabold mb-0 text-body-emphasis">{{ $activeCount ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Selesai -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-body modern-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon-wrapper rounded-4 d-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success" style="width: 58px; height: 58px; flex-shrink: 0;">
                        <i class="bi bi-check-circle-fill fs-3"></i>
                    </div>
                    <div>
                        <span class="text-uppercase fw-bold text-secondary d-block fs-8 mb-1">Selesai</span>
                        <h3 class="fw-extrabold mb-0 text-body-emphasis">{{ $completedCount ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Denda -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-body modern-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon-wrapper rounded-4 d-flex align-items-center justify-content-center bg-danger bg-opacity-10 text-danger" style="width: 58px; height: 58px; flex-shrink: 0;">
                        <i class="bi bi-exclamation-triangle-fill fs-3"></i>
                    </div>
                    <div>
                        <span class="text-uppercase fw-bold text-secondary d-block fs-8 mb-1">Total Denda</span>
                        <h3 class="fw-extrabold mb-0 text-body-emphasis fs-5">Rp {{ number_format($totalDenda ?? 0, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- 3. INFORMASI & STATUS KUOTA -->
    <div class="row g-3">
        
        <!-- Panduan & Kebijakan -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-body overflow-hidden modern-card">
                <div class="card-header bg-body border-bottom py-3 px-4">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-info-circle-fill text-purple fs-5"></i>
                        <h6 class="card-title mb-0 fw-semibold text-body-emphasis">Panduan & Kebijakan Peminjaman</h6>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 bg-body-tertiary border h-100 d-flex gap-3">
                                <div class="p-2.5 rounded-3 fs-4 d-flex align-items-center justify-content-center text-purple" 
                                     style="width: 46px; height: 46px; flex-shrink: 0; background: rgba(168, 85, 247, 0.12);">
                                    <i class="bi bi-journal-check"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1 text-body-emphasis fs-7">Prosedur Pengajuan</h6>
                                    <p class="text-secondary fs-8 mb-0">Isi formulir peminjaman dengan lengkap dan tunggu verifikasi persetujuan dari petugas.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 bg-body-tertiary border h-100 d-flex gap-3">
                                <div class="p-2.5 rounded-3 fs-4 d-flex align-items-center justify-content-center text-purple" 
                                     style="width: 46px; height: 46px; flex-shrink: 0; background: rgba(168, 85, 247, 0.12);">
                                    <i class="bi bi-clock-history"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1 text-body-emphasis fs-7">Batas Waktu & Denda</h6>
                                    <p class="text-secondary fs-8 mb-0">Kembalikan alat tepat waktu untuk menghindari akumulasi denda harian.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Kuota Anda -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-body overflow-hidden modern-card d-flex flex-column justify-content-between">
                <div class="card-header bg-body border-bottom py-3 px-4">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-pie-chart-fill text-purple fs-5"></i>
                        <h6 class="card-title mb-0 fw-semibold text-body-emphasis">Status Kuota Anda</h6>
                    </div>
                </div>
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <p class="text-secondary fs-8 mb-3">Batas maksimal alat yang aktif dipinjam secara bersamaan.</p>
                    
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fs-8 fw-semibold text-secondary">Kapasitas Digunakan</span>
                            <span class="fs-8 fw-bold text-purple">{{ $activeCount ?? 0 }} / 3 Alat</span>
                        </div>
                        <div class="progress rounded-pill mb-3" style="height: 10px; background-color: rgba(168, 85, 247, 0.12);">
                            @php
                                $active = $activeCount ?? 0;
                                $percentage = min(($active / 3) * 100, 100);
                            @endphp
                            <div class="progress-bar rounded-pill" role="progressbar" 
                                 style="width: {{ $percentage }}%; background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);" 
                                 aria-valuenow="{{ $active }}" aria-valuemin="0" aria-valuemax="3"></div>
                        </div>
                        <div class="d-flex align-items-center gap-2 text-secondary fs-8">
                            <i class="bi bi-shield-fill-check text-success"></i>
                            <span>Akun Anda terverifikasi dan aman.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- 🎨 STYLING KUSTOM KHUSUS TEMA UNGU & ANIMASI INDIKATOR STATUS -->
<style>
    /* Banner Hero Ungu */
    .hero-banner-purple {
        background: linear-gradient(135deg, #4c1d95 0%, #6d28d9 50%, #7c3aed 100%) !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
    }

    .hero-bg-shapes {
        position: absolute;
        top: -60px;
        right: -60px;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(236, 72, 153, 0.25) 0%, rgba(168, 85, 247, 0.2) 50%, transparent 100%);
        filter: blur(50px);
        pointer-events: none;
    }

    .backdrop-blur {
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }

    /* Animasi Lampu Indikator Status Aktif Berkedip (Pulse) */
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

    .status-dot-off {
        width: 8px;
        height: 8px;
        background-color: #94a3b8;
        border-radius: 50%;
        display: inline-block;
    }

    .text-purple {
        color: #a855f7 !important;
    }

    /* Modern Card Statistik & Konten */
    .modern-card {
        border: 1px solid var(--bs-border-color-translucent) !important;
        transition: all 0.25s ease;
    }

    .modern-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08) !important;
    }

    .fs-7 { font-size: 0.875rem; }
    .fs-8 { font-size: 0.75rem; }
    .tracking-wider { letter-spacing: 0.05em; }
</style>
@endsection
