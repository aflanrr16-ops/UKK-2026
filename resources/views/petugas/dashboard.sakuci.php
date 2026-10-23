@extends('layouts.app')

@section('title', config('app.name') . ' — Dashboard Petugas')

@section('content')

<div class="container-fluid px-0 py-2">

    <!-- 1. BANNER UTAMA (Hero Gradient Ungu Modern) -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 text-white hero-banner-purple">
        <div class="hero-bg-shapes"></div>
        <div class="card-body p-4 p-md-5 position-relative z-2">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill bg-white bg-opacity-10 border border-white border-opacity-20 backdrop-blur mb-3">
                        <span class="status-indicator"></span>
                        <span class="text-white fw-semibold fs-8 tracking-wider text-uppercase">
                            <i class="bi bi-shield-check me-1 text-warning"></i> Panel Petugas Operasional
                        </span>
                    </div>
                    
                    <h2 class="fw-bold mb-2 text-white">Selamat Datang, {{ $user->username ?? ($user->name ?? 'Petugas') }}! 👋</h2>
                    <p class="mb-0 text-white-50 fs-6" style="max-width: 650px;">
                        Pusat kendali operasional peminjaman alat inventaris. Pantau antrean verifikasi, status barang dipinjam, dan kelola kelancaran transaksi secara *real-time*.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. RINGKASAN STATISTIK (Dinamis & Kontras Mode Terang/Gelap) -->
    <div class="row g-3 mb-4">

        <!-- Menunggu Verifikasi -->
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-body modern-card">
                <div class="d-flex align-items-center gap-4">
                    <div class="stat-icon-wrapper rounded-4 d-flex align-items-center justify-content-center bg-warning bg-opacity-10 text-warning" style="width: 58px; height: 58px; flex-shrink: 0;">
                        <i class="bi bi-hourglass-split fs-3"></i>
                    </div>
                    <div>
                        <span class="text-uppercase fw-bold text-secondary d-block fs-8 mb-1">Menunggu Verifikasi</span>
                        <h3 class="fw-extrabold mb-0 text-body-emphasis">{{ $totalPending ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Barang Dipinjam -->
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-body modern-card">
                <div class="d-flex align-items-center gap-4">
                    <div class="stat-icon-wrapper rounded-4 d-flex align-items-center justify-content-center text-purple" style="width: 58px; height: 58px; flex-shrink: 0; background-color: rgba(168, 85, 247, 0.12);">
                        <i class="bi bi-box-seam-fill fs-3"></i>
                    </div>
                    <div>
                        <span class="text-uppercase fw-bold text-secondary d-block fs-8 mb-1">Barang Dipinjam</span>
                        <h3 class="fw-extrabold mb-0 text-body-emphasis">{{ $totalDipinjam ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Selesai -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-body modern-card">
                <div class="d-flex align-items-center gap-4">
                    <div class="stat-icon-wrapper rounded-4 d-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success" style="width: 58px; height: 58px; flex-shrink: 0;">
                        <i class="bi bi-database-check fs-3"></i>
                    </div>
                    <div>
                        <span class="text-uppercase fw-bold text-secondary d-block fs-8 mb-1">Total Selesai</span>
                        <h3 class="fw-extrabold mb-0 text-body-emphasis">{{ $totalSelesai ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- 3. MENU AKSES CEPAT -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="fw-bold mb-0 text-body-emphasis d-flex align-items-center gap-2">
            <i class="bi bi-grid-fill text-purple"></i> Menu Akses Cepat
        </h5>
    </div>

    <div class="row g-3 mb-4">
        <!-- Persetujuan Peminjaman -->
        <div class="col-md-6">
            <a href="{{ route('petugas.peminjaman.index') }}" class="card custom-menu-card h-100 text-decoration-none border shadow-sm rounded-4 p-4 position-relative overflow-hidden">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div class="menu-icon-wrapper rounded-3 p-3 d-flex align-items-center justify-content-center">
                        <i class="bi bi-check-circle fs-3"></i>
                    </div>
                    <div class="arrow-badge rounded-circle d-flex align-items-center justify-content-center bg-body-tertiary text-body-emphasis" style="width: 32px; height: 32px;">
                        <i class="bi bi-arrow-up-right fs-6"></i>
                    </div>
                </div>
                <div>
                    <h5 class="fw-bold text-body-emphasis mb-1">Persetujuan Peminjaman</h5>
                    <small class="text-purple fw-semibold d-block mb-2">Verifikasi Pengajuan Siswa</small>
                    <p class="text-secondary small mb-0 fs-8">Proses persetujuan atau penolakan pengajuan peminjaman alat dari siswa secara cepat.</p>
                </div>
            </a>
        </div>

        <!-- Pantau Pengembalian -->
        <div class="col-md-6">
            <a href="{{ route('petugas.pengembalian.index') }}" class="card custom-menu-card h-100 text-decoration-none border shadow-sm rounded-4 p-4 position-relative overflow-hidden">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div class="menu-icon-wrapper rounded-3 p-3 d-flex align-items-center justify-content-center">
                        <i class="bi bi-arrow-return-left fs-3"></i>
                    </div>
                    <div class="arrow-badge rounded-circle d-flex align-items-center justify-content-center bg-body-tertiary text-body-emphasis" style="width: 32px; height: 32px;">
                        <i class="bi bi-arrow-up-right fs-6"></i>
                    </div>
                </div>
                <div>
                    <h5 class="fw-bold text-body-emphasis mb-1">Pantau Pengembalian</h5>
                    <small class="text-purple fw-semibold d-block mb-2">Pencatatan Barang & Kondisi</small>
                    <p class="text-secondary small mb-0 fs-8">Konfirmasi pengembalian alat, periksa tenggat waktu, serta keteperincian denda dan kondisi barang.</p>
                </div>
            </a>
        </div>
    </div>

</div>

<!-- 🎨 STYLING KUSTOM KHUSUS TEMA UNGU & ADAPTIF MODE GELAP/TERANG -->
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

    .status-indicator {
        width: 8px;
        height: 8px;
        background-color: #10b981;
        border-radius: 50%;
        box-shadow: 0 0 10px #10b981;
    }

    .text-purple {
        color: #a855f7 !important;
    }

    /* Modern Card Statistik */
    .modern-card {
        border: 1px solid var(--bs-border-color-translucent) !important;
        transition: all 0.25 ease;
    }

    .modern-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08) !important;
    }

    /* Custom Menu Card */
    .custom-menu-card {
        background-color: var(--bs-card-bg);
        border: 1px solid var(--bs-border-color-translucent) !important;
        transition: all 0.25s ease-in-out;
    }

    .menu-icon-wrapper {
        background-color: rgba(168, 85, 247, 0.12);
        color: #a855f7;
        width: 54px;
        height: 54px;
        transition: all 0.25s ease-in-out;
    }

    .custom-menu-card:hover {
        border-color: #a855f7 !important;
        transform: translateY(-3px);
        box-shadow: 0 0.75rem 1.5rem rgba(168, 85, 247, 0.15) !important;
    }

    .custom-menu-card:hover .menu-icon-wrapper {
        background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
        color: #ffffff;
    }

    .custom-menu-card:hover .arrow-badge {
        background-color: #a855f7 !important;
        color: #ffffff !important;
    }

    .fs-8 {
        font-size: 0.8125rem;
    }
</style>
@endsection
