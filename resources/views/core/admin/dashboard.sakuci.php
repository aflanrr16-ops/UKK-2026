@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

    {{-- Banner Welcome Admin --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background: linear-gradient(135deg, rgba(17, 112, 100, 0.15) 0%, rgba(30, 41, 59, 0.4) 100%); backdrop-filter: blur(8px);">
        <div class="card-body p-4 p-lg-5 d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2 fw-semibold">
                        <i class="bi bi-shield-check me-1"></i> Area Admin
                    </span>
                    <span class="badge rounded-pill bg-secondary-subtle text-secondary px-3 py-2">
                        Middleware: admin
                    </span>
                </div>
                <h1 class="h3 fw-bold mb-2">Selamat Datang Kembali, {{ $user->username }}! 👋</h1>
                <p class="text-secondary mb-0">Kelola sistem, hak akses pengguna, serta cadangan database aplikasi Anda dari panel kontrol ini.</p>
            </div>
            <div class="d-none d-md-block">
                <div class="p-3 bg-body rounded-circle shadow-sm border opacity-75">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-success">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        <path d="m9 12 2 2 4-4"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Judul Seksi Quick Menu --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="h6 text-uppercase tracking-wider text-secondary fw-bold mb-0">Menu Pengelolaan</h2>
    </div>

    {{-- Grid Menu Navigasi Admin --}}
    <div class="row g-4">
        
        {{-- Card 1: Manage Role --}}
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('admin.roles.index') }}" class="card border-0 shadow-sm rounded-4 text-decoration-none h-100 card-admin-item transition-all">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="icon-box rounded-3 bg-primary-subtle text-primary p-3 d-inline-flex align-items-center justify-content-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>
                            </div>
                            <span class="badge bg-body-tertiary text-secondary rounded-pill border px-2 py-1 small">Role & Hak Akses</span>
                        </div>
                        <h3 class="h5 fw-bold text-body mb-2">Manage Role</h3>
                        <p class="text-secondary small mb-0">Tambah, ubah, atau atur peran (role) pengguna untuk mengatur batasan hak akses sistem.</p>
                    </div>
                    <div class="mt-4 pt-2 border-top d-flex align-items-center text-primary fw-semibold small">
                        <span>Buka Pengaturan Role</span>
                        <svg class="ms-auto arrow-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </div>
                </div>
            </a>
        </div>

        {{-- Card 2: Manage User --}}
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('admin.users.index') }}" class="card border-0 shadow-sm rounded-4 text-decoration-none h-100 card-admin-item transition-all">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="icon-box rounded-3 bg-info-subtle text-info p-3 d-inline-flex align-items-center justify-content-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                            </div>
                            <span class="badge bg-body-tertiary text-secondary rounded-pill border px-2 py-1 small">Pengguna</span>
                        </div>
                        <h3 class="h5 fw-bold text-body mb-2">Manage User</h3>
                        <p class="text-secondary small mb-0">Kelola akun pengguna terdaftar, buat akun baru, serta sesuaikan penetapan role masing-masing.</p>
                    </div>
                    <div class="mt-4 pt-2 border-top d-flex align-items-center text-info fw-semibold small">
                        <span>Kelola Daftar User</span>
                        <svg class="ms-auto arrow-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </div>
                </div>
            </a>
        </div>

        {{-- Card 3: Download Database --}}
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('admin.database.export') }}" class="card border-0 shadow-sm rounded-4 text-decoration-none h-100 card-admin-item transition-all">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="icon-box rounded-3 bg-warning-subtle text-warning p-3 d-inline-flex align-items-center justify-content-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <ellipse cx="12" cy="5" rx="9" ry="3"/>
                                    <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/>
                                    <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>
                                </svg>
                            </div>
                            <span class="badge bg-body-tertiary text-secondary rounded-pill border px-2 py-1 small">Backup .SQL</span>
                        </div>
                        <h3 class="h5 fw-bold text-body mb-2">Download Database</h3>
                        <p class="text-secondary small mb-0">Unduh seluruh cadangan data aplikasi ke format file <code>.sql</code> yang siap diimpor di server.</p>
                    </div>
                    <div class="mt-4 pt-2 border-top d-flex align-items-center text-warning fw-semibold small">
                        <span>Ekspor File Database</span>
                        <svg class="ms-auto arrow-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="7 10 12 15 17 10"></polyline>
                            <line x1="12" y1="15" x2="12" y2="3"></line>
                        </svg>
                    </div>
                </div>
            </a>
        </div>

    </div>

    {{-- Styling CSS Tambahan untuk Animasi Hover Card --}}
    <style>
        .card-admin-item {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
        }
        .card-admin-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px -10px rgba(0, 0, 0, 0.3) !important;
        }
        .card-admin-item:hover .arrow-icon {
            transform: translateX(4px);
            transition: transform 0.2s ease;
        }
        .icon-box {
            width: 48px;
            height: 48px;
        }
    </style>

@endsection