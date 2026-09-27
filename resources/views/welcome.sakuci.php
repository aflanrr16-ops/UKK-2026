@extends('layouts.app')

@section('title', config('app.name', 'Studio & Sound') . ' -- Portal Peminjaman Alat Seni dan Musik Sekolah')

@section('content')

{{-- Style Kustom Formal --}}
<style>
    /* ----------------------------------------------------
       THEME VARIABLES (FORMAL & CLEAN THEME)
    ---------------------------------------------------- */
    :root {
        --bg-main: #f8fafc;
        --card-bg: #ffffff;
        --card-border: #e2e8f0;
        --text-primary: #0f172a;
        --text-secondary: #475569;
        --text-muted: #64748b;
        --brand-primary: #1e3a8a; /* Deep Navy */
        --brand-accent: #2563eb;  /* Royal Blue */
        --success-color: #059669;
        --warning-color: #d97706;
    }

    [data-bs-theme="dark"] {
        --bg-main: #0f172a;
        --card-bg: #1e293b;
        --card-border: #334155;
        --text-primary: #f8fafc;
        --text-secondary: #cbd5e1;
        --text-muted: #94a3b8;
        --brand-primary: #3b82f6;
        --brand-accent: #60a5fa;
    }

    /* ----------------------------------------------------
       LAYOUT & CONTAINER ADJUSTMENTS
    ---------------------------------------------------- */
    .formal-hero-section {
        background-color: var(--bg-main);
        /* Pengaturan rapat ke atas */
        margin-top: -1.5rem; 
        padding-top: 2rem;
        padding-bottom: 3rem;
        transition: background-color 0.3s ease;
    }

    /* ----------------------------------------------------
       TYPOGRAPHY & ACCENTS
    ---------------------------------------------------- */
    .fw-bold-custom { font-weight: 700; }
    .fw-black { font-weight: 800; }
    .leading-relaxed { line-height: 1.6; }

    .text-formal-title { color: var(--text-primary); }
    .text-formal-subtitle { color: var(--text-secondary); }
    .text-formal-muted { color: var(--text-muted); }
    
    .text-brand { color: var(--brand-primary) !important; }

    /* Badge Formal */
    .badge-formal {
        background-color: rgba(37, 99, 235, 0.1);
        color: var(--brand-accent);
        border: 1px solid rgba(37, 99, 235, 0.2);
        font-weight: 600;
        letter-spacing: 0.05em;
    }

    /* ----------------------------------------------------
       BUTTONS
    ---------------------------------------------------- */
    .btn-formal-primary {
        background-color: #1e3a8a !important;
        border-color: #1e3a8a !important;
        color: #ffffff !important;
        font-weight: 600;
        transition: all 0.2s ease-in-out;
    }

    .btn-formal-primary:hover {
        background-color: #1e40af !important;
        border-color: #1e40af !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(30, 58, 138, 0.2);
    }

    /* ----------------------------------------------------
       CARDS & CONTAINER
    ---------------------------------------------------- */
    .card-formal {
        background: var(--card-bg) !important;
        border: 1px solid var(--card-border) !important;
        border-radius: 0.75rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card-formal:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
    }

    .stat-icon-square {
        width: 48px;
        height: 48px;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .bg-icon-blue { background: rgba(37, 99, 235, 0.1); color: #2563eb; }
    .bg-icon-amber { background: rgba(217, 119, 6, 0.1); color: #d97706; }
    .bg-icon-purple { background: rgba(147, 51, 234, 0.1); color: #9333ea; }
    .bg-icon-emerald { background: rgba(5, 150, 105, 0.1); color: #059669; }

</style>

{{-- Section Formal Utama (Full Width & Position Shifted Up) --}}
<section class="formal-hero-section">
    {{-- Container Full Width --}}
    <div class="container-fluid px-4 px-lg-5">
        
        {{-- Header Section --}}
        <div class="row justify-content-center text-center mb-4 pt-2">
            <div class="col-lg-10 col-xl-8">
                
                {{-- Badge Status --}}
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill badge-formal mb-3">
                    <i class="bi bi-shield-check"></i>
                    <span class="small text-uppercase fw-bold">Portal Resmi Peminjaman Digital</span>
                </div>
                
                {{-- Judul Utama --}}
                <h1 class="display-5 fw-black text-formal-title mb-3">
                    Sistem Pengelolaan & Peminjaman <br>
                    <span class="text-brand">Peralatan Seni & Musik Sekolah</span>
                </h1>
                
                {{-- Subtitle --}}
                <p class="lead text-formal-subtitle mb-4 px-md-5 fs-6 leading-relaxed">
                    Layanan terpadu untuk memfasilitasi pencatatan, peminjaman, dan pengawasan fasilitas serta sarana prasarana kesenian sekolah secara terstruktur dan akuntabel.
                </p>

                <div class="d-flex justify-content-center">
                    <a href="/peminjaman" class="btn btn-formal-primary btn-lg px-4 py-2.5 rounded-3 fs-6 d-inline-flex align-items-center gap-2">
                        <span>Login</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Row Kartu Statistik (Full Grid) --}}
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card card-formal h-100 p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="stat-icon-square bg-icon-blue">
                            <i class="bi bi-headset fs-4"></i>
                        </div>
                        <span class="badge bg-light text-dark border rounded-pill px-2.5 py-1">Inventaris</span>
                    </div>
                    <span class="small text-formal-muted fw-medium d-block mb-1">Peralatan Lab &amp; Multimedia</span>
                    <h3 class="fw-bold-custom text-formal-title mb-0">50+ Unit</h3>
                    <span class="small text-formal-muted">Siap Digunakan</span>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="card card-formal h-100 p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="stat-icon-square bg-icon-amber">
                            <i class="bi bi-box-seam fs-4"></i>
                        </div>
                        <span class="badge bg-light text-dark border rounded-pill px-2.5 py-1">Tradisional</span>
                    </div>
                    <span class="small text-formal-muted fw-medium d-block mb-1">Paket Alat Tradisional</span>
                    <h3 class="fw-bold-custom text-formal-title mb-0">25 Set</h3>
                    <span class="small text-formal-muted">Seni Tari &amp; Gamelan</span>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="card card-formal h-100 p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="stat-icon-square bg-icon-purple">
                            <i class="bi bi-arrow-repeat fs-4"></i>
                        </div>
                        <span class="badge bg-light text-dark border rounded-pill px-2.5 py-1">Proses</span>
                    </div>
                    <span class="small text-formal-muted fw-medium d-block mb-1">Peminjaman Aktif</span>
                    <h3 class="fw-bold-custom text-formal-title mb-0">8 Transaksi</h3>
                    <span class="small text-formal-muted">Sedang Dipinjam</span>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="card card-formal h-100 p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="stat-icon-square bg-icon-emerald">
                            <i class="bi bi-check2-circle fs-4"></i>
                        </div>
                        <span class="badge bg-light text-dark border rounded-pill px-2.5 py-1">Selesai</span>
                    </div>
                    <span class="small text-formal-muted fw-medium d-block mb-1">Pengembalian</span>
                    <h3 class="fw-bold-custom text-formal-title mb-0">5 Transaksi</h3>
                    <span class="small text-formal-muted">Selesai Dikembalikan</span>
                </div>
            </div>
        </div>

        {{-- Section "Informasi Layanan" --}}
        <div class="row">
            <div class="col-12">
                <div class="card card-formal p-4 p-md-4">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-8">
                            <h5 class="fw-bold-custom text-formal-title mb-2 d-flex align-items-center gap-2">
                                <i class="bi bi-info-circle text-brand fs-5"></i>
                                Tentangan Portal Peminjaman Sarana
                            </h5>
                            <p class="text-formal-subtitle mb-2 leading-relaxed">
                                Portal ini dirancang untuk mempermudah operasional manajemen studio, peminjaman instrumen musik, serta peralatan pertunjukan seni secara sistematis dan teratur di lingkungan sekolah.
                            </p>
                            <p class="text-formal-muted mb-0 small leading-relaxed">
                                Memaksimalkan transparansi ketersediaan unit, pemantauan pengembalian barang, serta penyediaan data inventaris guna mendukung kegiatan ekstrakurikuler dan akademis.
                            </p>
                        </div>
                        <div class="col-lg-4 border-start-lg">
                            <div class="ps-lg-3">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <i class="bi bi-file-earmark-check text-success fs-3"></i>
                                    <div>
                                        <div class="fw-bold-custom text-formal-title small">Pencatatan Terpusat</div>
                                        <div class="small text-formal-muted">Data peminjaman terekam real-time</div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-clock-history text-brand fs-3"></i>
                                    <div>
                                        <div class="fw-bold-custom text-formal-title small">Proses Efisien</div>
                                        <div class="small text-formal-muted">Pengajuan peminjaman lebih cepat</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection