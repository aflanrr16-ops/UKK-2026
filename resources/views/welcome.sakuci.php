@extends('layouts.app')

@section('title', config('app.name') . ' -- Portal Peminjaman Alat & Inventaris Sekolah')

@section('content')

    {{-- Hero Section: Clean Academic & Modern Tech Vibe --}}
    <section class="d-flex align-items-center justify-content-center min-vh-100 py-5 position-relative overflow-hidden" 
             style="background: linear-gradient(135deg, #f0f4f8 0%, #e2e8f0 100%); color: #1e293b;">
        
        {{-- Background Geometric Shapes / Soft Blobs --}}
        <div class="position-absolute top-0 start-0 w-100 h-100 pointer-event-none opacity-40" 
             style="background-image: radial-gradient(#3b82f6 1px, transparent 1px); background-size: 32px 32px; z-index: 0;"></div>
        
        <div class="container position-relative py-5" style="z-index: 1;">
            <div class="row align-items-center g-5">
                
                {{-- Kolom Kiri: Teks & Aksi Utama --}}
                <div class="col-lg-6 text-center text-lg-start">
                    
                    {{-- Badge Status Sekolah --}}
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 mb-4 rounded-pill bg-white shadow-sm border border-primary border-opacity-25">
                        <span class="badge bg-primary rounded-pill px-2 py-1">RESMI SEKOLAH</span>
                        <span class="fw-semibold small text-primary">Sistem Inventaris & Lab Terpadu</span>
                    </div>

                    {{-- Heading Utama --}}
                    <h1 class="display-4 fw-bold mb-4 text-dark lh-tight" style="letter-spacing: -0.02em;">
                        Pinjam Alat Praktikum & Sekolah Jadi <span class="text-primary position-relative">Lebih Tertib<span class="position-absolute bottom-0 start-0 w-100 bg-warning opacity-25 rounded" style="height: 8px; z-index: -1;"></span></span>
                    </h1>

                    {{-- Subtitle --}}
                    <p class="lead mb-4 text-muted" style="font-size: 1.1rem; line-height: 1.7;">
                        Platform digital peminjaman inventaris sekolah mulai dari alat laboratorium sains, perangkat multimedia, hingga perlengkapan olahraga. Cepat, transparan, dan terdata rapi.
                    </p>

                    {{-- Tombol Aksi --}}
                    <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start gap-3 mb-5">
                        <a href="/peminjaman" class="btn btn-primary px-4 py-3 fw-semibold shadow rounded-pill d-inline-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-box-seam fs-5"></i>Ajukan Peminjaman
                        </a>
                        <a href="/riwayat" class="btn btn-outline-dark px-4 py-3 fw-semibold rounded-pill d-inline-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-clock-history fs-5"></i>Cek Status Barang
                        </a>
                    </div>

                    {{-- Statistik Singkat Sekolah --}}
                    <div class="row text-start g-3 pt-3 border-top border-secondary border-opacity-10">
                        <div class="col-4">
                            <h4 class="fw-bold text-primary mb-0">500+</h4>
                            <small class="text-muted fw-medium">Item Tersedia</small>
                        </div>
                        <div class="col-4">
                            <h4 class="fw-bold text-success mb-0">100%</h4>
                            <small class="text-muted fw-medium">Tercatat Sistem</small>
                        </div>
                        <div class="col-4">
                            <h4 class="fw-bold text-warning mb-0">24/7</h4>
                            <small class="text-muted fw-medium">Akses Portal</small>
                        </div>
                    </div>

                </div>

                {{-- Kolom Kanan: Ilustrasi Kartu / Panel Interaktif Sekolah --}}
                <div class="col-lg-6">
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white p-2">
                        <div class="card-body p-4 p-lg-5 bg-light rounded-4">
                            
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h5 class="fw-bold text-dark m-0"><i class="bi bi-grid-fill text-primary me-2"></i>Kategori Inventaris</h5>
                                <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill small fw-semibold">Status: Ready</span>
                            </div>

                            <div class="row g-3">
                                {{-- Item Lab --}}
                                <div class="col-12">
                                    <div class="p-3 bg-white rounded-3 shadow-sm d-flex align-items-center gap-3 border-start border-4 border-primary">
                                        <div class="bg-primary-subtle text-primary p-2 rounded-2">
                                            <i class="bi bi-eyedropper fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1 text-dark">Alat Laboratorium (Sains & Komputer)</h6>
                                            <p class="small text-muted mb-0">Mikroskop, Tabung Reaksi, Proyektor, Laptop Lab.</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Item Olahraga --}}
                                <div class="col-12">
                                    <div class="p-3 bg-white rounded-3 shadow-sm d-flex align-items-center gap-3 border-start border-4 border-success">
                                        <div class="bg-success-subtle text-success p-2 rounded-2">
                                            <i class="bi bi-trophy fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1 text-dark">Perlengkapan Olahraga & Ekstrakurikuler</h6>
                                            <p class="small text-muted mb-0">Bola Basket, Raket Badminton, Matras Senam.</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Item Multimedia --}}
                                <div class="col-12">
                                    <div class="p-3 bg-white rounded-3 shadow-sm d-flex align-items-center gap-3 border-start border-4 border-warning">
                                        <div class="bg-warning-subtle text-warning p-2 rounded-2">
                                            <i class="bi bi-camera-video fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1 text-dark">Media Pembelajaran & Acara Sekolah</h6>
                                            <p class="small text-muted mb-0">Kamera DSLR, Sound System Portable, Mic Wireless.</p>
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

@push('styles')
<style>
    /* Styling Tambahan Khusus Tema Sekolah */
    .bg-primary-subtle { background-color: rgba(13, 110, 253, 0.1); }
    .bg-success-subtle { background-color: rgba(25, 135, 84, 0.1); }
    .bg-warning-subtle { background-color: rgba(255, 193, 7, 0.1); }
    
    .card {
        transition: transform 0.3s ease;
    }
    .card:hover {
        transform: translateY(-4px);
    }
</style>
@endpush