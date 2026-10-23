@extends('layouts.app')

@section('title', config('app.name', 'Sakuci Loan') . ' -- Sistem Peminjaman Alat & Fasilitas Sekolah')

@section('content')

{{-- Style Kustom: Theme Purple / Indigo khas aflanfr (Full Adaptive Light & Dark Mode) --}}
<style>
    /* VARIABEL UTAMA - LIGHT MODE */
    :root {
        --bg-main: #f5f3ff;
        --card-bg: #ffffff;
        --card-bg-hover: #ede9fe;
        --card-border: rgba(124, 58, 237, 0.2);
        --card-box-shadow: 0 10px 25px rgba(124, 58, 237, 0.08);
        
        /* Warna Teks Adaptif */
        --text-title: #2e1065;
        --text-body: #334155;
        --text-muted: #64748b;
        
        /* Warna Teks Hero & Inner Floating Card */
        --banner-bg: linear-gradient(135deg, #ede9fe 0%, #e0e7ff 50%, #f5f3ff 100%);
        --banner-border: rgba(124, 58, 237, 0.25);
        --hero-title-color: #1e1b4b;
        --banner-text-body: #475569;
        
        --floating-card-bg: rgba(255, 255, 255, 0.85);
        --floating-card-border: rgba(124, 58, 237, 0.2);
        --floating-card-title: #2e1065;
        --floating-card-icon: #7c3aed;
        
        --accent-indigo: #6366f1;
        --accent-violet: #7c3aed;
        --accent-pink: #ec4899;
        --accent-purple-light: #a855f7;
    }

    /* AUTO DARK MODE SCHEME */
    @media (prefers-color-scheme: dark) {
        :root {
            --bg-main: #090514;
            --card-bg: #14102c;
            --card-bg-hover: #1c153d;
            --card-border: rgba(168, 85, 247, 0.3);
            --card-box-shadow: 0 12px 30px rgba(0, 0, 0, 0.6);
            
            /* Warna Teks Adaptif Dark Mode */
            --text-title: #f3e8ff;
            --text-body: #e2e8f0;
            --text-muted: #cbd5e1;
            
            /* Warna Teks Hero & Inner Floating Card Dark Mode */
            --banner-bg: linear-gradient(135deg, #3b0764 0%, #1e1b4b 50%, #0f0c20 100%);
            --banner-border: rgba(168, 85, 247, 0.4);
            --hero-title-color: #ffffff;
            --banner-text-body: #e2e8f0;
            
            --floating-card-bg: rgba(23, 21, 59, 0.85);
            --floating-card-border: rgba(168, 85, 247, 0.3);
            --floating-card-title: #ffffff;
            --floating-card-icon: #c084fc;
        }
    }

    html.dark, body.dark {
        --bg-main: #090514;
        --card-bg: #14102c;
        --card-bg-hover: #1c153d;
        --card-border: rgba(168, 85, 247, 0.3);
        --card-box-shadow: 0 12px 30px rgba(0, 0, 0, 0.6);
        
        --text-title: #f3e8ff;
        --text-body: #e2e8f0;
        --text-muted: #cbd5e1;
        
        --banner-bg: linear-gradient(135deg, #3b0764 0%, #1e1b4b 50%, #0f0c20 100%);
        --banner-border: rgba(168, 85, 247, 0.4);
        --hero-title-color: #ffffff;
        --banner-text-body: #e2e8f0;
        
        --floating-card-bg: rgba(23, 21, 59, 0.85);
        --floating-card-border: rgba(168, 85, 247, 0.3);
        --floating-card-title: #ffffff;
        --floating-card-icon: #c084fc;
    }

    html, body {
        background-color: var(--bg-main) !important;
        color: var(--text-title);
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        min-height: 100vh;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .fs-8 {
        font-size: 0.75rem !important;
    }

    /* Keyframe Animations */
    @keyframes pulse-glow-purple {
        0%, 100% { box-shadow: 0 0 18px rgba(124, 58, 237, 0.2); }
        50% { box-shadow: 0 0 35px rgba(168, 85, 247, 0.4); }
    }

    @keyframes float-icon {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-8px) rotate(1deg); }
    }

    /* Hero Card Style */
    .hero-banner-custom {
        background: var(--banner-bg);
        border: 1px solid var(--banner-border);
        border-radius: 1.5rem;
        padding: 3.5rem 2.5rem;
        position: relative;
        overflow: hidden;
        animation: pulse-glow-purple 6s infinite ease-in-out;
        transition: background 0.3s ease, border-color 0.3s ease;
    }

    .hero-floating-box {
        animation: float-icon 4s ease-in-out infinite;
        background: var(--floating-card-bg) !important;
        border: 1px solid var(--floating-card-border) !important;
    }

    .hero-title-text {
        color: var(--hero-title-color) !important;
    }

    /* Buttons */
    .btn-purple-capsule {
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%) !important;
        color: #ffffff !important;
        font-weight: 700;
        padding: 0.75rem 1.75rem;
        border-radius: 50px;
        border: none;
        box-shadow: 0 0 20px rgba(168, 85, 247, 0.3);
        transition: all 0.3s ease;
    }

    .btn-purple-capsule:hover {
        background: linear-gradient(135deg, #4f46e5 0%, #9333ea 100%) !important;
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 0 30px rgba(168, 85, 247, 0.6);
        color: #ffffff !important;
    }

    .btn-outline-capsule {
        background: rgba(124, 58, 237, 0.1) !important;
        color: var(--text-title) !important;
        font-weight: 600;
        padding: 0.75rem 1.75rem;
        border-radius: 50px;
        border: 1px solid var(--card-border);
        backdrop-filter: blur(8px);
        transition: all 0.3s ease;
    }

    .btn-outline-capsule:hover {
        background: rgba(124, 58, 237, 0.2) !important;
        border-color: var(--accent-violet);
        transform: translateY(-3px);
    }

    /* Card Custom */
    .card-dark-custom {
        background-color: var(--card-bg) !important;
        border-radius: 1.25rem;
        padding: 1.75rem;
        height: 100%;
        box-shadow: var(--card-box-shadow);
        border: 1px solid var(--card-border);
        transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
    }

    .card-dark-custom:hover {
        background-color: var(--card-bg-hover) !important;
        transform: translateY(-5px);
    }

    .text-adaptive-title {
        color: var(--text-title) !important;
    }

    .text-adaptive-body {
        color: var(--text-body) !important;
    }

    .text-adaptive-muted {
        color: var(--text-muted) !important;
    }

    /* Modern Category Badges */
    .pill-category-badge {
        background: rgba(168, 85, 247, 0.12);
        border: 1px solid rgba(168, 85, 247, 0.3);
        color: var(--text-title);
        font-weight: 500;
        font-size: 0.8rem;
        padding: 0.4rem 0.9rem;
        border-radius: 50px;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .section-tag {
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #7c3aed;
        margin-bottom: 0.4rem;
        display: block;
    }

    @media (prefers-color-scheme: dark) {
        .section-tag {
            color: #c084fc;
        }
    }

    .icon-box-purple {
        width: 48px;
        height: 48px;
        background: rgba(168, 85, 247, 0.15);
        color: #7c3aed;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
    }

    @media (prefers-color-scheme: dark) {
        .icon-box-purple {
            color: #c084fc;
        }
    }
</style>

<div class="container-fluid py-4 px-md-5">

    {{-- 1. HERO BANNER --}}
    <div class="hero-banner-custom mb-5 shadow-lg">
        <div class="row align-items-center position-relative z-1 g-4">
            
            <div class="col-lg-7">
                <span class="badge px-3 py-2 rounded-pill text-uppercase mb-3 d-inline-flex align-items-center gap-2" style="font-weight: 600; letter-spacing: 0.08em; background: rgba(168, 85, 247, 0.18); border: 1px solid rgba(168, 85, 247, 0.35); color: var(--text-title);">
                    <span class="d-inline-block rounded-circle" style="width: 6px; height: 6px; background-color: #a855f7;"></span>
                    Sistem Layanan Terpadu
                </span>

                <h1 class="fw-bold hero-title-text mb-3 display-4" style="line-height: 1.2;">
                    Peminjaman Alat &amp; <br>
                    <span style="background: linear-gradient(90deg, #9333ea, #ec4899, #6366f1); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Fasilitas Sekolah</span>
                </h1>

                <p class="fs-6 mb-4" style="max-width: 580px; line-height: 1.6; color: var(--banner-text-body);">
                    Permudah pengajuan dan pemantauan peminjaman perangkat IT, laboratorium, kamera, media pembelajaran, hingga alat seni &amp; musik sekolah secara digital dan transparan.
                </p>

                <div class="d-flex flex-wrap gap-3 align-items-center">
                    @if(function_exists('auth') && auth()->check())
                        <a href="{{ url('/dashboard') }}" class="btn btn-purple-capsule d-inline-flex align-items-center gap-2">
                            <span>Buka Dashboard</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-purple-capsule d-inline-flex align-items-center gap-2">
                            <span>Mulai Pinjam Sekarang</span>
                            <i class="bi bi-box-arrow-in-right"></i>
                        </a>
                    @endif

                    <a href="#kategori-alat" class="btn btn-outline-capsule">
                        Jelajahi Fasilitas
                    </a>
                </div>
            </div>

            <div class="col-lg-5 text-center d-none d-lg-block">
                <div class="p-4 rounded-4 hero-floating-box shadow">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="p-3 rounded-3 text-start" style="background: rgba(168, 85, 247, 0.12); border: 1px solid rgba(168, 85, 247, 0.25);">
                                <i class="bi bi-laptop fs-3 d-block mb-1" style="color: var(--floating-card-icon);"></i>
                                <div class="fw-bold small" style="color: var(--floating-card-title);">Perangkat IT</div>
                                <div class="text-adaptive-muted fs-8">Laptop &amp; Proyektor</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-3 text-start" style="background: rgba(99, 102, 241, 0.12); border: 1px solid rgba(99, 102, 241, 0.25);">
                                <i class="bi bi-camera fs-3 d-block mb-1" style="color: var(--accent-indigo);"></i>
                                <div class="fw-bold small" style="color: var(--floating-card-title);">Dokumentasi</div>
                                <div class="text-adaptive-muted fs-8">Kamera &amp; Lighting</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-3 text-start" style="background: rgba(236, 72, 153, 0.12); border: 1px solid rgba(236, 72, 153, 0.25);">
                                <i class="bi bi-music-note-beamed fs-3 d-block mb-1" style="color: var(--accent-pink);"></i>
                                <div class="fw-bold small" style="color: var(--floating-card-title);">Seni &amp; Musik</div>
                                <div class="text-adaptive-muted fs-8">Instrumen &amp; Sound</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-3 text-start" style="background: rgba(168, 85, 247, 0.12); border: 1px solid rgba(168, 85, 247, 0.25);">
                                <i class="bi bi-tools fs-3 d-block mb-1" style="color: var(--floating-card-icon);"></i>
                                <div class="fw-bold small" style="color: var(--floating-card-title);">Lab &amp; Olahraga</div>
                                <div class="text-adaptive-muted fs-8">Peralatan Praktikum</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- 2. STATISTIK SISTEM --}}
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card-dark-custom">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box-purple">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div>
                        <div class="display-6 fw-bold text-adaptive-title">100%</div>
                        <div class="text-adaptive-muted small">Tercatat Otomatis di Sistem</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-dark-custom">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box-purple">
                        <i class="bi bi-lightning-charge-fill"></i>
                    </div>
                    <div>
                        <div class="display-6 fw-bold text-adaptive-title">&lt; 15 Mnt</div>
                        <div class="text-adaptive-muted small">Estimasi Respon Verifikasi</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-dark-custom">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box-purple">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div>
                        <div class="fs-3 fw-bold text-adaptive-title">Terintegrasi</div>
                        <div class="text-adaptive-muted small">Sirkulasi Inventaris Real-Time</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. KATEGORI PEMINJAMAN ALAT SEKOLAH --}}
    <div class="mb-5" id="kategori-alat">
        <span class="section-tag">Inventaris</span>
        <h2 class="fw-bold text-adaptive-title mb-2">Fasilitas &amp; Peralatan Sekolah</h2>
        <p class="text-adaptive-muted mb-4">Berbagai kategori inventaris sekolah yang dapat diajukan peminjamannya oleh siswa &amp; staf.</p>

        <div class="row g-4">
            {{-- Kategori 1 --}}
            <div class="col-md-6 col-lg-4">
                <div class="card-dark-custom">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="icon-box-purple">
                            <i class="bi bi-laptop"></i>
                        </div>
                        <span class="badge rounded-pill" style="background: rgba(168, 85, 247, 0.15); color: #8b5cf6; font-weight: 600;">Perangkat IT</span>
                    </div>
                    <h5 class="fw-bold text-adaptive-title mb-2">Teknologi &amp; Multimedia</h5>
                    <p class="text-adaptive-body small mb-3">Peralatan pendukung presentasi, KBM kelas, serta kegiatan komputasi.</p>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="pill-category-badge">Laptop / Notebook</span>
                        <span class="pill-category-badge">Proyektor &amp; Layar</span>
                        <span class="pill-category-badge">Pointer &amp; Kabel HDMI</span>
                    </div>
                </div>
            </div>

            {{-- Kategori 2 --}}
            <div class="col-md-6 col-lg-4">
                <div class="card-dark-custom">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="icon-box-purple">
                            <i class="bi bi-camera-reels"></i>
                        </div>
                        <span class="badge rounded-pill" style="background: rgba(99, 102, 241, 0.15); color: #6366f1; font-weight: 600;">Dokumentasi</span>
                    </div>
                    <h5 class="fw-bold text-adaptive-title mb-2">Kamera &amp; Broadcasting</h5>
                    <p class="text-adaptive-body small mb-3">Fasilitas liputan, pembuatan konten multimedia, dan kegiatan liputan acara.</p>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="pill-category-badge">Kamera DSLR / Mirrorless</span>
                        <span class="pill-category-badge">Tripod &amp; Stabilizer</span>
                        <span class="pill-category-badge">Lighting Set</span>
                    </div>
                </div>
            </div>

            {{-- Kategori 3 --}}
            <div class="col-md-6 col-lg-4">
                <div class="card-dark-custom">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box-purple">
                            <i class="bi bi-journal-code"></i>
                        </div>
                        <span class="badge rounded-pill" style="background: rgba(236, 72, 153, 0.15); color: #db2777; font-weight: 600;">Praktikum</span>
                    </div>
                    <h5 class="fw-bold text-adaptive-title mb-2">Laboratorium &amp; Jurusan</h5>
                    <p class="text-adaptive-body small mb-3">Peralatan pendukung praktikum keahlian, jaringan, serta modul pembelajaran.</p>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="pill-category-badge">Toolkit Teknik</span>
                        <span class="pill-category-badge">Crimping &amp; Tester</span>
                        <span class="pill-category-badge">Perangkat Lab</span>
                    </div>
                </div>
            </div>

            {{-- Kategori 4 --}}
            <div class="col-md-6 col-lg-4">
                <div class="card-dark-custom">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="icon-box-purple">
                            <i class="bi bi-music-note-beamed"></i>
                        </div>
                        <span class="badge rounded-pill" style="background: rgba(168, 85, 247, 0.15); color: #8b5cf6; font-weight: 600;">Seni &amp; Musik</span>
                    </div>
                    <h5 class="fw-bold text-adaptive-title mb-2">Studio &amp; Alat Musik</h5>
                    <p class="text-adaptive-body small mb-3">Instrumen seni musik untuk latihan pentas, ekstrakurikuler, dan acara sekolah.</p>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="pill-category-badge">Gitar &amp; Keyboard</span>
                        <span class="pill-category-badge">Drum &amp; Cajon</span>
                        <span class="pill-category-badge">Mikrofon &amp; Stand</span>
                    </div>
                </div>
            </div>

            {{-- Kategori 5 --}}
            <div class="col-md-6 col-lg-4">
                <div class="card-dark-custom">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="icon-box-purple">
                            <i class="bi bi-speaker"></i>
                        </div>
                        <span class="badge rounded-pill" style="background: rgba(99, 102, 241, 0.15); color: #6366f1; font-weight: 600;">Audio</span>
                    </div>
                    <h5 class="fw-bold text-adaptive-title mb-2">Sound System Lapangan</h5>
                    <p class="text-adaptive-body small mb-3">Pengeras suara portable untuk kegiatan upacara, rapat, dan perlombaan.</p>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="pill-category-badge">Speaker Portable</span>
                        <span class="pill-category-badge">Wireless Mic</span>
                        <span class="pill-category-badge">Amplifier</span>
                    </div>
                </div>
            </div>

            {{-- Kategori 6 --}}
            <div class="col-md-6 col-lg-4">
                <div class="card-dark-custom">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="icon-box-purple">
                            <i class="bi bi-trophy"></i>
                        </div>
                        <span class="badge rounded-pill" style="background: rgba(236, 72, 153, 0.15); color: #db2777; font-weight: 600;">Olahraga</span>
                    </div>
                    <h5 class="fw-bold text-adaptive-title mb-2">Olahraga &amp; Sarana Lapangan</h5>
                    <p class="text-adaptive-body small mb-3">Peralatan pendukung pelajaran PJOK dan kegiatan pertandingan siswa.</p>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="pill-category-badge">Bola (Voli/Basket/Futsal)</span>
                        <span class="pill-category-badge">Net &amp; Raket</span>
                        <span class="pill-category-badge">Stopwatch</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 4. PANDUAN PENGGUNAAN PEMINJAMAN --}}
    <div class="card-dark-custom p-4 p-md-5 mb-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-5">
                <span class="section-tag">Petunjuk Alur</span>
                <h3 class="fw-bold text-adaptive-title mb-3">Prosedur Pengajuan Peminjaman</h3>
                <p class="text-adaptive-body mb-4" style="line-height: 1.6;">
                    Guna menjaga tata tertib kelengkapan sekolah, setiap pengajuan barang wajib mengikuti tahapan otomatis berikut.
                </p>
                <div class="p-3 rounded-3" style="background: rgba(168, 85, 247, 0.1); border: 1px solid rgba(168, 85, 247, 0.25);">
                    <div class="fw-bold text-adaptive-title small mb-1"><i class="bi bi-info-circle me-1" style="color: #8b5cf6;"></i> Catatan Wajib</div>
                    <div class="text-adaptive-muted fs-8">Selalu cek kondisi fisik peralatan bersama sarpras/petugas sebelum dan sesudah digunakan.</div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="d-flex flex-column gap-3">
                    {{-- Langkah 1 --}}
                    <div class="d-flex align-items-start gap-3 p-3 rounded-3" style="background: rgba(168, 85, 247, 0.05); border: 1px solid rgba(168, 85, 247, 0.2);">
                        <span class="badge rounded-circle p-2 px-3 fw-bold fs-6" style="background: #8b5cf6; color: #ffffff;">1</span>
                        <div>
                            <div class="fw-bold text-adaptive-title">Login Akun &amp; Cari Barang</div>
                            <div class="text-adaptive-muted small">Masuk dengan akun terdaftar untuk memeriksa jadwal dan status ketersediaan barang.</div>
                        </div>
                    </div>

                    {{-- Langkah 2 --}}
                    <div class="d-flex align-items-start gap-3 p-3 rounded-3" style="background: rgba(168, 85, 247, 0.05); border: 1px solid rgba(168, 85, 247, 0.2);">
                        <span class="badge rounded-circle p-2 px-3 fw-bold fs-6" style="background: #8b5cf6; color: #ffffff;">2</span>
                        <div>
                            <div class="fw-bold text-adaptive-title">Isi Form Pengajuan</div>
                            <div class="text-adaptive-muted small">Tentukan barang yang dibutuhkan, tanggal peminjaman, serta estimasi tanggal pengembalian.</div>
                        </div>
                    </div>

                    {{-- Langkah 3 --}}
                    <div class="d-flex align-items-start gap-3 p-3 rounded-3" style="background: rgba(168, 85, 247, 0.05); border: 1px solid rgba(168, 85, 247, 0.2);">
                        <span class="badge rounded-circle p-2 px-3 fw-bold fs-6" style="background: #8b5cf6; color: #ffffff;">3</span>
                        <div>
                            <div class="fw-bold text-adaptive-title">Persetujuan &amp; Serah Terima</div>
                            <div class="text-adaptive-muted small">Petugas memverifikasi izin. Setelah disetujui, barang dapat diambil di ruang sarpras.</div>
                        </div>
                    </div>

                    {{-- Langkah 4 --}}
                    <div class="d-flex align-items-start gap-3 p-3 rounded-3" style="background: rgba(168, 85, 247, 0.05); border: 1px solid rgba(168, 85, 247, 0.2);">
                        <span class="badge rounded-circle p-2 px-3 fw-bold fs-6" style="background: #8b5cf6; color: #ffffff;">4</span>
                        <div>
                            <div class="fw-bold text-adaptive-title">Pengembalian Tepat Waktu</div>
                            <div class="text-adaptive-muted small">Kembalikan unit tepat waktu dalam kondisi bersih agar status pinjam otomatis selesai.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 5. FAQ --}}
    <div class="mb-5">
        <span class="section-tag">Pusat Bantuan</span>
        <h2 class="fw-bold text-adaptive-title mb-4">Pertanyaan Umum (FAQ)</h2>

        <div class="accordion" id="faqAccordion">
            <div class="accordion-item card-dark-custom mb-3 p-0 overflow-hidden">
                <h2 class="accordion-header" id="faq1">
                    <button class="accordion-button collapsed bg-transparent text-adaptive-title fw-bold shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFaq1">
                        Siapa saja yang boleh meminjam alat sekolah?
                    </button>
                </h2>
                <div id="collapseFaq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-adaptive-body small pt-0">
                        Seluruh siswa, guru, dan staf sekolah yang memiliki akun terdaftar dapat mengajukan peminjaman untuk keperluan kegiatan pembelajaran, tugas, maupun ekstrakurikuler.
                    </div>
                </div>
            </div>

            <div class="accordion-item card-dark-custom mb-3 p-0 overflow-hidden">
                <h2 class="accordion-header" id="faq2">
                    <button class="accordion-button collapsed bg-transparent text-adaptive-title fw-bold shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFaq2">
                        Berapa lama batas durasi peminjaman barang?
                    </button>
                </h2>
                <div id="collapseFaq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-adaptive-body small pt-0">
                        Durasi peminjaman standar disesuaikan dengan jadwal jam sekolah. Peminjaman lebih dari 1 hari wajib mencantumkan alasan keperluan dan mendapat persetujuan petugas.
                    </div>
                </div>
            </div>

            <div class="accordion-item card-dark-custom mb-3 p-0 overflow-hidden">
                <h2 class="accordion-header" id="faq3">
                    <button class="accordion-button collapsed bg-transparent text-adaptive-title fw-bold shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFaq3">
                        Bagaimana jika barang mengalami kerusakan saat dipinjam?
                    </button>
                </h2>
                <div id="collapseFaq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-adaptive-body small pt-0">
                        Peminjam wajib langsung melaporkan kendala fisik atau fungsi barang kepada petugas sarpras saat dikembalikan untuk penanganan sesuai ketentuan sekolah.
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection