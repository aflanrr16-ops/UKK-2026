<nav class="navbar navbar-expand-lg bg-body border-bottom sticky-top">
    <div class="container">
        <div class="d-flex align-items-center gap-2">
            @php
                $dbConnected = false;
                try {
                    \Sakuci\Database\Connection::pdo();
                    $dbConnected = true;
                } catch (\Throwable $e) {
                    $dbConnected = false;
                }
                $currentUser = \App\Models\User::current();
            @endphp

            {{-- 1. TOMBOL GARIS TIGA (HANYA MUNCUL JIKA USER ADALAH ADMIN) --}}
            @if ($currentUser && $currentUser->role === 'admin')
                <button class="btn btn-sm btn-outline-secondary me-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminSidebar" aria-controls="adminSidebar" title="Menu Admin">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
            @endif

            {{-- Tombol Toggle Tema/Status DB --}}
            <button id="themeToggle" type="button" class="logo-toggle"
                    aria-label="Ganti tema terang/gelap (status database: {{ $dbConnected ? 'terhubung' : 'tidak terhubung' }})"
                    title="Ganti tema terang/gelap">
                <svg width="28" height="28" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="display: block;" aria-hidden="true">
                    <circle class="logo-ring" cx="16" cy="16" r="15"/>
                    <circle cx="16" cy="16" r="9" fill="{{ $dbConnected ? '#117064' : '#dc3545' }}"/>
                </svg>
            </button>
            
            <a class="navbar-brand fw-semibold m-0" href="{{ route('home') }}">{{ config('app.name') }}</a>
        </div>

        {{-- Tombol Toggle Garis Tiga (Untuk Tampilan Mobile Layar Kecil) --}}
        <button class="navbar-toggler border-0 shadow-none p-2" type="button"
                data-bs-toggle="collapse" data-bs-target="#menuUtama"
                aria-controls="menuUtama" aria-expanded="false" aria-label="Buka menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Menu Utama Aplikasi --}}
        <div class="collapse navbar-collapse" id="menuUtama">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                {{-- Beranda SELALU TAMPIL untuk siapa saja --}}
                <li class="nav-item">
                    <a class="nav-link {{ is_route('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                </li>

                {{-- HANYA TAMPIL JIKA SUDAH LOGIN --}}
                @if ($currentUser)
                    <li class="nav-item">
                        <a class="nav-link {{ is_route('admin.dashboard', 'dashboard') ? 'active' : '' }}"
                           href="{{ $currentUser->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-lg-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-secondary w-100 mt-2 mt-lg-0">Logout ({{ $currentUser->username }})</button>
                        </form>
                    </li>
                {{-- HANYA TAMPIL JIKA BELUM LOGIN --}}
                @else
                    @php
                        $canRegister = false;
                        if ($dbConnected) {
                            try {
                                $canRegister = \App\Models\Role::where('can_register', 1)->exists();
                            } catch (\Throwable $e) {
                                $canRegister = false;
                            }
                        }
                    @endphp
                    @if ($canRegister)
                        <li class="nav-item">
                            <a class="nav-link {{ is_route('register') ? 'active' : '' }}" href="{{ route('register') }}">Daftar</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="btn btn-sm btn-brand rounded-pill px-3 d-inline-flex align-items-center gap-2 mt-2 mt-lg-0" href="{{ route('login') }}">
                            <svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="8" cy="5" r="3" fill="currentColor" stroke="none"/>
                                <path d="M2.5 14c0-3.6 2.9-5.8 5.5-5.8s5.5 2.2 5.5 5.8"/>
                            </svg>
                            Masuk
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

{{-- 2. DRAWER / SIDEOFFCANVAS MENU ADMIN --}}
@if (isset($currentUser) && $currentUser->role === 'admin')
    <div class="offcanvas offcanvas-start bg-white text-dark" tabindex="-1" id="adminSidebar" aria-labelledby="adminSidebarLabel" style="max-width: 80vw;">
        <!-- Header Offcanvas -->
        <div class="offcanvas-header border-bottom py-3">
            <div class="d-flex align-items-center gap-2">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#0d6efd" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M12 14l3-3"></path>
                    <path d="M3.34 19a10 10 0 1 1 17.32 0"></path>
                </svg>
                <h5 class="offcanvas-title fw-bold mb-0 text-dark" id="adminSidebarLabel">Menu Admin</h5>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <!-- Body Offcanvas -->
        <div class="offcanvas-body px-3 py-3">
            <p class="text-muted small mb-4">Pintasan cepat pengelolaan sistem {{ config('app.name') }}:</p>

            <div class="d-flex flex-column gap-3">
                {{-- Kelola Kategori --}}
                <a href="{{ route('kategori.index') }}" class="text-decoration-none d-flex align-items-center gap-3 text-primary fw-semibold py-1">
                    <div class="d-flex align-items-center justify-content-center">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                            <line x1="7" y1="7" x2="7.01" y2="7"></line>
                        </svg>
                    </div>
                    <span>Kelola Kategori</span>
                </a>

                {{-- Kelola Alat --}}
                <a href="{{ route('alat.index') }}" class="text-decoration-none d-flex align-items-center gap-3 text-success fw-semibold py-1">
                    <div class="d-flex align-items-center justify-content-center">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                    </div>
                    <span>Kelola Alat</span>
                </a>

                {{-- Data Peminjaman --}}
                <a href="{{ route('peminjaman.index') }}" class="text-decoration-none d-flex align-items-center gap-3 text-warning fw-semibold py-1">
                    <div class="d-flex align-items-center justify-content-center">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="7 10 12 15 17 10"></polyline>
                            <line x1="12" y1="15" x2="12" y2="3"></line>
                        </svg>
                    </div>
                    <span>Data Peminjaman</span>
                </a>

                {{-- Data Pengembalian --}}
                <a href="{{ route('peminjaman.index') }}" class="text-decoration-none d-flex align-items-center gap-3 text-info fw-semibold py-1">
                    <div class="d-flex align-items-center justify-content-center">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="17 8 12 3 7 8"></polyline>
                            <line x1="12" y1="3" x2="12" y2="15"></line>
                        </svg>
                    </div>
                    <span>Data Pengembalian</span>
                </a>
            </div>
        </div>
    </div>
@endif